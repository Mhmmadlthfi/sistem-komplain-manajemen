<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <span class="app-brand-text menu-text fw-bolder ms-2">PT. Arhadi Fajar Perkasa</span>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('admin/dashboard') ? 'active open' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        {{-- Aftersales --}}
        @can('aftersalesOrManagerMarketing')
            <!-- Kelola Keluhan -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Kelola Keluhan</span>
            </li>
            <li class="menu-item {{ Request::is('admin/complaint*') ? 'active open' : '' }}">
                <a href="{{ route('complaint.index', ['status' => 'Diterima']) }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-archive-in'></i>
                    <div>Keluhan Masuk</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/handling*') ? 'active open' : '' }}">
                <a href="{{ route('handling.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-wrench"></i>
                    <div>Penanganan</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/resolved-complaint*') ? 'active open' : '' }}">
                <a href="{{ route('resolved-complaint.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-check-shield"></i>
                    <div>Data Keluhan</div>
                </a>
            </li>
            <!-- / Kelola Keluhan -->
        @endcan
        {{-- / Aftersales --}}

        {{-- Marketing --}}
        @can('marketingOrManagerMarketing')
            <!-- Penjualan Barang -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Penjualan</span>
            </li>
            <li class="menu-item {{ Request::is('admin/sales*') ? 'active open' : '' }}">
                <a href="{{ route('sales.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-rocket"></i>
                    <div>Penjualan Barang</div>
                </a>
            </li>
            <!-- / Penjualan Barang -->
            <!-- Data Master -->
            <li class="menu-item {{ Request::is('admin/master-data*') ? 'active open' : '' }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
                    <div data-i18n="Data Master">Data Master</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::is('admin/master-data/customer*') ? 'active open' : '' }}">
                        <a href="{{ route('customers.index') }}" class="menu-link">
                            <div data-i18n="Data Customer">Data Customer</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('admin/master-data/product*') ? 'active open' : '' }}">
                        <a href="{{ route('products.index') }}" class="menu-link">
                            <div data-i18n="Data Produk">Data Produk</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- / Data Master -->
        @endcan
        {{-- / Marketing --}}

        {{-- Manager Marketing --}}
        @can('managerMarketing')
            <!-- Kelola User -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Kelola User</span>
            </li>
            <li class="menu-item {{ Request::is('admin/manage-users') ? 'active open' : '' }}">
                <a href="{{ route('manage-users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div>Kelola User</div>
                </a>
            </li>
            <!-- / Kelola User -->
        @endcan
        {{-- Manager Marketing --}}

        <!-- Teknisi -->
        @can('technicians')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Penanganan Teknisi</span>
            </li>
            <li class="menu-item {{ Request::is('admin/technician-handling*') ? 'active open' : '' }}">
                <a href="{{ route('technician-handling.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-wrench'></i>
                    <div>Penanganan</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/technician-history*') ? 'active open' : '' }}">
                <a href="{{ route('technician-history.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-history"></i>
                    <div>Riwayat Penanganan</div>
                </a>
            </li>
        @endcan
        <!-- / Teknisi -->

        <!-- Logout -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Logout</span>
        </li>
        <li class="menu-item">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <div class="menu-link">
                    <button type="submit" class="btn p-0 border-0">
                        <i class='menu-icon tf-icons bx bx-log-out-circle'></i>
                        Logout
                    </button>
                </div>
            </form>
        </li>
        <!-- / Logout -->

</aside>
