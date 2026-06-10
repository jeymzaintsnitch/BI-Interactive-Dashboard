<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates all tables required by the Business Intelligence Dashboard.
     */
    public function up(): void
    {
        // ── Dimension: Customers (Star-Schema Dimension) ──────────────
        Schema::create('dim_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_key')->unique();
            $table->string('customer_name');
            $table->string('city');
            $table->string('country');
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->timestamps();
        });

        // ── Transactional: Customers (Payments relation) ──────────────
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerNumber')->unique();
            $table->string('customerName');
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });

        // ── Dimension: Products ───────────────────────────────────────
        Schema::create('dim_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_key')->unique();
            $table->string('product_name');
            $table->unsignedInteger('product_line');
            $table->decimal('buy_price', 15, 2)->default(0);
            $table->timestamps();
        });

        // ── Dimension: Offices ────────────────────────────────────────
        Schema::create('dim_offices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_key')->unique();
            $table->string('employee_name');
            $table->string('job_title');
            $table->string('office_code');
            $table->string('office_city');
            $table->timestamps();
        });

        // ── Fact: Sales (Central Fact Table) ──────────────────────────
        Schema::create('fact_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_key');
            $table->string('product_key');
            $table->unsignedBigInteger('employee_key');
            $table->date('order_date');
            $table->string('status')->default('Completed');
            $table->unsignedInteger('quantity_ordered');
            $table->decimal('price_each', 15, 2);
            $table->decimal('total_sales_amount', 15, 2);
            $table->decimal('total_payment_amount', 15, 2);
            $table->timestamps();

            $table->index('customer_key');
            $table->index('product_key');
            $table->index('employee_key');
            $table->index('order_date');
        });

        // ── Transactional: Payments ───────────────────────────────────
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerNumber');
            $table->string('checkNumber');
            $table->date('paymentDate');
            $table->decimal('amount', 15, 2);
            $table->timestamps();

            $table->index('customerNumber');
            $table->index('paymentDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('fact_sales');
        Schema::dropIfExists('dim_offices');
        Schema::dropIfExists('dim_products');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('dim_customers');
    }
};
