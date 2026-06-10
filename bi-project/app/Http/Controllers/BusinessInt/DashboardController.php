<?php 

namespace App\Http\Controllers\BusinessInt;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard');
    }

    public function Dashboard(Request $request) 
    {
        // Automatically seed demo data if the tables are empty, or if specifically requested
        if ($request->has('seed') || DB::table('dim_customers')->count() === 0) {
            $this->seedDemoData();
            if ($request->has('seed')) {
                return redirect('/Dashboard')->with('success', '🇵🇭 Mabuhay! McDonald\'s Philippine Franchise demo data has been loaded successfully!');
            }
        }

        // 1. Get request parameters for interactive filters
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $location = $request->input('location');
        $period = $request->input('period', 'custom');
        $year = $request->input('year', '2026'); // default to 2026

        // 2. Handle Quarterly, Semi-Annually, and Annually filters
        if ($period === 'quarterly') {
            $quarter = $request->input('quarter', 'Q1');
            if ($quarter === 'Q1') {
                $startDate = "$year-01-01";
                $endDate = "$year-03-31";
            } elseif ($quarter === 'Q2') {
                $startDate = "$year-04-01";
                $endDate = "$year-06-30";
            } elseif ($quarter === 'Q3') {
                $startDate = "$year-07-01";
                $endDate = "$year-09-30";
            } else {
                $startDate = "$year-10-01";
                $endDate = "$year-12-31";
            }
        } elseif ($period === 'semi-annually') {
            $half = $request->input('half', 'H1');
            if ($half === 'H1') {
                $startDate = "$year-01-01";
                $endDate = "$year-06-30";
            } else {
                $startDate = "$year-07-01";
                $endDate = "$year-12-31";
            }
        } elseif ($period === 'annually') {
            $startDate = "$year-01-01";
            $endDate = "$year-12-31";
        }

        // Fetch unique cities from both tables dynamically
        $dimCities = DB::table('dim_customers')
            ->whereNotNull('city')
            ->where('city', '<>', '')
            ->distinct()
            ->pluck('city');

        $custCities = DB::table('customers')
            ->whereNotNull('city')
            ->where('city', '<>', '')
            ->distinct()
            ->pluck('city');

        $citiesList = $dimCities->merge($custCities)
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // 3. Query 1: Office With The Best Sales Support
        $topOfficesQuery = DB::table('fact_sales')
            ->join('dim_offices', 'fact_sales.employee_key', '=', 'dim_offices.employee_key')
            ->select(
                'dim_offices.office_code as officeCode',
                'dim_offices.employee_name as employeeName',
                DB::raw('SUM(fact_sales.total_sales_amount) as officeTotal')
            );

        if ($location) {
            $topOfficesQuery->join('dim_customers', 'fact_sales.customer_key', '=', 'dim_customers.customer_key')
                ->where('dim_customers.city', $location);
        }
        if ($startDate) {
            $topOfficesQuery->where('fact_sales.order_date', '>=', $startDate);
        }
        if ($endDate) {
            $topOfficesQuery->where('fact_sales.order_date', '<=', $endDate);
        }

        $topOffices = $topOfficesQuery
            ->groupBy('dim_offices.office_code', 'dim_offices.employee_name')
            ->orderByDesc('officeTotal')
            ->get();

        $officeCode = $topOffices->pluck('officeCode')->toArray();
        $officeTotal = $topOffices->pluck('officeTotal')->toArray();

        // 4. Query 2: City With The Best Market Sale
        $topCityQuery = DB::table('fact_sales')
            ->join('dim_customers', 'fact_sales.customer_key', '=', 'dim_customers.customer_key')
            ->select(
                'dim_customers.city',
                DB::raw('SUM(fact_sales.total_sales_amount) as totalPaid')
            );

        if ($location) {
            $topCityQuery->where('dim_customers.city', $location);
        }
        if ($startDate) {
            $topCityQuery->where('fact_sales.order_date', '>=', $startDate);
        }
        if ($endDate) {
            $topCityQuery->where('fact_sales.order_date', '<=', $endDate);
        }

        $topCity = $topCityQuery
            ->groupBy('dim_customers.city')
            ->orderByDesc('totalPaid')
            ->get();

        $city = $topCity->pluck('city')->toArray();
        $cityHighestTotal = $topCity->pluck('totalPaid')->toArray();

        // 5. Query 3: Products With The Highest Market Sale
        $topProductsQuery = DB::table('fact_sales')
            ->join('dim_products', 'fact_sales.product_key', '=', 'dim_products.product_key')
            ->select(
                'dim_products.product_name as productName',
                DB::raw('SUM(fact_sales.total_sales_amount) as totalSales')
            );

        if ($location) {
            $topProductsQuery->join('dim_customers', 'fact_sales.customer_key', '=', 'dim_customers.customer_key')
                ->where('dim_customers.city', $location);
        }
        if ($startDate) {
            $topProductsQuery->where('fact_sales.order_date', '>=', $startDate);
        }
        if ($endDate) {
            $topProductsQuery->where('fact_sales.order_date', '<=', $endDate);
        }

        $topProducts = $topProductsQuery
            ->groupBy('dim_products.product_name')
            ->orderByDesc('totalSales')
            ->get();

        $productNames = $topProducts->pluck('productName')->toArray();
        $productSales = $topProducts->pluck('totalSales')->toArray();

        // 6. Query 4: Payments List & Summary
        $paymentsQuery = DB::table('payments')
            ->join('customers', 'payments.customerNumber', '=', 'customers.customerNumber')
            ->select(
                'customers.customerNumber',
                'customers.city',
                'customers.customerName',
                'customers.country',
                'payments.checkNumber',
                'payments.paymentDate',
                'payments.amount'
            );

        if ($location) {
            $paymentsQuery->where('customers.city', $location);
        }
        if ($startDate) {
            $paymentsQuery->where('payments.paymentDate', '>=', $startDate);
        }
        if ($endDate) {
            $paymentsQuery->where('payments.paymentDate', '<=', $endDate);
        }

        $payments = $paymentsQuery
            ->orderByDesc('payments.amount')
            ->get();

        // 7. Query 5: Region Sales Allocation (Pie Chart) - country column maps to Regions in our seed
        $countryAllocationQuery = DB::table('payments')
            ->join('customers', 'payments.customerNumber', '=', 'customers.customerNumber')
            ->select(
                'customers.country as region',
                DB::raw('SUM(payments.amount) as regionTotal')
            );

        if ($location) {
            $countryAllocationQuery->where('customers.city', $location);
        }
        if ($startDate) {
            $countryAllocationQuery->where('payments.paymentDate', '>=', $startDate);
        }
        if ($endDate) {
            $countryAllocationQuery->where('payments.paymentDate', '<=', $endDate);
        }

        $countryAllocation = $countryAllocationQuery
            ->groupBy('customers.country')
            ->orderByDesc('regionTotal')
            ->get();

        $countryLabels = $countryAllocation->pluck('region')->toArray();
        $countryTotals = $countryAllocation->pluck('regionTotal')->toArray();
        
        return view('BusinessInt(View).Display', compact(
            'payments',
            'officeCode',
            'officeTotal',
            'city',
            'cityHighestTotal',
            'productNames',
            'productSales',
            'citiesList',
            'startDate',
            'endDate',
            'location',
            'period',
            'year',
            'countryLabels',
            'countryTotals'
        ));
    }

    /**
     * Seeds custom Philippine-based gadget market data for the year 2026
     */
    private function seedDemoData()
    {
        // 1. Clear existing if any
        DB::table('fact_sales')->delete();
        DB::table('payments')->delete();
        DB::table('dim_customers')->delete();
        DB::table('customers')->delete();
        DB::table('dim_products')->delete();
        DB::table('dim_offices')->delete();

        // 2. Seed Dim Customers & Customers (McDonald's Philippine Branches)
        // Grouped by Luzon, Visayas, Mindanao island regions
        $customersData = [
            // NCR Cities (Luzon)
            ['key' => 101, 'name' => "McDonald's SM North EDSA", 'city' => 'Quezon City', 'country' => 'Luzon', 'limit' => 2000000.00],
            ['key' => 102, 'name' => "McDonald's BGC Forum", 'city' => 'Taguig City', 'country' => 'Luzon', 'limit' => 2500000.00],
            ['key' => 103, 'name' => "McDonald's Greenbelt", 'city' => 'Makati City', 'country' => 'Luzon', 'limit' => 3000000.00],
            ['key' => 104, 'name' => "McDonald's Taft Avenue", 'city' => 'Manila', 'country' => 'Luzon', 'limit' => 1500000.00],
            ['key' => 105, 'name' => "McDonald's Ortigas", 'city' => 'Pasig', 'country' => 'Luzon', 'limit' => 1800000.00],
            ['key' => 106, 'name' => "McDonald's Shaw Boulevard", 'city' => 'Mandaluyong', 'country' => 'Luzon', 'limit' => 1700000.00],
            ['key' => 107, 'name' => "McDonald's Bicutan", 'city' => 'Parañaque', 'country' => 'Luzon', 'limit' => 1400000.00],
            ['key' => 108, 'name' => "McDonald's Alabang Town Center", 'city' => 'Muntinlupa', 'country' => 'Luzon', 'limit' => 2200000.00],
            ['key' => 109, 'name' => "McDonald's McArthur Highway", 'city' => 'Valenzuela', 'country' => 'Luzon', 'limit' => 1200000.00],
            ['key' => 110, 'name' => "McDonald's Monumento", 'city' => 'Caloocan', 'country' => 'Luzon', 'limit' => 1300000.00],
            ['key' => 111, 'name' => "McDonald's Marcos Highway", 'city' => 'Marikina', 'country' => 'Luzon', 'limit' => 1100000.00],
            ['key' => 112, 'name' => "McDonald's Greenhills", 'city' => 'San Juan', 'country' => 'Luzon', 'limit' => 1600000.00],
            ['key' => 113, 'name' => "McDonald's Malabon Citiland", 'city' => 'Malabon', 'country' => 'Luzon', 'limit' => 900000.00],
            ['key' => 114, 'name' => "McDonald's Navotas Center", 'city' => 'Navotas', 'country' => 'Luzon', 'limit' => 800000.00],
            ['key' => 115, 'name' => "McDonald's Pasay Rotonda", 'city' => 'Pasay', 'country' => 'Luzon', 'limit' => 1400000.00],
            ['key' => 116, 'name' => "McDonald's Pateros Hub", 'city' => 'Pateros', 'country' => 'Luzon', 'limit' => 700000.00],

            // CALABARZON Cities (Luzon)
            ['key' => 117, 'name' => "McDonald's Antipolo Bypass", 'city' => 'Antipolo', 'country' => 'Luzon', 'limit' => 1200000.00],
            ['key' => 118, 'name' => "McDonald's Calamba Crossing", 'city' => 'Calamba', 'country' => 'Luzon', 'limit' => 1500000.00],
            ['key' => 119, 'name' => "McDonald's Dasmariñas Cavite", 'city' => 'Dasmariñas', 'country' => 'Luzon', 'limit' => 1400000.00],
            ['key' => 120, 'name' => "McDonald's Bacoor Boulevard", 'city' => 'Bacoor', 'country' => 'Luzon', 'limit' => 1300000.00],
            ['key' => 121, 'name' => "McDonald's Tagaytay Ridge", 'city' => 'Tagaytay', 'country' => 'Luzon', 'limit' => 1600000.00],

            // Visayas Cities
            ['key' => 122, 'name' => "McDonald's Cebu IT Park", 'city' => 'Cebu City', 'country' => 'Visayas', 'limit' => 2200000.00],
            ['key' => 123, 'name' => "McDonald's Iloilo Diversion", 'city' => 'Iloilo City', 'country' => 'Visayas', 'limit' => 1800000.00],
            ['key' => 124, 'name' => "McDonald's Bacolod Lacson", 'city' => 'Bacolod City', 'country' => 'Visayas', 'limit' => 1700000.00],

            // Mindanao Cities
            ['key' => 125, 'name' => "McDonald's Bajada Davao", 'city' => 'Davao City', 'country' => 'Mindanao', 'limit' => 2100000.00],
            ['key' => 126, 'name' => "McDonald's CDO Limketkai", 'city' => 'Cagayan de Oro', 'country' => 'Mindanao', 'limit' => 1600000.00],
            ['key' => 127, 'name' => "McDonald's Zamboanga Mayor Jaldon", 'city' => 'Zamboanga', 'country' => 'Mindanao', 'limit' => 1200000.00],
        ];

        foreach ($customersData as $c) {
            DB::table('dim_customers')->insert([
                'customer_key' => $c['key'],
                'customer_name' => $c['name'],
                'city' => $c['city'],
                'country' => $c['country'],
                'credit_limit' => $c['limit'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('customers')->insert([
                'customerNumber' => $c['key'],
                'customerName' => $c['name'],
                'city' => $c['city'],
                'country' => $c['country'],
            ]);
        }

        // 3. Seed Dim Products (McDonald's Popular Menu Items)
        $productsData = [
            ['key' => 'P001', 'name' => 'Big Mac Double Meal', 'line' => 1, 'price' => 249.00],
            ['key' => 'P002', 'name' => '2pc Chicken McDo with Rice & Drink', 'line' => 1, 'price' => 189.00],
            ['key' => 'P003', 'name' => 'Cheeseburger Deluxe Solo', 'line' => 2, 'price' => 119.00],
            ['key' => 'P004', 'name' => 'Oreo McFlurry', 'line' => 3, 'price' => 69.00],
            ['key' => 'P005', 'name' => 'McCafé Premium Roast Iced Coffee', 'line' => 2, 'price' => 99.00],
            ['key' => 'P006', 'name' => 'World Famous Fries XL', 'line' => 3, 'price' => 149.00],
            ['key' => 'P007', 'name' => 'Sausage McMuffin with Egg Meal', 'line' => 4, 'price' => 179.00],
            ['key' => 'P008', 'name' => 'Happy Meal Chicken McNuggets', 'line' => 4, 'price' => 139.00],
        ];

        foreach ($productsData as $p) {
            DB::table('dim_products')->insert([
                'product_key' => $p['key'],
                'product_name' => $p['name'],
                'product_line' => $p['line'],
                'buy_price' => $p['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Seed Dim Offices (Regional Corporate HQ & Support Offices)
        $officesData = [
            ['key' => 201, 'name' => 'Ramon Valenzuela', 'title' => 'Luzon North Operations', 'code' => 'OF-NCRQC', 'city' => 'Quezon City'],
            ['key' => 202, 'name' => 'Maria Santos', 'title' => 'Luzon BGC Operations', 'code' => 'OF-NCRBGC', 'city' => 'Taguig City'],
            ['key' => 203, 'name' => 'Juan dela Cruz', 'title' => 'CALABARZON Lead', 'code' => 'OF-CALAM', 'city' => 'Calamba'],
            ['key' => 204, 'name' => 'Agnes Corpuz', 'title' => 'Visayas Region Lead', 'code' => 'OF-CEBU', 'city' => 'Cebu City'],
            ['key' => 205, 'name' => 'Carlito Ibañez', 'title' => 'Mindanao Region Lead', 'code' => 'OF-DAVAO', 'city' => 'Davao City'],
        ];

        foreach ($officesData as $o) {
            DB::table('dim_offices')->insert([
                'employee_key' => $o['key'],
                'employee_name' => $o['name'],
                'job_title' => $o['title'],
                'office_code' => $o['code'],
                'office_city' => $o['city'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. High Volume McDonald's Sales Transactions for 2026 (spanning all quarters)
        $salesData = [
            // Q1 2026
            ['cust' => 101, 'prod' => 'P001', 'emp' => 201, 'date' => '2026-01-12', 'qty' => 1500, 'price' => 249.00],
            ['cust' => 102, 'prod' => 'P002', 'emp' => 202, 'date' => '2026-01-25', 'qty' => 2500, 'price' => 189.00],
            ['cust' => 103, 'prod' => 'P003', 'emp' => 202, 'date' => '2026-02-05', 'qty' => 1800, 'price' => 119.00],
            ['cust' => 117, 'prod' => 'P006', 'emp' => 203, 'date' => '2026-02-14', 'qty' => 3000, 'price' => 149.00],
            ['cust' => 118, 'prod' => 'P004', 'emp' => 203, 'date' => '2026-03-02', 'qty' => 4500, 'price' => 69.00],
            ['cust' => 122, 'prod' => 'P002', 'emp' => 204, 'date' => '2026-03-18', 'qty' => 2000, 'price' => 189.00],
            ['cust' => 125, 'prod' => 'P007', 'emp' => 205, 'date' => '2026-03-29', 'qty' => 1600, 'price' => 179.00],

            // Q2 2026
            ['cust' => 104, 'prod' => 'P001', 'emp' => 201, 'date' => '2026-04-10', 'qty' => 1600, 'price' => 249.00],
            ['cust' => 105, 'prod' => 'P005', 'emp' => 202, 'date' => '2026-04-28', 'qty' => 3500, 'price' => 99.00],
            ['cust' => 119, 'prod' => 'P008', 'emp' => 203, 'date' => '2026-05-15', 'qty' => 2200, 'price' => 139.00],
            ['cust' => 120, 'prod' => 'P002', 'emp' => 203, 'date' => '2026-05-27', 'qty' => 2100, 'price' => 189.00],
            ['cust' => 123, 'prod' => 'P001', 'emp' => 204, 'date' => '2026-06-08', 'qty' => 1400, 'price' => 249.00],
            ['cust' => 126, 'prod' => 'P006', 'emp' => 205, 'date' => '2026-06-22', 'qty' => 2800, 'price' => 149.00],

            // Q3 2026
            ['cust' => 106, 'prod' => 'P003', 'emp' => 202, 'date' => '2026-07-05', 'qty' => 1900, 'price' => 119.00],
            ['cust' => 107, 'prod' => 'P004', 'emp' => 201, 'date' => '2026-07-21', 'qty' => 4800, 'price' => 69.00],
            ['cust' => 108, 'prod' => 'P006', 'emp' => 202, 'date' => '2026-08-14', 'qty' => 3200, 'price' => 149.00],
            ['cust' => 121, 'prod' => 'P002', 'emp' => 203, 'date' => '2026-09-02', 'qty' => 1950, 'price' => 189.00],
            ['cust' => 124, 'prod' => 'P007', 'emp' => 204, 'date' => '2026-09-18', 'qty' => 1500, 'price' => 179.00],
            ['cust' => 127, 'prod' => 'P001', 'emp' => 205, 'date' => '2026-09-29', 'qty' => 1300, 'price' => 249.00],

            // Q4 2026
            ['cust' => 109, 'prod' => 'P002', 'emp' => 201, 'date' => '2026-10-12', 'qty' => 2200, 'price' => 189.00],
            ['cust' => 110, 'prod' => 'P008', 'emp' => 201, 'date' => '2026-10-30', 'qty' => 2400, 'price' => 139.00],
            ['cust' => 111, 'prod' => 'P006', 'emp' => 201, 'date' => '2026-11-18', 'qty' => 3100, 'price' => 149.00],
            ['cust' => 112, 'prod' => 'P001', 'emp' => 201, 'date' => '2026-11-25', 'qty' => 1700, 'price' => 249.00],
            ['cust' => 113, 'prod' => 'P003', 'emp' => 201, 'date' => '2026-12-04', 'qty' => 1500, 'price' => 119.00],
            ['cust' => 114, 'prod' => 'P004', 'emp' => 201, 'date' => '2026-12-14', 'qty' => 4000, 'price' => 69.00],
            ['cust' => 115, 'prod' => 'P005', 'emp' => 201, 'date' => '2026-12-20', 'qty' => 3000, 'price' => 99.00],
            ['cust' => 116, 'prod' => 'P002', 'emp' => 201, 'date' => '2026-12-28', 'qty' => 2000, 'price' => 189.00],
        ];

        foreach ($salesData as $idx => $s) {
            $total = $s['qty'] * $s['price'];
            DB::table('fact_sales')->insert([
                'customer_key' => $s['cust'],
                'product_key' => $s['prod'],
                'employee_key' => $s['emp'],
                'order_date' => $s['date'],
                'status' => 'Completed',
                'quantity_ordered' => $s['qty'],
                'price_each' => $s['price'],
                'total_sales_amount' => $total,
                'total_payment_amount' => $total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('payments')->insert([
                'customerNumber' => $s['cust'],
                'checkNumber' => 'CK-' . (90000 + $idx),
                'paymentDate' => $s['date'],
                'amount' => $total,
            ]);
        }
    }
}
