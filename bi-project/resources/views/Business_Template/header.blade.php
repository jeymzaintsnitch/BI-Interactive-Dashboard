<nav class="navbar navbar-expand-lg sticky-top border-bottom" style="background: var(--bg-filter); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-color: var(--border-color) !important; padding: 0.8rem 1.5rem; transition: background 0.4s, border-color 0.4s, box-shadow 0.4s; z-index: 1030; box-shadow: var(--card-shadow);">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    
    <div class="d-flex align-items-center">
      <!-- Logo with McDonald's Theme -->
      <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="{{ url('/Dashboard') }}" style="font-weight: 800; font-size: 1.3rem; background: linear-gradient(135deg, #ffbc0d, #da291c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.03em; transition: transform 0.3s ease;">
        <i class="bi bi-shop" style="font-size: 1.5rem;"></i>
        <span>PH McDo Analytics</span>
      </a>
    </div>

    <!-- Middle: Expanding Admin Workspace Drawer Toggle Button -->
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-action btn-action-primary px-3 px-md-4" id="workspaceToggleBtn" title="Toggle Workspace Menu" style="border-radius: 12px; height: 42px; display: inline-flex; align-items: center; gap: 8px; font-weight: 700; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <i class="bi bi-grid-fill"></i>
        <span>Workspaces Portal</span>
        <i class="bi bi-chevron-down ms-1" id="workspaceChevron" style="transition: transform 0.3s ease;"></i>
      </button>
    </div>

    <!-- Right-side controls (Theme Toggle switch - ROUNDED ICON ONLY) -->
    <div class="d-flex align-items-center gap-3">
      <!-- Admin Badge Indicator -->
      <span class="badge d-none d-md-inline-flex align-items-center gap-1 font-monospace" style="background: rgba(218, 41, 28, 0.1); color: #da291c; font-weight: 800; padding: 0.5rem 1rem; border-radius: 30px; font-size: 0.78rem; border: 1px solid rgba(218, 41, 28, 0.15);">
        <i class="bi bi-shield-check-fill text-warning"></i> ADMIN PORTAL
      </span>
      
      <button id="headerThemeToggleBtn" class="theme-toggle-btn" title="Toggle Light/Dark Theme" style="background: var(--btn-secondary-bg); border: 1px solid var(--btn-secondary-border); color: var(--btn-secondary-text); width: 42px; height: 42px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: var(--card-shadow); outline: none;">
        <i class="bi bi-sun-fill" id="headerSunIcon" style="font-size: 1.25rem; transition: transform 0.4s ease;"></i>
      </button>
    </div>
    
  </div>
</nav>

<!-- COLLAPSIBLE WORKSPACE TOP DRAWER (NESTED DIRECTLY IN HEADER) -->
<div class="workspace-top-drawer border-bottom" id="workspaceTopDrawer" style="display: none;">
  <div class="container-fluid py-3 px-4">
    <div class="d-flex flex-wrap justify-content-center gap-2">
      <a href="#" class="workspace-drawer-link active" data-tab="overview">
        <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard Home</span>
      </a>
      <a href="#" class="workspace-drawer-link" data-tab="offices">
        <i class="bi bi-building-fill"></i> <span>Offices / HQs</span>
      </a>
      <a href="#" class="workspace-drawer-link" data-tab="employees">
        <i class="bi bi-people-fill"></i> <span>Employees & Staff</span>
      </a>
      <a href="#" class="workspace-drawer-link" data-tab="products">
        <i class="bi bi-egg-fried"></i> <span>Menu & Products</span>
      </a>
      <a href="#" class="workspace-drawer-link" data-tab="customers">
        <i class="bi bi-shop"></i> <span>Customer Branches</span>
      </a>
      <a href="#" class="workspace-drawer-link" data-tab="sales">
        <i class="bi bi-receipt-cutoff"></i> <span>Sales Ledger</span>
      </a>
    </div>
  </div>
</div>

<style>
  /* Premium Glassmorphic Top Workspace Drawer Styling */
  .workspace-top-drawer {
    background: var(--bg-filter);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-color: var(--border-color) !important;
    position: sticky;
    top: 72px;
    z-index: 1025;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    animation: drawerSlideDown 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  @keyframes drawerSlideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .workspace-drawer-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.65rem 1.3rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--text-sub);
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1px solid transparent;
  }

  .workspace-drawer-link:hover {
    color: var(--text-main);
    background: var(--bg-card-hover);
    border-color: var(--border-color);
  }

  .workspace-drawer-link.active {
    background: var(--accent-gradient) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(218, 41, 28, 0.2);
  }

  .navbar-brand:hover {
    transform: scale(1.03);
  }
  .theme-toggle-btn:hover {
    transform: scale(1.08) rotate(15deg);
    box-shadow: 0 0 15px var(--accent-glow);
  }
</style>