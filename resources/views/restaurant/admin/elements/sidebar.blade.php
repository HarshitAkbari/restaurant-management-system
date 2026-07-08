<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            @canany(['orders.read', 'orders.write'])
            <li class="{{ request()->routeIs('admin.orders.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-receipt"></i>
                    <span class="nav-text">Orders</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.orders.index') }}">Live Orders</a></li>
                    <li><a href="{{ route('admin.orders.history') }}">Order History</a></li>
                    @can('orders.void')
                    <li><a href="{{ route('admin.orders.void-log') }}">Void / Cancel Log</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['menu.read', 'menu.write'])
            <li class="{{ request()->routeIs('admin.menu.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-card-list"></i>
                    <span class="nav-text">Menu</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.menu.categories.index') }}">Categories</a></li>
                    <li><a href="{{ route('admin.menu.items.index') }}">Items</a></li>
                    <li><a href="{{ route('admin.menu.variants.index') }}">Variants</a></li>
                    <li><a href="{{ route('admin.menu.addons.index') }}">Add-ons</a></li>
                    <li><a href="{{ route('admin.menu.combos.index') }}">Combos</a></li>
                </ul>
            </li>
            @endcanany

            @canany(['tables.read', 'tables.write'])
            <li class="{{ request()->routeIs('admin.tables.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-grid-3x3-gap"></i>
                    <span class="nav-text">Tables & Areas</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.tables.areas.index') }}">Areas</a></li>
                    <li><a href="{{ route('admin.tables.index') }}">Tables</a></li>
                    <li><a href="{{ route('admin.tables.layout') }}">Table Layout</a></li>
                </ul>
            </li>
            @endcanany

            @canany(['inventory.read', 'inventory.write'])
            <li class="{{ request()->routeIs('admin.inventory.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-box-seam"></i>
                    <span class="nav-text">Inventory</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.inventory.materials.index') }}">Raw Materials</a></li>
                    <li><a href="{{ route('admin.inventory.recipes.index') }}">Recipes</a></li>
                    <li><a href="{{ route('admin.inventory.purchase-orders.index') }}">Purchase Orders</a></li>
                    <li><a href="{{ route('admin.inventory.suppliers.index') }}">Suppliers</a></li>
                    <li><a href="{{ route('admin.inventory.alerts') }}">Stock Alerts</a></li>
                </ul>
            </li>
            @endcanany

            @canany(['staff.read', 'staff.write', 'staff.roles'])
            <li class="{{ request()->routeIs('admin.staff.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-people"></i>
                    <span class="nav-text">Staff</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.staff.index') }}">Employees</a></li>
                    @can('staff.roles')
                    <li><a href="{{ route('admin.staff.roles.index') }}">Roles & Permissions</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['customers.read', 'customers.write', 'loyalty.manage'])
            <li class="{{ request()->routeIs('admin.customers.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-person-badge"></i>
                    <span class="nav-text">Customers</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.customers.index') }}">Customer List</a></li>
                    @can('loyalty.manage')
                    <li><a href="{{ route('admin.customers.loyalty') }}">Loyalty</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @can('reports.read')
            <li class="{{ request()->routeIs('admin.reports.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-bar-chart"></i>
                    <span class="nav-text">Reports</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.reports.sales') }}">Sales</a></li>
                    <li><a href="{{ route('admin.reports.items') }}">Item-wise</a></li>
                    <li><a href="{{ route('admin.reports.tax') }}">Tax / GST</a></li>
                    <li><a href="{{ route('admin.reports.staff') }}">Staff</a></li>
                    <li><a href="{{ route('admin.reports.inventory') }}">Inventory</a></li>
                </ul>
            </li>
            @endcan

            @canany(['expenses.read', 'expenses.write'])
            <li class="{{ request()->routeIs('admin.expenses.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-wallet2"></i>
                    <span class="nav-text">Expenses</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.expenses.index') }}">Expense List</a></li>
                    <li><a href="{{ route('admin.expenses.categories.index') }}">Categories</a></li>
                </ul>
            </li>
            @endcanany

            @can('online.manage')
            <li class="{{ request()->routeIs('admin.online-orders.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.online-orders.index') }}">
                    <i class="bi bi-phone"></i>
                    <span class="nav-text">Online Orders</span>
                </a>
            </li>
            @endcan

            @canany(['settings.profile', 'settings.tax', 'settings.payments', 'settings.printers', 'settings.outlets'])
            <li class="{{ request()->routeIs('admin.settings.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);">
                    <i class="bi bi-gear"></i>
                    <span class="nav-text">Settings</span>
                </a>
                <ul aria-expanded="false">
                    @can('settings.profile')
                    <li><a href="{{ route('admin.settings.profile') }}">Restaurant Profile</a></li>
                    @endcan
                    @can('settings.tax')
                    <li><a href="{{ route('admin.settings.tax') }}">Tax Settings</a></li>
                    @endcan
                    @can('settings.payments')
                    <li><a href="{{ route('admin.settings.payments') }}">Payment Methods</a></li>
                    @endcan
                    @can('settings.printers')
                    <li><a href="{{ route('admin.settings.printers') }}">Printers</a></li>
                    @endcan
                    @can('settings.outlets')
                    <li><a href="{{ route('admin.settings.outlets.index') }}">Outlets</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
        </ul>
        <div class="copyright">
            <p><strong>{{ config('restaurant.name') }}</strong></p>
        </div>
    </div>
</div>
