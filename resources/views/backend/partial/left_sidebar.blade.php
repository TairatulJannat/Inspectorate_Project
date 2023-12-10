<?php
$currentControllerName = Request::segment(2);

?>
<style>
    li a span {
        color: #f6f6f6;
    }

    li a {
        color: #e2e2e2;
    }
</style>
<header class="main-nav">

    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ $currentControllerName == 'adminDashboard' ? 'active_menu' : '' }}"
                            href="{{ route('admin.adminDashboard') }}">
                            <i data-feather="home" class="text-light"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if (count(menu_check('Search')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'Search' ? 'active' : '' }}"
                                href="{{ route('admin.search') }}"><i data-feather="book-open"
                                    class="text-light"></i><span>Search</span></a>

                        </li>
                    @endif
                    @if (count(menu_check('Indent')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'Indent' ? 'active' : '' }}"
                                href="javascript:void(0)"><i data-feather="book-open"
                                    class="text-light"></i><span>Indent</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Indent/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('indent/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.indent/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View Indent</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('indent/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.indent/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create
                                            Indent</a></li>
                                @endif
                            </ul>
                        </li>

                    @endif

                    @if (count(menu_check('Tender')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'Tender' ? 'active' : '' }}"
                                href="javascript:void(0)"><i data-feather="book-open"
                                    class="text-light"></i><span>Tender</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Tender/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('tender/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.tender/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View Tender</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('tender/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.tender/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create
                                            Tender</a></li>
                                @endif
                            </ul>
                        </li>

                    @endif

                    @if (count(menu_check('PrelimGeneral')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'Indent' ? 'active' : '' }}"
                                href="javascript:void(0)"><i data-feather="book-open"
                                    class="text-light"></i><span>Specification</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Indent/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('prelimgeneral/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.prelimgeneral/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View
                                            Prelim/General</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('prelimgeneral/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.prelimgeneral/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create
                                            Prelim/General</a></li>
                                @endif
                                @if (sub_menu_check('prelimgen/revision') !== null)
                                    <li><a class="text-light" href="{{ route('admin.prelimgen/revision') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Revision
                                            Prelim/General</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- @if (count(menu_check('Tender')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Tender</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href=""
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">Option</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li>
                    @endif --}}

                    @if (count(menu_check('Specification')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Specification</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ route('admin.prelimgeneral/view') }}"
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">PrelimGeneral</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Side Menu Button Links for Contracts --}}
                    @if (count(menu_check('Contract')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="book-open"></i><span>Contracts</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/contract/index') }}"
                                        class="{{ Request::is('*/admin/contract/index') ? 'active' : '' }} text-white">Contracts
                                        Index</a>
                                </li>
                                <li><a href="{{ url('admin/contract/create') }}"
                                        class="{{ Request::is('*/admin/contract/create') ? 'active' : '' }} text-white">
                                        Create Contract</a>

                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Side Menu Button Links for Items --}}
                    @if (count(menu_check('Items')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Items</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/item_types/index') }}"
                                        class="{{ Request::is('*/admin/item_types/index') ? 'active' : '' }} text-white">Item
                                        Types
                                    </a>
                                </li>
                                <li><a href="{{ url('admin/items/index') }}"
                                        class="{{ Request::is('*/admin/items/index') ? 'active' : '' }} text-white">Items
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Side Menu Button Links for Inspectorates --}}
                    @if (count(menu_check('Inspectorate')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Inspectorates</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/inspectorates/index') }}"
                                        class="{{ Request::is('*/admin/inspectorates/index') ? 'active' : '' }} text-white">Inspectorates
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Side Menu Button Links for Parameters --}}
                    @if (count(menu_check('Parameter')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Parameters</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/parameter_groups/index') }}"
                                        class="{{ Request::is('*/admin/parameter_groups/index') ? 'active' : '' }} text-white">Parameter
                                        Groups</a>
                                </li>
                                <li><a href="{{ url('admin/assign-parameter-value/index') }}"
                                        class="{{ Request::is('*/admin/assign-parameter-value/index') ? 'active' : '' }} text-white">Item
                                        Parameters</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Side Menu Button Links for Doc Types --}}
                    @if (count(menu_check('DocType')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Doc Types</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/doc-type/index') }}"
                                        class="{{ Request::is('*/admin/doc-type/index') ? 'active' : '' }} text-white">Doc
                                        Types</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Side Menu Button Links for Excel Files --}}
                    @if (count(menu_check('Excel')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Excel Files</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/import-indent-spec-data-index') }}"
                                        class="{{ Request::is('*/admin/import-indent-spec-data-index') ? 'active' : '' }} text-white">Indent
                                        Spec Excel</a>
                                </li>
                                <li><a href="{{ url('admin/import-supplier-spec-data-index') }}"
                                        class="{{ Request::is('*/admin/import-supplier-spec-data-index') ? 'active' : '' }} text-white">Supplier
                                        Spec Excel</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Side Menu Button Links for Excel Files --}}
                    @if (count(menu_check('Excel')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>CSR</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/csr/index') }}"
                                        class="{{ Request::is('*/admin/csr/index') ? 'active' : '' }} text-white">CSR
                                        Index</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (count(menu_check('Contact')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Contact</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href=""
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">Option</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (count(menu_check('I-Note')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                    data-feather="list"></i><span>I-Note</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href=""
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">Option</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    {{-- <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>Tender</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="" class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">Option</a>
                            </li>
                            <li><a href="" class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>Specification</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="" class="">Option</a>
                            </li>
                            <li><a href="" class="">Option</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>Contact</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="" class="">Option</a>
                            </li>
                            <li><a href="" class="">Option</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>I-Note</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="" class="">Option</a>
                            </li>
                            <li><a href="" class="">Option</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>Settings</span></a>
                        <ul class="nav-submenu menu-content">

                            <li><a href=""
                                class=""> <span>Document Type</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Department Management</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Section Management</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Army Division</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Army Battalion</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Army Unit</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Additional Documents</span></a>
                            </li>
                        </ul>
                    </li> --}}

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Role Permission</h6>
                        </div>
                    </li>

                    {{-- @if (count(menu_check('Menu')) !== 0) --}}
                    {{-- <li class="dropdown"><a class="nav-link menu-title active" href="javascript:void(0)"><i --}}
                    {{-- data-feather="list"></i><span>Menu</span></a> --}}
                    {{-- <ul class="nav-submenu menu-content"> --}}
                    {{-- <li><a href="{{route('admin.menu/menu_create')}}" class="active">Create Menu</a></li> --}}
                    {{-- <li><a href="{{route('admin.menu/all_menu')}}" class="{{Request::is('*/*/all_menu')?'active': ''}}">All Menu</a></li> --}}
                    {{-- </ul> --}}
                    {{-- </li> --}}
                    {{-- @endif --}}

                    @if (count(menu_check('Route')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ Request::is('*/dynamic_route') ? 'active' : '' }}"
                                style="color: #fff" href="{{ route('admin.dynamic_route') }}"><i
                                    data-feather="home"></i><span>Module/Route</span></a>
                        </li>
                    @endif

                    @if (count(menu_check('Role')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ Request::is('*/role/*') ? 'active' : '' }}"
                                style="color: #fff" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Roles</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ route('admin.role/all_role') }}" style="color: #fff"
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">All role</a></li>
                                <li><a href="{{ route('admin.role/add_role') }}" style="color: #fff"
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Add role</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (count(menu_check('User')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ Request::is('*/all_user') ? 'active' : '' }}"
                                style="color: #fff" href="{{ route('admin.all_user') }}"><i
                                    data-feather="home"></i><span>Admin
                                    Users</span></a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
