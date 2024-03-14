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

    /* scrollbar */
    #mainnav {
        height: calc(100vh - 78px);
        overflow-y: scroll;
        scrollbar-width: thin;
        scrollbar-color: #333 #e2e2e2;
    }


    #mainnav::-webkit-scrollbar {
        width: 8px;
    }

    #mainnav::-webkit-scrollbar-thumb {
        background-color: #333;
        border-radius: 4px;
    }

    #mainnav::-webkit-scrollbar-track {
        background-color: #e2e2e2;
    }
</style>
<header class="main-nav">

    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav  ">
                <ul class="nav-menu custom-scrollbar mt-2">
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
                                class="nav-link menu-title {{ $currentControllerName == 'search' ? 'active_menu' : '' }}"
                                href="{{ route('admin.search') }}"><i data-feather="search" class="text-light"></i>
                                <span>Search</span></a>

                        </li>
                    @endif
                    @if (count(menu_check('Indent')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'indent' ? 'active_menu' : '' }}"
                                href="javascript:void(0)"><i data-feather="file-text" class="text-light"></i>
                                <span>Indent</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/indent/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('indent/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.indent/view') }}"
                                            class="{{ Request::is('*/*/view') ? 'active_menu' : '' }}">View Indent</a>
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
                                class="nav-link menu-title {{ $currentControllerName == 'tender' ? 'active_menu' : '' }}"
                                href="javascript:void(0)"><i data-feather="file-text" class="text-light"></i>
                                <span>Tender</span></a>
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

                    @if (count(menu_check('Offer')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'offer' ? 'active_menu' : '' }}"
                                href="javascript:void(0)"><i data-feather="file-text" class="text-light"></i>
                                <span>Offer</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Offer/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('offer/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.offer/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View Offer</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('offer/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.offer/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create
                                            Offer</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif


                    {{-- start final sepecification --}}
                    @if (count(menu_check('FinalSpec')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'FinalSpec' ? 'active_menu' : '' }}"href="javascript:void(0)"><i
                                    data-feather="file-text" class="text-light"></i>
                                <span>Final Spec</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/FinalSpec/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('FinalSpec/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.FinalSpec/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View
                                            Final Spec</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('FinalSpec/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.FinalSpec/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create
                                            Final Spec</a>
                                    </li>
                                @endif
                                {{-- @if (sub_menu_check('FinalSpec/create') !== null)
                                    <li><a class="text-light"
                                            href="{{ url('admin/import-final-spec-data-index?refNo=FS-REF-14012024') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Import Final
                                            Spec</a></li>
                                @endif --}}
                            </ul>
                        </li>
                    @endif



                    {{-- Side Menu Button Links for draft Contract --}}
                    @if (count(menu_check('DraftContract')) !== 0)
                        <li class="dropdown">
                            <a class="nav-link menu-title text-white {{ $currentControllerName == 'draft_contract' ? 'active_menu' : '' }}" href="javascript:void(0)">
                                <i data-feather="file-text"></i> <!-- Add the icon for "Contract" -->
                                <span>Draft Contract</span>
                            </a>
                            <ul class="nav-submenu menu-content">
                                <li>
                                    <a href="{{ url('admin/draft_contract/view') }}"
                                        class="{{ Request::is('*/admin/draft_contract/view') ? 'active' : '' }} text-white">
                                        View Draft Contracts
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/draft_contract/create') }}"
                                        class="{{ Request::is('*/admin/draft_contract/create') ? 'active' : '' }} text-white">
                                        Create Draft Contract
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif
                    {{-- Side Menu Button Links for Contract --}}
                    @if (count(menu_check('Contract')) !== 0)
                        <li class="dropdown">
                            <a class="nav-link menu-title text-white {{ $currentControllerName == 'contract' ? 'active_menu' : '' }}" href="javascript:void(0)">
                                <i data-feather="file-text"></i> <!-- Add the icon for "Contract" -->
                                <span>Contract</span>
                            </a>
                            <ul class="nav-submenu menu-content">
                                <li>
                                    <a href="{{ url('admin/contract/view') }}"
                                        class="{{ Request::is('*/admin/contract/view') ? 'active' : '' }} text-white">
                                        View Contracts
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/contract/create') }}"
                                        class="{{ Request::is('*/admin/draft_contract/create') ? 'active' : '' }} text-white">
                                        Create Contract
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif


                    {{-- SI Links --}}
                    @if (count(menu_check('Si')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'si' ? 'active_menu' : '' }}"
                                href="javascript:void(0)"><i data-feather="file-text" class="text-light"></i>
                                <span>SI</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Si/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('si/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.si/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View
                                            SI</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('si/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.si/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create
                                            SI</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- Dummy PSI/QAC Links --}}
                    @if (count(menu_check('Qac')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'qac' ? 'active_menu' : '' }} {{ $currentControllerName == 'psi' ? 'active_menu' : '' }}"
                                href="javascript:void(0)"><i data-feather="file-text" class="text-light"></i>
                                <span>PSI/QAC</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Qac/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('qac/view') !== null)
                                    {{-- <li><a class="text-light" href="{{ route('admin.qac/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View PSI</a>
                                    </li> --}}
                                    <li><a class="text-light" href="{{ route('admin.qac/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View QAC</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('offer/create') !== null)
                                    {{-- <li><a class="text-light" href="{{ route('admin.offer/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create PSI</a>
                                    </li> --}}
                                    <li><a class="text-light" href="{{ route('admin.qac/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create QAC</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('qac/view') !== null)
                                    {{-- <li><a class="text-light" href="{{ route('admin.qac/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View PSI</a>
                                    </li> --}}
                                    <li><a class="text-light" href="{{ route('admin.psi/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View PSI</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('offer/create') !== null)
                                    {{-- <li><a class="text-light" href="{{ route('admin.offer/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create PSI</a>
                                    </li> --}}
                                    <li><a class="text-light" href="{{ route('admin.psi/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create PSI</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- Dummy JPSI Links --}}
                    @if (count(menu_check('Jpsi')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'jpsi' ? 'active_menu' : '' }}"
                                href="javascript:void(0)"><i data-feather="file-text" class="text-light"></i>
                                <span>JPSI</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/jpsi/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('jpsi/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.jpsi/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View
                                            JPSI</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('jpsi/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.jpsi/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create
                                            JPSI</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- Dummy I-Note Links --}}
                    @if (count(menu_check('Inote')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'inote' ? 'active_menu' : '' }}"
                                href="javascript:void(0)"><i data-feather="file-text" class="text-light"></i>
                                <span>I-Note</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Inote/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('inote/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.inote/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View
                                            I-Note</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('inote/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.inote/create') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create
                                            I-Note</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (count(menu_check('Inote')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'rr' ? 'active_menu' : '' }}"
                                href="javascript:void(0)"><i data-feather="file-text" class="text-light"></i>
                                <span>Report Return</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Inote/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('inote/view') !== null)

                                    <li><a class="text-light" href="{{ route('admin.rr/list') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Report List</a>

                                    </li>
                                @endif
                                @if (sub_menu_check('inote/create') !== null)
                                    <li><a class="text-light" href="{{ route('admin.rr/weekly') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Create Report</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- @if (count(menu_check('PrelimGeneral')) !== 0)
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
                    @endif --}}



                    {{-- @if (count(menu_check('Specification')) !== 0)
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
                    @endif --}}

                    {{-- Side Menu Button Links for Contracts --}}
                    {{-- @if (count(menu_check('Contract')) !== 0)
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
                    @endif --}}

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

                    {{-- Side Menu Button Links for Items --}}
                    @if (count(menu_check('Items')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white {{ $currentControllerName == 'items' ? 'active_menu' : '' }} {{ $currentControllerName == 'item_types' ? 'active_menu' : '' }}" href="javascript:void(0)"><i
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
                    {{-- Side Menu Button Links for Items --}}

                    {{-- Side Menu Button Links for Supllier --}}
                    @if (count(menu_check('Supplier')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white {{ $currentControllerName == 'supplier' ? 'active_menu' : '' }}" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Supplier</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/supplier/index') }}"
                                        class="{{ Request::is('*/admin/supplier/index') ? 'active' : '' }} text-white">Create
                                        Supplier
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    {{-- Side Menu Button Links for Supllier --}}

                    {{-- Side Menu Button Links for Parameters --}}
                    {{-- @if (count(menu_check('Parameter')) !== 0)
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
                    @endif --}}

                    {{-- Side Menu Button Links for Excel Files --}}
                    {{-- @if (count(menu_check('Excel')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Import Export Files</span></a>
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
                    @endif --}}


                    {{-- Side Menu Button Links for Comparative Statement Report (CSR) --}}
                    {{-- @if (count(menu_check('Excel')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Comparative Statement</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/csr/index') }}"
                                        class="{{ Request::is('*/admin/csr/index') ? 'active' : '' }} text-white">Comparative
                                        Statement Index</a>
                                </li>
                            </ul>
                        </li>
                    @endif --}}

                    {{-- Side Menu Button Links for Doc Types --}}
                    {{-- @if (count(menu_check('DocType')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title text-white" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Doc Types</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ url('admin/doc-type/index') }}"
                                        class="{{ Request::is('*/admin/doc-type/index') ? 'active' : '' }} text-white">Doc
                                        Types</a>
                                </li>
                            </ul>
                        </li>
                    @endif --}}



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

                    @if (count(menu_check('Route')) !== 0 || count(menu_check('Role')) !== 0 || count(menu_check('User')) !== 0)
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Role Permission</h6>
                            </div>
                        </li>
                    @endif



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
