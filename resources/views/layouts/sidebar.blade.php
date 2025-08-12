<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">@lang('translation.Menu')</li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">@lang('translation.Dashboards')</span>
                    </a>
                </li>
                @if (auth()->user()->type == 1)
                    <li>
                        <a href="{{ route('Questions.index') }}">
                            <i data-feather="edit-2"></i>
                            <span data-key="t-dashboard">الاسئلة</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Companies.index') }}">
                            <i data-feather="briefcase"></i>
                            <span data-key="t-dashboard">الشركات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Committes.index') }}">
                            <i data-feather="user"></i>
                            <span data-key="t-dashboard">اللجان</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Cities.index') }}">
                            <i data-feather="map-pin"></i>
                            <span data-key="t-dashboard">المدن</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('Tenders.index') }}">
                        <i data-feather="framer"></i>
                        <span data-key="t-dashboard">العطاءات</span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
