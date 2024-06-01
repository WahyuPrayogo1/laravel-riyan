<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="ri-home-line"></i>Dashboard
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('penjualan.index') }}">
                            <i class="uil-money-withdrawal"></i>Kasir
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('barang.index') }}">
                            <i class="ri-folder-open-line"></i>Barang
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('history-penjualan') }}">
                            <i class="ri-history-fill"></i>History Penjualan
                        </a>

                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
