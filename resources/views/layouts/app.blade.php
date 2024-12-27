
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Farmer Management System')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #86AA42; /* Green from logo */
            --secondary-color: #ffffff; /* White for text */
            --hover-color: #5c7d2f; /* Slightly darker green for hover effect */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: var(--primary-color);
            color: var(--secondary-color);
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .nav-link {
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: var(--hover-color);
            color: #f0f0f0;
        }

        .sidebar .nav-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .sidebar.collapsed .nav-link span {
            display: none; /* Hide text in collapsed mode */
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: var(--primary-color);
        }

        .sidebar.collapsed .logo img {
            display: none; /* Hide logo when collapsed */
        }

        .sidebar .submenu {
            display: none;
            padding-left: 30px;
        }

        .sidebar .submenu a {
            font-size: 0.9rem;
        }

        .sidebar .submenu.show {
            display: block;
        }

        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s;
            flex: 1; /* Ensure the main content stretches to fill available space */
        }

        .main-content.collapsed {
            margin-left: 70px;
        }

        .header {
            background-color: #f1f1f1;
            color: #333;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer {
            background-color: #f1f1f1;
            color: #333;
            text-align: center;
            padding: 10px;
            border-top: 1px solid #ddd;
            flex-shrink: 0; /* Ensure the footer stays at the bottom */
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--secondary-color);
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="{{ asset('logo.png') }}" alt="Good Nature Agro Logo" width="120">
            <button class="toggle-sidebar" id="toggle-sidebar" onclick="toggleSidebar()">
                <i class="bi bi-chevron-double-left"></i>
            </button>
        </div>
        <ul class="nav flex-column">

            <?php
            use Modules\ModuleManagement\Models\Module;
            $modules = Module::where('is_active', 1)->get();
            ?>
          <!-- Farmers Module -->
           @foreach($modules as $module)
           @if($module->name === 'FarmerManagement')
          <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)" onclick="toggleSubmenu('farmers-menu')">
            <i class="nav-icon bi bi-people-fill"></i>
            <span>Farmers</span>
            </a>
            <ul class="submenu" id="farmers-menu">
            <li><a class="nav-link" href="{{ route('farmers.index') }}">View Farmers</a></li>
            <li><a class="nav-link" href="{{ route('farmers.create') }}">Add Farmer</a></li>
           </ul>
           </li>
           @endif

          @if($module->name === 'LoanManagement')
         <!-- Loan Management Module -->
         <li class="nav-item">
         <a class="nav-link" href="javascript:void(0)" onclick="toggleSubmenu('loan-menu')">
            <i class="nav-icon bi bi-cash-stack"></i>
            <span>Loan Management</span>
         </a>
         <ul class="submenu" id="loan-menu">
            <li><a class="nav-link" href="{{ route('loans.index') }}">View Loans</a></li>
            <li><a class="nav-link" href="{{ route('loans.create') }}">Add Loan</a></li>
          </ul>
         </li>
        @endif
        @endforeach

        <!-- Module Management -->
       <li class="nav-item">
       <a class="nav-link" href="javascript:void(0)" onclick="toggleSubmenu('module-management-menu')">
       <i class="bi bi-puzzle"></i>
        <span>Module Management</span>
       </a>
       <ul class="submenu" id="module-management-menu">
       <li><a class="nav-link" href="{{ route('modules.index') }}">View Modules</a></li>
       <li><a class="nav-link" href="{{ route('modules.create') }}">
       <i class="bi bi-plus-circle"></i> Create Module
       </a></li>
       <li><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#uploadModuleModal">Install Module</a></li>
       </ul>
       </li>
           

            <!-- Other Features -->
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="toggleSubmenu('other-features-menu')">
                    <i class="nav-icon bi bi-gear-fill"></i>
                    <span>Other Features</span>
                </a>
                <ul class="submenu" id="other-features-menu">
                    <li><a class="nav-link" href="#">Farm Support</a></li>
                    <li><a class="nav-link" href="{{ route('loans.reports') }}">Reports</a></li>
                    <li><a class="nav-link" href="#">Settings</a></li>
                </ul>
            </li>

            


            <li class="nav-item mt-auto"> <!-- Push Logout to the bottom -->
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
                <!-- Logout Form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Header -->
        <div class="header">
            <div>
                <h5>Farmer Management System</h5>
                <small>Purpose: To manage farmers and loans effectively for GNA</small>
            </div>
            <div>
                <strong>Welcome, {{ Auth::user()->name }}</strong>
            </div>
        </div>

        <!-- Page Content -->
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <small>Developed for the purpose of employment at GNA. Created by Mukuka Mulenga - Email: twomulenga@gmail.com</small>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const submenus = document.querySelectorAll('.submenu');

            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                submenus.forEach((submenu) => submenu.classList.remove('show'));
            }
        }

        function toggleSubmenu(menuId) {
            const sidebar = document.getElementById('sidebar');
            const submenu = document.getElementById(menuId);

            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                document.getElementById('main-content').classList.remove('collapsed');
            }

            submenu.classList.toggle('show');
        }
    </script>
    @stack('scripts')
</body>
</html>
