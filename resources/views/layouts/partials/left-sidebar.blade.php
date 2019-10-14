<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link bg-info">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->getName() }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('group.index') }}" class="nav-link {{ Request::is('group', 'group/*', 'group/create') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            @lang('general.groups')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('channel.index') }}" class="nav-link {{ Request::is('channel', 'channel/*', 'channel/create') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            @lang('general.channels')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('service.index') }}" class="nav-link {{ Request::is('service', 'service/*', 'service/create') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            @lang('general.services')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('integration-types.index') }}" class="nav-link {{ Request::is('integration-types', 'integration-types/*', 'integration-types/create') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            @lang('general.integration_types')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logs') }}" class="nav-link {{ Request::is('logs', 'logs/*', 'logs/create') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            @lang('general.logs')
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
