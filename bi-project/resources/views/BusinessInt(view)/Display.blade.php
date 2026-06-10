@extends('Business_Template.main')

@section('content')
<!-- Include Bootstrap Icons and premium font -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Premium CSS Variables Supporting Light (Default White) and Dark Themes */
    :root {
        /* Premium Light Theme Variables (Default Full White) */
        --bg-main: #ffffff;
        --bg-card: #ffffff;
        --bg-card-hover: #f8fafc;
        --bg-filter: rgba(255, 255, 255, 0.9);
        --border-color: #e2e8f0;
        --border-hover: #cbd5e1;
        --text-main: #0f172a;
        --text-sub: #475569;
        --text-muted: #94a3b8;
        --bg-input: #f1f5f9;
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        --accent-glow: rgba(218, 41, 28, 0.06);
        --accent-gradient: linear-gradient(135deg, #da291c, #ffbc0d);
        --btn-secondary-bg: #f1f5f9;
        --btn-secondary-border: #e2e8f0;
        --btn-secondary-text: #334155;
        --badge-success-bg: rgba(16, 185, 129, 0.1);
        --badge-success-text: #10b981;
        --badge-info-bg: rgba(255, 188, 13, 0.1);
        --badge-info-text: #e29f00;
    }

    html.dark-theme {
        /* Premium Dark Theme Variables */
        --bg-main: #090d16;
        --bg-card: #111827;
        --bg-card-hover: #1f2937;
        --bg-filter: rgba(17, 24, 39, 0.9);
        --border-color: #1f2937;
        --border-hover: #374151;
        --text-main: #f8fafc;
        --text-sub: #94a3b8;
        --text-muted: #6b7280;
        --bg-input: #1f2937;
        --card-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        --accent-glow: rgba(255, 188, 13, 0.15);
        --accent-gradient: linear-gradient(135deg, #ffbc0d, #da291c);
        --btn-secondary-bg: #1f2937;
        --btn-secondary-border: #374151;
        --btn-secondary-text: #cbd5e1;
        --badge-success-bg: rgba(16, 185, 129, 0.2);
        --badge-success-text: #34d399;
        --badge-info-bg: rgba(255, 188, 13, 0.2);
        --badge-info-text: #ffbc0d;
    }

    .dash-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
    }

    /* Tab transitions and animations */
    .tab-pane-content {
        animation: tabFadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        display: none;
    }

    @keyframes tabFadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Complete Theming Overrides to ensure Dark Mode covers all areas */
    .table {
        background-color: transparent !important;
        color: var(--text-main) !important;
        border-color: var(--border-color) !important;
    }
    .table tbody tr {
        background-color: transparent !important;
        border-color: var(--border-color) !important;
    }
    .table td, .table th {
        background-color: transparent !important;
        color: var(--text-sub) !important;
        border-color: var(--border-color) !important;
    }
    .table thead th {
        color: var(--text-muted) !important;
        border-bottom: 2px solid var(--border-color) !important;
    }
    .modal-content {
        background-color: var(--bg-card) !important;
        color: var(--text-main) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: var(--card-shadow) !important;
    }
    .modal-header, .modal-footer {
        border-color: var(--border-color) !important;
        background-color: transparent !important;
    }
    .form-control, .form-select {
        background-color: var(--bg-input) !important;
        color: var(--text-main) !important;
        border-color: var(--border-color) !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #ffbc0d !important;
        box-shadow: 0 0 0 3px rgba(255, 188, 13, 0.25) !important;
    }

    /* Glassmorphic Filter Card */
    .filter-card {
        background: var(--bg-filter);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 24px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        margin-bottom: 1.8rem;
        box-shadow: var(--card-shadow);
        transition: all 0.4s ease;
    }

    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1.2rem;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 170px;
        flex-grow: 1;
    }

    .filter-group label {
        font-size: 0.72rem;
        font-weight: 800;
        color: var(--text-sub);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .filter-select, .filter-input {
        background: var(--bg-input);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 0.6rem 0.9rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        outline: none;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        height: 44px;
        width: 100%;
    }

    .filter-select:focus, .filter-input:focus {
        border-color: #ffbc0d;
        box-shadow: 0 0 0 3px rgba(255, 188, 13, 0.25);
        background: var(--bg-card);
    }

    .btn-action {
        height: 44px;
        padding: 0.6rem 1.5rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-action-primary {
        background: var(--accent-gradient);
        color: #ffffff !important;
    }

    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(218, 41, 28, 0.3);
    }

    .btn-action-secondary {
        background: var(--btn-secondary-bg);
        border: 1px solid var(--btn-secondary-border);
        color: var(--btn-secondary-text) !important;
    }

    .btn-action-secondary:hover {
        background: var(--bg-card-hover);
        transform: translateY(-2px);
    }

    /* Active Filter Summary Info Bar */
    .active-filters-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.8rem;
        background: var(--bg-card);
        border-radius: 16px;
        padding: 0.9rem 1.5rem;
        margin-bottom: 1.8rem;
        font-size: 0.88rem;
        color: var(--text-sub);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        transition: all 0.4s ease;
    }

    .active-filters-bar strong {
        color: #da291c;
    }

    .seed-data-link {
        color: #da291c;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.82rem;
        transition: all 0.25s ease;
        padding: 0.4rem 0.9rem;
        border-radius: 10px;
        border: 1px dashed rgba(218, 41, 28, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .seed-data-link:hover {
        color: #ffbc0d;
        background: rgba(218, 41, 28, 0.08);
        border-color: #ffbc0d;
        transform: scale(1.02);
    }

    /* Metric Cards Grid */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.8rem;
    }

    @media (max-width: 1200px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 600px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: var(--bg-card);
        border-radius: 24px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--border-hover);
        box-shadow: var(--card-shadow), 0 10px 20px var(--accent-glow);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, #da291c, #ffbc0d);
    }

    .stat-card:nth-child(2)::after {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .stat-card:nth-child(3)::after {
        background: linear-gradient(90deg, #ffbc0d, #f59e0b);
    }

    .stat-card:nth-child(4)::after {
        background: linear-gradient(90deg, #8b5cf6, #a78bfa);
    }

    .stat-card .stat-label {
        font-size: 0.78rem;
        color: var(--text-sub);
        margin-bottom: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat-card .stat-value {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.03em;
        line-height: 1.2;
    }

    /* Asymmetric Charts Grid */
    .chart-grid-2x2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.8rem;
    }

    @media (max-width: 992px) {
        .chart-grid-2x2 {
            grid-template-columns: 1fr;
        }
    }

    .dash-card {
        background: var(--bg-card) !important;
        border-radius: 24px;
        padding: 1.6rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .dash-card:hover {
        transform: translateY(-4px);
        border-color: var(--border-hover);
        box-shadow: var(--card-shadow), 0 0 25px var(--accent-glow);
    }

    .dash-card h5 {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: -0.01em;
    }

    .chart-box {
        height: 280px;
        position: relative;
    }

    /* Interactive List & Interactive Cards for Regions */
    .interactive-card {
        background: var(--bg-card) !important;
        color: var(--text-main) !important;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        padding: 1.4rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .interactive-card:hover {
        transform: scale(1.02) translateY(-3px);
        border-color: #da291c;
        background: var(--bg-card-hover) !important;
        box-shadow: var(--card-shadow), 0 8px 25px rgba(218, 41, 28, 0.1);
    }

    .interactive-card.selected {
        border-color: #da291c;
        background: var(--bg-card-hover) !important;
        box-shadow: 0 0 20px rgba(218, 41, 28, 0.15);
    }

    .interactive-card.selected::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: var(--accent-gradient);
    }

    /* Table styling with interactive glowing badges */
    .table-card {
        background: var(--bg-card) !important;
        border-radius: 24px;
        padding: 1.8rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        transition: all 0.4s ease;
        margin-bottom: 2rem;
    }

    .table-responsive-wrapper {
        overflow-x: auto;
        width: 100%;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        min-width: 800px;
    }

    .custom-table thead th {
        color: var(--text-muted);
        font-weight: 800;
        padding: 1rem;
        border-bottom: 2px solid var(--border-color);
        text-align: left;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.08em;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid var(--border-color);
        transition: background 0.25s ease;
    }

    .custom-table tbody tr:hover {
        background: var(--bg-card-hover);
        cursor: pointer;
    }

    .custom-table tbody td {
        padding: 1.1rem 1rem;
        color: var(--text-sub);
        font-weight: 500;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.3rem 0.8rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        background: var(--badge-success-bg);
        color: var(--badge-success-text);
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .status-badge::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        box-shadow: 0 0 10px currentColor;
    }

    /* Floating Toast Notification */
    .theme-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 0.9rem 1.6rem;
        border-radius: 16px;
        box-shadow: var(--card-shadow), 0 10px 40px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        font-size: 0.88rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    @keyframes toastSlideIn {
        from { transform: translateY(20px) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
</style>

<!-- MAIN DOCK WORKSPACE WRAPPER IN STANDARD ELEGANT CONTAINER -->
<div class="container my-4 dash-wrapper">

    {{-- Notification Alert Banner --}}
    @if(session('success'))
    <div class="alert-banner" style="background: linear-gradient(135deg, rgba(218, 41, 28, 0.1), rgba(218, 41, 28, 0.03)); border: 1px solid rgba(218, 41, 28, 0.3); border-radius: 16px; padding: 1rem 1.5rem; margin-bottom: 1.8rem; display: flex; justify-content: space-between; align-items: center; color: #da291c; font-weight: 700; backdrop-filter: blur(8px);">
        <span><i class="bi bi-stars me-2 text-warning animate-bounce"></i> {{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="alert-close" style="background: none; border: none; color: #da291c; font-size: 1.4rem; cursor: pointer; opacity: 0.7; transition: opacity 0.2s;">&times;</button>
    </div>
    @endif

    {{-- ==================== TAB 1: DASHBOARD HOME (OVERVIEW) ==================== --}}
    <div id="tab-overview" class="tab-pane-content" style="display: block;">
        {{-- Executive KPI Metrics directly answering Analytics Questions --}}
        <div class="stat-grid mt-2">
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-geo-alt-fill text-danger"></i> Which city is the best market?</div>
                <div class="stat-value" id="overview-best-city">{{ count($city) > 0 ? $city[0] : 'Quezon City' }}</div>
                <span class="small text-muted" style="font-size: 0.75rem;">Total Sales: <strong>₱{{ count($cityHighestTotal) > 0 ? number_format($cityHighestTotal[0], 2) : '0.00' }}</strong></span>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-egg-fried text-success"></i> Which product has highest sales?</div>
                <div class="stat-value" id="overview-best-product" style="font-size: 1.15rem; line-height: 1.3;">{{ count($productNames) > 0 ? $productNames[0] : '2pc Chicken McDo w/ Rice' }}</div>
                <span class="small text-muted" style="font-size: 0.75rem;">Revenue: <strong>₱{{ count($productSales) > 0 ? number_format($productSales[0], 2) : '0.00' }}</strong></span>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-award-fill text-warning"></i> Best HQ Sales Support Office?</div>
                <div class="stat-value" id="overview-best-office">{{ count($officeCode) > 0 ? $officeCode[0] : 'OF-NCRQC' }}</div>
                <span class="small text-muted" style="font-size: 0.75rem;">Supported Value: <strong>₱{{ count($officeTotal) > 0 ? number_format($officeTotal[0], 2) : '0.00' }}</strong></span>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-currency-exchange text-primary"></i> Total System Revenue</div>
                <div class="stat-value">₱{{ number_format($payments->sum('amount'), 2) }}</div>
                <div class="progress mt-2" style="height: 6px; background: rgba(0,0,0,0.1); border-radius: 4px; overflow: hidden;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 72%;" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        {{-- Dynamic Active Filter Summary Info Bar --}}
        <div class="active-filters-bar">
            <span>
                <i class="bi bi-info-circle-fill text-primary me-2"></i> Current Data Focus: 
                <strong>2026 McDonald's Philippines Store Analytics (Luzon, Visayas, Mindanao)</strong>
            </span>
            <a href="{{ url('/Dashboard?seed=1') }}" class="seed-data-link" onclick="return confirm('Do you want to seed the database with McDonald\'s Philippine restaurant demo records?')">
                <i class="bi bi-database-fill-gear"></i> Restore PH Demo Data
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Chart 1 — Island Group Allocation -->
                <div class="dash-card h-100">
                    <h5><i class="bi bi-pie-chart-fill text-danger"></i> Island Group Market Share Allocation</h5>
                    <div class="chart-box" style="height: 350px;">
                        <canvas id="regionChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dash-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5><i class="bi bi-lightning-charge-fill text-warning"></i> Store BI Insights</h5>
                        <p class="text-muted small">Franchise transactions reflect high volumes of family meals and breakfast options across central Quezon City and BGC technohubs.</p>
                        
                        <div class="border-top pt-3 mt-3">
                            <span class="d-block small text-muted font-monospace uppercase fw-bold">Top Performing Region Group</span>
                            <h4 class="fw-bold mt-1 text-danger"><i class="bi bi-map me-1"></i> Luzon Island Group</h4>
                            <p class="small text-muted mb-0">Driven by dense McDonald's NCR store clusters.</p>
                        </div>
                    </div>
                    
                    <div class="border-top pt-3 mt-3">
                        <span class="d-block small text-muted font-monospace uppercase fw-bold">Highest Demand Menu Item</span>
                        <h4 class="fw-bold mt-1 text-success"><i class="bi bi-egg-fried me-1"></i> 2pc Chicken McDo with Rice</h4>
                        <p class="small text-muted mb-0">Remains the ultimate local favorite staple nationwide.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== TAB 2: OFFICES & HQs ==================== --}}
    <div id="tab-offices" class="tab-pane-content">
        <div class="row g-4 mb-4 mt-2">
            <!-- Offices support chart on the left -->
            <div class="col-lg-6">
                <div class="dash-card h-100">
                    <h5><i class="bi bi-building-fill text-warning"></i> Regional Corporate HQs Sales Support</h5>
                    <div class="chart-box">
                        <canvas id="officeChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Spotlight branch performance switcher on the right -->
            <div class="col-lg-6">
                <div class="dash-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5><i class="bi bi-stars text-danger"></i> Corporate HQs Spotlight</h5>
                        <p class="text-muted small">Select a regional operations headquarter to dynamically reveal director profiles, managers, and performance focus.</p>
                        
                        <div class="row g-2 mt-2">
                            <button class="btn btn-action btn-action-secondary col-md-4 active-branch-btn" id="btn-ncr-qc" onclick="focusNcrSpotlight('qc')">Luzon North</button>
                            <button class="btn btn-action btn-action-secondary col-md-4 active-branch-btn" id="btn-ncr-bgc" onclick="focusNcrSpotlight('bgc')">Luzon BGC</button>
                            <button class="btn btn-action btn-action-secondary col-md-4 active-branch-btn" id="btn-ncr-makati" onclick="focusNcrSpotlight('makati')">CALABARZON Lead</button>
                        </div>

                        <div class="mt-4 p-3 rounded-4" style="background: var(--bg-input); border: 1px solid var(--border-color);">
                            <h6 class="fw-bold mb-2 text-danger" id="spotlight-title">Luzon North HQ</h6>
                            <p class="text-muted small mb-3" id="spotlight-desc">Loading details...</p>
                            
                            <div class="d-flex justify-content-between text-start border-top pt-2 mt-2" style="border-color: var(--border-color) !important;">
                                <div>
                                    <span class="d-block small text-muted font-monospace uppercase">Operations Director</span>
                                    <strong class="small" id="spotlight-manager">Ramon Valenzuela</strong>
                                </div>
                                <div class="text-end">
                                    <span class="d-block small text-muted font-monospace uppercase">Top Performing Product</span>
                                    <strong class="small" id="spotlight-gadget">2pc Chicken McDo Meal</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Offices Table --}}
        <div class="table-card">
            <h5 class="mb-4"><i class="bi bi-building text-danger me-2"></i> Corporate Headquarters Sales Support Ledger</h5>
            <div class="table-responsive-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>HQ Office Code</th>
                            <th>HQ City Location</th>
                            <th>Assigned Operations Director</th>
                            <th>Island Group Region</th>
                            <th>Total Franchise Sales Supported</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>OF-NCRQC</strong></td>
                            <td>Quezon City</td>
                            <td>Ramon Valenzuela</td>
                            <td>Luzon</td>
                            <td><strong>₱{{ number_format(isset($officeTotal[0]) ? $officeTotal[0] : 1850000.00, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>OF-NCRBGC</strong></td>
                            <td>Taguig City</td>
                            <td>Maria Santos</td>
                            <td>Luzon</td>
                            <td><strong>₱{{ number_format(isset($officeTotal[1]) ? $officeTotal[1] : 1450000.00, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>OF-CALAM</strong></td>
                            <td>Calamba</td>
                            <td>Juan dela Cruz</td>
                            <td>Luzon</td>
                            <td><strong>₱{{ number_format(isset($officeTotal[2]) ? $officeTotal[2] : 950000.00, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>OF-CEBU</strong></td>
                            <td>Cebu City</td>
                            <td>Agnes Corpuz</td>
                            <td>Visayas</td>
                            <td><strong>₱{{ number_format(isset($officeTotal[3]) ? $officeTotal[3] : 820000.00, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>OF-DAVAO</strong></td>
                            <td>Davao City</td>
                            <td>Carlito Ibañez</td>
                            <td>Mindanao</td>
                            <td><strong>₱{{ number_format(isset($officeTotal[4]) ? $officeTotal[4] : 750000.00, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ==================== TAB 3: EMPLOYEES & STAFF ==================== --}}
    <div id="tab-employees" class="tab-pane-content">
        <div class="table-card mt-2">
            <h5 class="mb-4"><i class="bi bi-people text-danger me-2"></i> Corporate Regional Managers & Support Directory</h5>
            <div class="table-responsive-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Employee Key</th>
                            <th>Full Name</th>
                            <th>Corporate Operations Title</th>
                            <th>Supported City Hub</th>
                            <th>Performance Target Met</th>
                            <th>Franchise Status Badge</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#201</td>
                            <td><strong>Ramon Valenzuela</strong></td>
                            <td>Luzon North Operations</td>
                            <td>Quezon City</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                        <div class="progress-bar bg-danger" style="width: 85%;"></div>
                                    </div>
                                    <span class="small fw-bold">85%</span>
                                </div>
                            </td>
                            <td><span class="status-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">Excellent</span></td>
                        </tr>
                        <tr>
                            <td>#202</td>
                            <td><strong>Maria Santos</strong></td>
                            <td>Luzon BGC Operations</td>
                            <td>Taguig City</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                        <div class="progress-bar bg-danger" style="width: 78%;"></div>
                                    </div>
                                    <span class="small fw-bold">78%</span>
                                </div>
                            </td>
                            <td><span class="status-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">Excellent</span></td>
                        </tr>
                        <tr>
                            <td>#203</td>
                            <td><strong>Juan dela Cruz</strong></td>
                            <td>CALABARZON Lead</td>
                            <td>Calamba</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                        <div class="progress-bar bg-warning" style="width: 65%;"></div>
                                    </div>
                                    <span class="small fw-bold">65%</span>
                                </div>
                            </td>
                            <td><span class="status-badge" style="background: rgba(255, 188, 13, 0.15); color: #e29f00;">Target On-track</span></td>
                        </tr>
                        <tr>
                            <td>#204</td>
                            <td><strong>Agnes Corpuz</strong></td>
                            <td>Visayas Region Lead</td>
                            <td>Cebu City</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                        <div class="progress-bar bg-danger" style="width: 72%;"></div>
                                    </div>
                                    <span class="small fw-bold">72%</span>
                                </div>
                            </td>
                            <td><span class="status-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">On-target</span></td>
                        </tr>
                        <tr>
                            <td>#205</td>
                            <td><strong>Carlito Ibañez</strong></td>
                            <td>Mindanao Region Lead</td>
                            <td>Davao City</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                        <div class="progress-bar bg-warning" style="width: 58%;"></div>
                                    </div>
                                    <span class="small fw-bold">58%</span>
                                </div>
                            </td>
                            <td><span class="status-badge" style="background: rgba(255, 188, 13, 0.15); color: #e29f00;">Target On-track</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ==================== TAB 4: MENU & PRODUCTS ==================== --}}
    <div id="tab-products" class="tab-pane-content">
        <div class="row g-4 mt-2 mb-4">
            <!-- Product breakdown chart on the left -->
            <div class="col-lg-6">
                <div class="dash-card h-100">
                    <h5><i class="bi bi-egg-fried text-danger"></i> Menu Items Sales Breakdown</h5>
                    <div class="chart-box">
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- SUPER INTERACTIVE PRODUCT COMPARATOR ON THE RIGHT -->
            <div class="col-lg-6">
                <div class="dash-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5><i class="bi bi-arrow-left-right text-success"></i> Menu Item Performance Comparator</h5>
                        <p class="text-muted small">Select two popular McDonald's products from our catalog and compare their sales yields dynamically!</p>
                        
                        <div class="row g-2 mt-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted text-uppercase mb-1">Primary Menu Item</label>
                                <select id="compare-p1" class="form-select">
                                    <option value="P001" selected>Big Mac Double Meal</option>
                                    <option value="P002">2pc Chicken McDo w/ Rice</option>
                                    <option value="P003">Cheeseburger Deluxe Solo</option>
                                    <option value="P004">Oreo McFlurry</option>
                                    <option value="P005">McCafé Iced Coffee</option>
                                    <option value="P006">World Famous Fries XL</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted text-uppercase mb-1">Comparison Menu Item</label>
                                <select id="compare-p2" class="form-select">
                                    <option value="P001">Big Mac Double Meal</option>
                                    <option value="P002" selected>2pc Chicken McDo w/ Rice</option>
                                    <option value="P003">Cheeseburger Deluxe Solo</option>
                                    <option value="P004">Oreo McFlurry</option>
                                    <option value="P005">McCafé Iced Coffee</option>
                                    <option value="P006">World Famous Fries XL</option>
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-action btn-action-primary w-100 mt-3" onclick="executeGadgetComparison()"><i class="bi bi-pie-chart"></i> Compare Sales Metrics</button>

                        <div class="mt-4 p-3 rounded-4 d-none" id="compare-results-box" style="background: var(--bg-input); border: 1px solid var(--border-color);">
                            <h6 class="fw-bold mb-3 text-center text-success"><i class="bi bi-check-circle-fill"></i> Comparison Results</h6>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Price Margin Difference:</span>
                                <strong class="small" id="compare-price-diff">₱0.00</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Estimated Units Difference:</span>
                                <strong class="small" id="compare-units-diff">0 Units</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="small text-muted">Total Net Revenue Margin:</span>
                                <strong class="small text-danger" id="compare-rev-diff">₱0.00</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Products Database Table --}}
        <div class="table-card">
            <h5 class="mb-4"><i class="bi bi-egg text-danger me-2"></i> McDonald's Menu Items Sales Yields & Pricing Catalog</h5>
            <div class="table-responsive-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Product Key</th>
                            <th>Menu Item Name</th>
                            <th>Category Line</th>
                            <th>Franchise Price (₱)</th>
                            <th>National Volume Units Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>P001</strong></td>
                            <td>Big Mac Double Meal</td>
                            <td>Main Meals</td>
                            <td>₱249.00</td>
                            <td>8,200 units</td>
                        </tr>
                        <tr>
                            <td><strong>P002</strong></td>
                            <td>2pc Chicken McDo with Rice & Drink</td>
                            <td>Main Meals</td>
                            <td>₱189.00</td>
                            <td>10,500 units</td>
                        </tr>
                        <tr>
                            <td><strong>P003</strong></td>
                            <td>Cheeseburger Deluxe Solo</td>
                            <td>Burgers</td>
                            <td>₱119.00</td>
                            <td>5,200 units</td>
                        </tr>
                        <tr>
                            <td><strong>P004</strong></td>
                            <td>Oreo McFlurry</td>
                            <td>Desserts</td>
                            <td>₱69.00</td>
                            <td>17,300 units</td>
                        </tr>
                        <tr>
                            <td><strong>P005</strong></td>
                            <td>McCafé Premium Roast Iced Coffee</td>
                            <td>Beverages</td>
                            <td>₱99.00</td>
                            <td>6,500 units</td>
                        </tr>
                        <tr>
                            <td><strong>P006</strong></td>
                            <td>World Famous Fries XL</td>
                            <td>Sides</td>
                            <td>₱149.00</td>
                            <td>12,100 units</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ==================== TAB 5: CUSTOMER BRANCHES ==================== --}}
    <div id="tab-customers" class="tab-pane-content">
        <div class="table-card mt-2">
            <h5 class="mb-4"><i class="bi bi-shop text-danger me-2"></i> McDonald's Philippine Franchise Branches Directory</h5>
            <div class="table-responsive-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Franchise Store Key</th>
                            <th>Store Location Name</th>
                            <th>City HQ</th>
                            <th>Island Group Region</th>
                            <th>Store Allocation Credit Limit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#101</td>
                            <td><strong>McDonald's SM North EDSA</strong></td>
                            <td>Quezon City</td>
                            <td>Luzon</td>
                            <td>₱2,000,000.00</td>
                        </tr>
                        <tr>
                            <td>#102</td>
                            <td><strong>McDonald's BGC Forum</strong></td>
                            <td>Taguig City</td>
                            <td>Luzon</td>
                            <td>₱2,500,000.00</td>
                        </tr>
                        <tr>
                            <td>#103</td>
                            <td><strong>McDonald's Greenbelt</strong></td>
                            <td>Makati City</td>
                            <td>Luzon</td>
                            <td>₱3,000,000.00</td>
                        </tr>
                        <tr>
                            <td>#117</td>
                            <td><strong>McDonald's Antipolo Bypass</strong></td>
                            <td>Antipolo</td>
                            <td>Luzon</td>
                            <td>₱1,200,000.00</td>
                        </tr>
                        <tr>
                            <td>#118</td>
                            <td><strong>McDonald's Calamba Crossing</strong></td>
                            <td>Calamba</td>
                            <td>Luzon</td>
                            <td>₱1,500,000.00</td>
                        </tr>
                        <tr>
                            <td>#122</td>
                            <td><strong>McDonald's Cebu IT Park</strong></td>
                            <td>Cebu City</td>
                            <td>Visayas</td>
                            <td>₱2,200,000.00</td>
                        </tr>
                        <tr>
                            <td>#125</td>
                            <td><strong>McDonald's Bajada Davao</strong></td>
                            <td>Davao City</td>
                            <td>Mindanao</td>
                            <td>₱2,100,000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ==================== TAB 6: SALES LEDGER ==================== --}}
    <div id="tab-sales" class="tab-pane-content">
        {{-- Glassmorphic Filters Panel --}}
        <div class="filter-card mt-2">
            <form action="{{ url('/Dashboard') }}" method="GET" id="filterForm" class="filter-form">
                <div class="filter-group">
                    <label for="period">Timeframe Mode</label>
                    <select name="period" id="period" class="filter-select">
                        <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                        <option value="quarterly" {{ $period === 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="semi-annually" {{ $period === 'semi-annually' ? 'selected' : '' }}>Semi-Annually</option>
                        <option value="annually" {{ $period === 'annually' ? 'selected' : '' }}>Annually</option>
                    </select>
                </div>
                <div class="filter-group" id="yearGroup" style="display: {{ $period !== 'custom' ? 'block' : 'none' }};">
                    <label for="year">Year</label>
                    <select name="year" id="year" class="filter-select">
                        <option value="2026" {{ $year === '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2025" {{ $year === '2025' ? 'selected' : '' }}>2025</option>
                    </select>
                </div>
                <div class="filter-group" id="quarterGroup" style="display: {{ $period === 'quarterly' ? 'block' : 'none' }};">
                    <label for="quarter">Quarter</label>
                    <select name="quarter" id="quarter" class="filter-select">
                        <option value="Q1" {{ request('quarter') === 'Q1' ? 'selected' : '' }}>Q1</option>
                        <option value="Q2" {{ request('quarter') === 'Q2' ? 'selected' : '' }}>Q2</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-action btn-action-primary"><i class="bi bi-funnel-fill"></i> Filter</button>
                </div>
            </form>
        </div>

        {{-- Table Ledger Card --}}
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <h5 class="m-0"><i class="bi bi-table text-danger me-2"></i> McDonald's Franchise Bounded Sales & Payments Ledger</h5>
                
                <!-- Live Search Box (Dynamic JS Search) -->
                <div class="position-relative" style="width: 300px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="payments-search-input" class="form-control ps-5" placeholder="Search branch, island region, city..." style="height: 40px; border-radius: 10px;">
                </div>
            </div>

            <div class="table-responsive-wrapper">
                <table class="custom-table" id="payments-ledger-table">
                    <thead>
                        <tr>
                            <th>Store Number</th>
                            <th>Franchise / Branch Representative</th>
                            <th>Island Group</th>
                            <th>City Location</th>
                            <th>Bank Voucher Code</th>
                            <th>Fulfillment Date</th>
                            <th>Total Sales Amount (₱)</th>
                            <th>Fulfillment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $pay)
                        <tr class="payments-ledger-row" style="cursor: pointer;" data-payment-json="{{ json_encode($pay) }}">
                            <td><strong>#{{ $pay->customerNumber }}</strong></td>
                            <td class="customer-name-cell">{{ $pay->customerName }}</td>
                            <td class="region-cell"><span class="badge" style="background: rgba(218, 41, 28, 0.1); color: #da291c; font-weight: 700; font-size: 0.78rem; padding: 0.35rem 0.75rem; border-radius: 8px;">{{ $pay->country }}</span></td>
                            <td class="city-cell">{{ $pay->city }}</td>
                            <td class="check-cell"><code>{{ $pay->checkNumber }}</code></td>
                            <td><i class="bi bi-calendar-event text-muted me-1"></i> {{ date('M d, Y', strtotime($pay->paymentDate)) }}</td>
                            <td><strong>₱{{ number_format($pay->amount, 2) }}</strong></td>
                            <td><span class="status-badge">Completed</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 4rem;">
                                <i class="bi bi-emoji-frown" style="font-size: 2.5rem; display: block; margin-bottom: 0.8rem; color: var(--text-muted);"></i>
                                <strong>Walang natagpuang data.</strong> Try resetting or changing the location focus.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ==================== TRANSACTION RECEIPT MODAL ==================== --}}
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="receiptModalLabel"><i class="bi bi-receipt me-2 text-danger"></i> Store Purchase Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: var(--toggler-icon-filter);"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-extrabold m-0 text-danger" style="background: linear-gradient(135deg, #da291c, #ffbc0d); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><i class="bi bi-shop"></i> McDonald's PH</h3>
                    <small class="text-muted">Golden Arches Corp., Manila, Philippines</small>
                </div>
                
                <!-- Receipt details details -->
                <div class="border-top border-bottom py-3 my-3 border-secondary border-dashed" style="border-style: dashed !important;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Voucher Code:</span>
                        <strong class="small font-monospace" id="m-receipt-voucher">CK-90001</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Franchise Branch:</span>
                        <strong class="small" id="m-receipt-cust">McDonald's SM North EDSA</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">City / Branch Location:</span>
                        <strong class="small" id="m-receipt-city">Quezon City</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Island Group Region:</span>
                        <strong class="small text-danger" id="m-receipt-region">Luzon</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">Transaction Date:</span>
                        <strong class="small" id="m-receipt-date">2026-01-12</strong>
                    </div>
                </div>

                <div class="p-3 rounded-4 mb-4" style="background: var(--bg-input); border: 1px solid var(--border-color);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block small text-muted uppercase font-monospace">Purchased Product Mix</span>
                            <strong id="m-receipt-product">Big Mac Double Meal Combo Bulk Pack</strong>
                        </div>
                        <div class="text-end">
                            <span class="d-block small text-muted uppercase font-monospace">Net Amount</span>
                            <strong class="text-success fs-5 fw-bold" id="m-receipt-amount">₱373,500.00</strong>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-weight: 800; font-size: 0.8rem; padding: 0.5rem 1rem; border-radius: 30px;">
                        <i class="bi bi-shield-check me-1"></i> FRANCHISE SECURED & COMPLETED
                    </span>
                    <div class="text-muted font-monospace mt-3 small" style="letter-spacing: 0.15em;">*MCDO_PH_RETAIL_993*</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-action btn-action-primary" onclick="printMockInvoice()"><i class="bi bi-printer-fill"></i> Print Invoice</button>
            </div>
        </div>
    </div>
</div>

<!-- Floating theme toast notification -->
<div id="themeToast" class="theme-toast" style="display: none;">
    <i class="bi bi-palette-fill text-primary"></i>
    <span id="toastMessage">Theme updated successfully!</span>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Theme Switcher & Memory State
    const rawPayments = @json($payments);
    const rawCities = @json($city);
    const rawCityTotals = @json($cityHighestTotal);
    const rawProducts = @json($productNames);
    const rawProductSales = @json($productSales);
    const rawOffices = @json($officeCode);
    const rawOfficeTotals = @json($officeTotal);
    const rawRegionLabels = @json($countryLabels);
    const rawRegionTotals = @json($countryTotals);

    document.addEventListener('DOMContentLoaded', function() {
        // TOP DRAWER TOGGLE INTERACTIVITY
        const workspaceToggleBtn = document.getElementById('workspaceToggleBtn');
        const workspaceTopDrawer = document.getElementById('workspaceTopDrawer');
        const workspaceChevron = document.getElementById('workspaceChevron');

        if (workspaceToggleBtn && workspaceTopDrawer) {
            // Memory State: Keep top drawer open by default or restore from state
            const drawerState = localStorage.getItem('workspace-drawer-open') || 'true';
            if (drawerState === 'true') {
                workspaceTopDrawer.style.display = 'block';
                if (workspaceChevron) workspaceChevron.style.transform = 'rotate(180deg)';
            }

            workspaceToggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const isOpen = workspaceTopDrawer.style.display === 'block';
                
                if (isOpen) {
                    workspaceTopDrawer.style.display = 'none';
                    if (workspaceChevron) workspaceChevron.style.transform = 'rotate(0deg)';
                    localStorage.setItem('workspace-drawer-open', 'false');
                    showToast('📁 Workspaces Portal hidden');
                } else {
                    workspaceTopDrawer.style.display = 'block';
                    if (workspaceChevron) workspaceChevron.style.transform = 'rotate(180deg)';
                    localStorage.setItem('workspace-drawer-open', 'true');
                    showToast('📂 Workspaces Portal expanded');
                }
            });
        }

        // Tab switching logic for Workspace Header Link Tabs
        const drawerLinks = document.querySelectorAll('.workspace-drawer-link');
        const tabPanes = document.querySelectorAll('.tab-pane-content');
        
        drawerLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetTab = this.getAttribute('data-tab');
                
                // Set active class on navbar drawer link
                drawerLinks.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Show selected tab pane
                tabPanes.forEach(pane => {
                    if (pane.id === 'tab-' + targetTab) {
                        pane.style.display = 'block';
                    } else {
                        pane.style.display = 'none';
                    }
                });
                
                localStorage.setItem('active-workspace-tab', targetTab);
                showToast(`📂 Switched to ${this.textContent.trim()} workspace!`);

                if (targetTab === 'offices') {
                    focusNcrSpotlight('qc');
                }
            });
        });

        // Sticky memory of active workspace tab
        const savedTab = localStorage.getItem('active-workspace-tab') || 'overview';
        const activeNavTab = document.querySelector(`.workspace-drawer-link[data-tab="${savedTab}"]`);
        if (activeNavTab) {
            activeNavTab.click();
        }

        // --- Theme Switching Round Switcher ---
        const themeBtn = document.getElementById('headerThemeToggleBtn');
        const sunIcon = document.getElementById('headerSunIcon');
        
        // Initial Theme State
        const activeTheme = localStorage.getItem('bi-theme') || 'light';
        applyThemeStyles(activeTheme === 'dark');

        themeBtn.addEventListener('click', function() {
            const isDark = document.documentElement.classList.toggle('dark-theme');
            const targetTheme = isDark ? 'dark' : 'light';
            
            localStorage.setItem('bi-theme', targetTheme);
            applyThemeStyles(isDark);
            
            showToast(isDark ? '🌙 Switched to sleek Dark theme!' : '☀️ Switched to cohesive Light theme!');
        });

        function applyThemeStyles(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark-theme');
                sunIcon.classList.replace('bi-sun-fill', 'bi-moon-fill');
                updateChartThemes(true);
            } else {
                document.documentElement.classList.remove('dark-theme');
                sunIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
                updateChartThemes(false);
            }
        }

        // Filter Mode Fields Toggle Switcher
        const periodSelect = document.getElementById('period');
        const customDateGroup = document.getElementById('customDateGroup');
        const yearGroup = document.getElementById('yearGroup');
        const quarterGroup = document.getElementById('quarterGroup');
        const halfGroup = document.getElementById('halfGroup');

        function togglePeriodFields() {
            if (!periodSelect) return;
            const val = periodSelect.value;
            if (val === 'custom') {
                if (customDateGroup) customDateGroup.style.display = 'flex';
                if (yearGroup) yearGroup.style.display = 'none';
                if (quarterGroup) quarterGroup.style.display = 'none';
                if (halfGroup) halfGroup.style.display = 'none';
            } else {
                if (customDateGroup) customDateGroup.style.display = 'none';
                if (yearGroup) yearGroup.style.display = 'block';
                
                if (val === 'quarterly') {
                    if (quarterGroup) quarterGroup.style.display = 'block';
                    if (halfGroup) halfGroup.style.display = 'none';
                } else if (val === 'semi-annually') {
                    if (quarterGroup) quarterGroup.style.display = 'none';
                    if (halfGroup) halfGroup.style.display = 'block';
                } else if (val === 'annually') {
                    if (quarterGroup) quarterGroup.style.display = 'none';
                    if (halfGroup) halfGroup.style.display = 'none';
                }
            }
        }
        
        if (periodSelect) {
            periodSelect.addEventListener('change', togglePeriodFields);
            togglePeriodFields();
        }

        // --- Live Search filter for payments Ledger table ---
        const searchInput = document.getElementById('payments-search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const term = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('#payments-ledger-table tbody tr');
                
                rows.forEach(row => {
                    const cust = row.querySelector('.customer-name-cell')?.textContent.toLowerCase() || '';
                    const region = row.querySelector('.region-cell')?.textContent.toLowerCase() || '';
                    const city = row.querySelector('.city-cell')?.textContent.toLowerCase() || '';
                    const check = row.querySelector('.check-cell')?.textContent.toLowerCase() || '';
                    
                    if (cust.includes(term) || region.includes(term) || city.includes(term) || check.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });

    // --- Interactive Modal purchase receipts ---
    let receiptModalInstance = null;
    function openReceiptModal(payment) {
        document.getElementById('m-receipt-voucher').textContent = payment.checkNumber;
        document.getElementById('m-receipt-cust').textContent = payment.customerName;
        document.getElementById('m-receipt-city').textContent = payment.city;
        document.getElementById('m-receipt-region').textContent = payment.country;
        document.getElementById('m-receipt-date').textContent = payment.paymentDate;
        
        // Dynamic mock product name details matching our PH catalog
        let pr = 'McDonald\'s Happy Meal Promo Set';
        if (payment.amount >= 400000) pr = 'Big Mac Double Meal Combo Bulk Pack';
        else if (payment.amount >= 300000) pr = '2pc Chicken McDo with Rice & Drink Large Pack';
        else if (payment.amount >= 200000) pr = 'World Famous Fries XL / Oreo McFlurry Sweet Mix';
        else if (payment.amount >= 100000) pr = 'McCafé Premium Roast Iced Coffee Refreshers';
        
        document.getElementById('m-receipt-product').textContent = pr;
        document.getElementById('m-receipt-amount').textContent = '₱' + parseFloat(payment.amount).toLocaleString(undefined, {minimumFractionDigits: 2});
        
        // Show using bootstrap Modal triggers
        if (!receiptModalInstance) {
            receiptModalInstance = new bootstrap.Modal(document.getElementById('receiptModal'));
        }
        receiptModalInstance.show();
    }

    function printMockInvoice() {
        alert('📤 McDonald\'s Store Invoice queued to local printer successfully! Completed print sequence.');
    }

    // --- Interactive Spotlight Switcher ---
    function focusNcrSpotlight(branch) {
        // Remove active class from buttons
        document.querySelectorAll('.active-branch-btn').forEach(btn => btn.classList.remove('btn-action-primary'));
        const activeBtn = document.getElementById(`btn-ncr-${branch}`);
        if (activeBtn) activeBtn.classList.add('btn-action-primary');

        const title = document.getElementById('spotlight-title');
        const desc = document.getElementById('spotlight-desc');
        const manager = document.getElementById('spotlight-manager');
        const gadget = document.getElementById('spotlight-gadget');

        if (branch === 'qc') {
            title.textContent = 'Luzon Operations: Quezon City HQ';
            desc.textContent = 'Our largest support HQ handling Luzon North franchise clusters including SM North EDSA, Monumento, and McArthur Highway outlets.';
            manager.textContent = 'Ramon Valenzuela';
            gadget.textContent = '2pc Chicken McDo w/ Rice';
        } else if (branch === 'bgc') {
            title.textContent = 'Luzon Operations: BGC Corporate Hub';
            desc.textContent = 'Overseeing taguig BGC, Makati financial offices, Taft Avenue, Pasig, and Mandaluyong downtown branches.';
            manager.textContent = 'Maria Santos';
            gadget.textContent = 'Big Mac Double Meal';
        } else {
            title.textContent = 'CALABARZON operations: Calamba Crossing HQ';
            desc.textContent = 'Spearheading South Luzon expansion routes including Calamba Laguna, Antipolo Rizal, Cavite, and Tagaytay Ridge.';
            manager.textContent = 'Juan dela Cruz';
            gadget.textContent = 'World Famous Fries XL';
        }
    }

    // --- Dynamic Product Performance Comparison Tool ---
    function executeGadgetComparison() {
        const p1 = document.getElementById('compare-p1').value;
        const p2 = document.getElementById('compare-p2').value;
        
        const productsMap = {
            'P001': { name: 'Big Mac Double Meal', price: 249, units: 8200 },
            'P002': { name: '2pc Chicken McDo w/ Rice', price: 189, units: 10500 },
            'P003': { name: 'Cheeseburger Deluxe Solo', price: 119, units: 5200 },
            'P004': { name: 'Oreo McFlurry', price: 69, units: 17300 },
            'P005': { name: 'McCafé Iced Coffee', price: 99, units: 6500 },
            'P006': { name: 'World Famous Fries XL', price: 149, units: 12100 }
        };

        const prod1 = productsMap[p1];
        const prod2 = productsMap[p2];

        if (!prod1 || !prod2) return;

        const priceDiff = Math.abs(prod1.price - prod2.price);
        const unitsDiff = Math.abs(prod1.units - prod2.units);
        
        const rev1 = prod1.price * prod1.units;
        const rev2 = prod2.price * prod2.units;
        const revDiff = Math.abs(rev1 - rev2);

        document.getElementById('compare-price-diff').textContent = '₱' + priceDiff.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('compare-units-diff').textContent = unitsDiff.toLocaleString() + ' Units';
        document.getElementById('compare-rev-diff').textContent = '₱' + revDiff.toLocaleString(undefined, {minimumFractionDigits: 2});

        const resBox = document.getElementById('compare-results-box');
        resBox.classList.remove('d-none');
        
        showToast(`📊 Compared ${prod1.name} vs ${prod2.name} successfully!`);
    }

    // --- Interactive Toast Notification ---
    function showToast(msg) {
        const toast = document.getElementById('themeToast');
        const msgEl = document.getElementById('toastMessage');
        if (toast && msgEl) {
            msgEl.textContent = msg;
            toast.style.display = 'flex';
            
            if (window.toastTimer) clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(() => {
                toast.style.display = 'none';
            }, 2500);
        }
    }

    // --- CHART MANAGEMENT SYSTEM ---
    const charts = {};

    function updateChartThemes(isDark) {
        const textColor = isDark ? '#94a3b8' : '#475569';
        const gridColor = isDark ? '#1f2937' : '#e2e8f0';

        Object.keys(charts).forEach(key => {
            const chart = charts[key];
            if (!chart) return;

            if (chart.options.scales) {
                if (chart.options.scales.x) {
                    chart.options.scales.x.grid.color = gridColor;
                    chart.options.scales.x.ticks.color = textColor;
                }
                if (chart.options.scales.y) {
                    chart.options.scales.y.grid.color = gridColor;
                    chart.options.scales.y.ticks.color = textColor;
                }
            }
            
            if (chart.options.plugins && chart.options.plugins.legend) {
                chart.options.plugins.legend.labels.color = textColor;
            }
            
            chart.update();
        });
    }

    const drawBarChart = (canvasId, labels, data, labelName, colors) => {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return null;
        
        if (labels.length === 0) {
            const ctx = canvas.getContext('2d');
            ctx.fillStyle = '#888';
            ctx.font = '14px Plus Jakarta Sans';
            ctx.textAlign = 'center';
            ctx.fillText('No data available for this range', canvas.width / 2, canvas.height / 2);
            return null;
        }

        return new Chart(canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: labelName,
                    data: data,
                    backgroundColor: colors,
                    borderRadius: 10,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { color: '#cbd5e1' },
                        ticks: {
                            color: '#475569',
                            callback: v => '₱' + v.toLocaleString()
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: 'var(--text-main)', font: { weight: '600' } }
                    }
                }
            }
        });
    };

    // Chart 1: Regions Market Allocation (Pie Chart)
    if (rawRegionLabels.length > 0) {
        charts.region = new Chart(document.getElementById('regionChart'), {
            type: 'pie',
            data: {
                labels: rawRegionLabels,
                datasets: [{
                    data: rawRegionTotals,
                    backgroundColor: [
                        'rgba(218, 41, 28, 0.85)',    // Luzon Red
                        'rgba(255, 188, 13, 0.85)',   // Visayas Golden Yellow
                        'rgba(16, 185, 129, 0.85)'    // Mindanao Green
                    ],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            color: '#475569',
                            font: { family: 'Plus Jakarta Sans', weight: '700', size: 12 }
                        }
                    }
                }
            }
        });
    }

    // Chart 2: Top Cities Leaderboard (Horizontal Bar)
    charts.city = drawBarChart('cityChart', rawCities, rawCityTotals, 'Total Sales (₱)', 'rgba(16, 185, 129, 0.85)');

    // Chart 3: Popular Menu Items Breakdown (Horizontal Bar)
    charts.product = drawBarChart('productChart', rawProducts, rawProductSales, 'Total Sales (₱)', 'rgba(218, 41, 28, 0.85)');

    // Chart 4: Regional HQ Support (Doughnut)
    if (rawOffices.length > 0) {
        charts.office = new Chart(document.getElementById('officeChart'), {
            type: 'doughnut',
            data: {
                labels: rawOffices,
                datasets: [{
                    data: rawOfficeTotals,
                    backgroundColor: [
                        'rgba(218, 41, 28, 0.85)',
                        'rgba(255, 188, 13, 0.85)',
                        'rgba(16, 185, 129, 0.85)',
                        'rgba(139, 92, 246, 0.85)',
                        'rgba(14, 165, 233, 0.85)'
                    ],
                    borderWidth: 0,
                    hoverOffset: 12
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            color: '#475569',
                            font: { family: 'Plus Jakarta Sans', weight: '700', size: 11 }
                        }
                    }
                },
                cutout: '68%'
            }
        });
    }

    // Safely bind click event listeners to ledger rows to trigger the Store Purchase Receipt modal
    document.querySelectorAll('.payments-ledger-row').forEach(row => {
        row.addEventListener('click', function() {
            try {
                const rawJson = this.getAttribute('data-payment-json');
                const payment = JSON.parse(rawJson);
                openReceiptModal(payment);
            } catch (e) {
                console.error('Error parsing payment JSON:', e);
            }
        });
    });
</script>
@endpush
