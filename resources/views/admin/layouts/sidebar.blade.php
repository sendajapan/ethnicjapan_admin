<!-- sidebar.php -->

<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
        <a href="{{ route('admin.dashboard') }}" class="brand-wrap">
            <img src="{{ asset('assets/imgs/theme/logo.png') }}" class="logo" alt="VPMS Dashboard" />
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize"><i
                    class="text-muted material-icons md-menu_open"></i></button>
        </div>
    </div>
    <nav>
        <ul class="menu-aside">
            <li class="menu-item {{ setActive(['admin.dashboard']) }}">
                <a class="menu-link {{ setActive(['admin.dashboard']) }}" href="{{ route('admin.dashboard') }}">
                    <i class="icon material-icons md-home text-muted"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li class="menu-item has-submenu {{ setActive(['admin.bank.*']) }} {{ setActive(['admin.accounts.*']) }} {{ setActive(['admin.transactions.*']) }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-request_quote text-muted"></i>
                    <span class="text">Finance</span>
                </a>
                <div class="submenu">
                    <a class="{{ setActive(['admin.bank.index']) }}" href="{{ route('admin.bank.index') }}">
                        <span class="text">Bank Accounts</span>
                    </a>
                    <a class="{{ setActive(['admin.accounts.index']) }}" href="{{ route('admin.accounts.index') }}">
                        <span class="text">Account Ledgers</span>
                    </a>
                    <a class="{{ setActive(['admin.transactions.create']) }}" href="{{ route('admin.transactions.create') }}">
                        <span class="text">Make Transactions</span>
                    </a>
                </div>
            </li>





            <li class="menu-item has-submenu {{ setActive(['admin.provider.*']) }} {{ setActive(['admin.customer.*']) }}">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-group text-muted"></i>
                    <span class="text">Contacts</span>
                </a>
                <div class="submenu">
                    <a class="{{ setActive(['admin.provider.index']) }}" href="{{ route('admin.provider.index') }}">
                        <span class="text">Suppliers/Providers List</span>
                    </a>
                    <a class="{{ setActive(['admin.customer.index']) }}" href="{{ route('admin.customer.index') }}">
                        <span class="text">Customers List</span>
                    </a>
                </div>
            </li>

            <!--
            <li class="menu-item {{ setActive(['admin.provider.*']) }}">
                <a class="menu-link {{ setActive(['admin.provider.index']) }}" href="{{ route('admin.provider.index') }}">
                    <i class="icon material-icons md-work text-muted"></i>
                    <span class="text">Suppliers/Providers List</span>
                </a>
            </li>

            <li class="menu-item {{ setActive(['admin.customer.*']) }}">
                <a class="menu-link {{ setActive(['admin.customer.index']) }}" href="{{ route('admin.customer.index') }}">
                    <i class="icon material-icons md-group text-muted"></i>
                    <span class="text">Customers List</span>
                </a>
            </li>
            -->


            <li class="menu-item {{ setActive(['admin.category.*']) }}">
                <a class="menu-link {{ setActive(['admin.category.index']) }}" href="{{ route('admin.category.index') }}">
                    <i class="icon material-icons md-category text-muted"></i>
                    <span class="text">Categories List</span>
                </a>
            </li>

            <li class="menu-item {{ setActive(['admin.ports.*']) }}">
                <a class="menu-link {{ setActive(['admin.ports.index']) }}" href="{{ route('admin.ports.index') }}">
                    <i class="icon material-icons md-category text-muted"></i>
                    <span class="text">Ports List</span>
                </a>
            </li>

            <li class="menu-item {{ setActive(['admin.item.*']) }}">
                <a class="menu-link {{ setActive(['admin.item.index']) }}" href="{{ route('admin.item.index') }}">
                    <i class="icon material-icons md-production_quantity_limits text-muted"></i>
                    <span class="text">Items / Products List</span>
                </a>
            </li>





            <li class="menu-item {{ setActive(['admin.purchase.*']) }}">
                <a class="menu-link {{ setActive(['admin.purchase.index']) }}" href="{{ route('admin.purchase.index') }}">
                    <i class="icon material-icons md-request_quote text-muted"></i>
                    <span class="text">Purchase Shipments</span>
                    @php
                        $shipmentCount = \App\Models\Shipment::count();
                    @endphp
                    @if($shipmentCount > 0)
                        <span class="badge bg-primary rounded-pill ms-2">{{ $shipmentCount }}</span>
                    @endif
                </a>
            </li>

            <li class="menu-item {{ setActive(['admin.inventory.*']) }}"> 
                <a class="menu-link {{ setActive(['admin.inventory.index']) }}" href="{{ route('admin.inventory.index') }}">
                    <i class="icon material-icons md-production_quantity_limits text-muted"></i>
                    <span class="text">Inventory</span>
                </a>
            </li>

            <li class="menu-item {{ setActive(['admin.sale.*']) }}">
                <a class="menu-link {{ setActive(['admin.sale.index']) }}" href="{{ route('admin.sale.index') }}">
                    <i class="icon material-icons md-payments text-muted"></i>
                    <span class="text">Sales List</span>
                </a>
            </li>


            <!-- <li class="menu-item {{ setActive(['admin.sale_report.*']) }}">
                <a class="menu-link {{ setActive(['admin.sale_report.index']) }}" href="{{ route('admin.sale_report.index') }}">
                    <i class="icon material-icons md-shopping_cart text-muted"></i>
                    <span class="text">Sales Report</span>
                </a>
            </li> -->






<?php /*
            <li class="menu-item {{ setActive(['admin.sale.*']) }}">
                <a class="menu-link {{ setActive(['admin.sale.index']) }}" href="{{ route('admin.sale.index') }}">
                    <i class="icon material-icons md-payments text-muted"></i>
                    <span class="text">Sales List</span>
                </a>
            </li>

            <li class="menu-item {{ setActive(['admin.stock.*']) }}">
                <a class="menu-link {{ setActive(['admin.stock.index']) }}" href="{{ route('admin.stock.index') }}">
                    <i class="icon material-icons md-shopping_cart text-muted"></i>
                    <span class="text">Stock Report</span>
                </a>
            </li>

            <li class="menu-item {{ setActive(['admin.purchase_report.*']) }}">
                <a class="menu-link {{ setActive(['admin.purchase_report.index']) }}" href="{{ route('admin.purchase_report.index') }}">
                    <i class="icon material-icons md-shopping_cart text-muted"></i>
                    <span class="text">Purchase Report</span>
                </a>
            </li>

            <li class="menu-item {{ setActive(['admin.sale_report.*']) }}">
                <a class="menu-link {{ setActive(['admin.sale_report.index']) }}" href="{{ route('admin.sale_report.index') }}">
                    <i class="icon material-icons md-shopping_cart text-muted"></i>
                    <span class="text">Sales Report</span>
                </a>
            </li>
*/ ?>



        </ul>
        <hr />
        <ul class="menu-aside">
            <li class="menu-item error">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <a class="menu-link error"  class="dropdown-item text-danger" href="#"  onclick="event.preventDefault(); this.closest('form').submit();">                    <?php echo csrf_field(); ?>

                    <i class="icon material-icons md-log_out text-muted"></i>
                    <span class="text">Logout</span>
                </a>
                </form>
            </li>
        </ul>
    </nav>
</aside>
