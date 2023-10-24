@extends('backend.app')
@section('title','Create Menu')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">

    <style>
        .treeview .btn-default {
            border-color: #e3e5ef;
        }

        .treeview .btn-default:hover {
            background-color: #f7faea;
            color: #bada55;
        }

        .treeview ul {
            list-style: none;
            padding-left: 32px;
        }

        .treeview ul li {
            padding: 15px 0px 0px 35px;
            position: relative;
        }

        .treeview ul li:before {
            content: "";
            position: absolute;
            top: -26px;
            left: -31px;
            border-left: 2px dashed #a2a5b5;
            width: 1px;
            height: 100%;
        }

        .treeview ul li:after {
            content: "";
            position: absolute;
            border-top: 2px dashed #a2a5b5;
            top: 33px;
            left: -30px;
            width: 65px;
        }

        .treeview ul li:last-child:before {
            top: -22px;
            height: 90px;
        }

        .treeview > ul > li:after, .treeview > ul > li:last-child:before {
            content: unset;
        }

        .treeview > ul > li:before {
            top: 90px;
            left: 36px;
        }

        .treeview > ul > li:not(:last-child) > ul > li:before {
            content: unset;
        }

        .treeview > ul > li > .treeview__level:before {
            height: 60px;
            width: 60px;
            top: -9.5px;
            background-color: #54a6d9;
            border: 7.5px solid #d5e9f6;
            font-size: 22px;
        }

        .treeview > ul > li > ul {
            padding-left: 34px;
        }

        .treeview__level {
            padding: 7px;
            padding-left: 42.5px;
            display: inline-block;
            border-radius: 5px;
            font-weight: 700;
            border: 1px solid #e3e5ef;
            position: relative;
            z-index: 1;
        }

        .treeview__level:before {
            content: attr(data-level);
            position: absolute;
            left: -27.5px;
            top: -6.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 45px;
            width: 45px;
            border-radius: 50%;
            border: 7.5px solid #eef6d5;
            background-color: #bada55;
            color: #fff;
            font-size: 20px;
        }

        .treeview__level-btns {
            margin-left: 15px;
            display: inline-block;
            position: relative;
        }

        .treeview__level .level-same, .treeview__level .level-sub {
            position: absolute;
            display: none;
            transition: opacity 250ms cubic-bezier(0.7, 0, 0.3, 1);
        }

        .treeview__level .level-same.in, .treeview__level .level-sub.in {
            display: block;
        }

        .treeview__level .level-same.in .btn-default, .treeview__level .level-sub.in .btn-default {
            background-color: #faeaea;
            color: #da5555;
        }

        .treeview__level .level-same {
            top: 0;
            left: 45px;
        }

        .treeview__level .level-sub {
            top: 42px;
            left: 0px;
        }

        .treeview__level .level-remove {
            display: none;
        }

        .treeview__level.selected {
            background-color: #f9f9fb;
            box-shadow: 0px 3px 15px 0px rgba(0, 0, 0, 0.10);
        }

        .treeview__level.selected .level-remove {
            display: inline-block;
        }

        .treeview__level.selected .level-add {
            display: none;
        }

        .treeview__level.selected .level-same, .treeview__level.selected .level-sub {
            display: none;
        }

        .treeview .level-title {
            cursor: pointer;
            user-select: none;
        }

        .treeview .level-title:hover {
            text-decoration: underline;
        }

        .treeview--mapview ul {
            justify-content: center;
            display: flex;
        }

        .treeview--mapview ul li:before {
            content: unset;
        }

        .treeview--mapview ul li:after {
            content: unset;
        }

    </style>

@endpush
@section('main_menu','HOME')
@section('active_menu','Create Menu')
@section('link',route('admin.dynamic_route'))
@section('content')

    <div class="treeview js-treeview">
        <ul>

            @foreach(\App\Http\Controllers\Admin\MenuController::getMainMenu() as $menu)
                @if(count($menu->childs))
                    <li>
                        <div class="treeview__level" data-level="A">
                            <span class="level-title">{{$menu->menu_name}}</span>
                            <div class="treeview__level-btns">
                                <div class="btn btn-default btn-sm level-add"><span class="fa fa-plus"></span></div>
                                <div class="btn btn-default btn-sm level-remove"><span class="fa fa-trash text-danger"></span></div>
                                <div class="btn btn-default btn-sm level-sub"><span>Add Sub Level</span></div>
                            </div>
                        </div>
                        <ul>

                            @foreach($menu->childs as $secondLevel)

                                @if(count(\App\Http\Controllers\Admin\MenuController::getLevel3Childern($secondLevel->id)))

                                    <li>
                                        <div class="treeview__level" data-level="B">
                                            <span class="level-title">{{$secondLevel->menu_name}}</span>
                                            <div class="treeview__level-btns">
                                                <div class="btn btn-default btn-sm level-add"><span class="fa fa-plus"></span></div>
                                                <div class="btn btn-default btn-sm level-remove"><span
                                                        class="fa fa-trash text-danger"></span></div>
                                                <div class="btn btn-default btn-sm level-sub"><span>Add Sub Level</span></div>
                                            </div>
                                        </div>
                                        @foreach(\App\Http\Controllers\Admin\MenuController::getLevel3Childern($secondLevel->id) as $ThirdMenu)
                                            <ul>
                                                <li>
                                                    <div class="treeview__level" data-level="C">
                                                        <span class="level-title">{{$ThirdMenu->menu_name}}</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </li>
                                @else
                                    <li>
                                        <div class="treeview__level" data-level="B">
                                            <span class="level-title">{{$secondLevel->menu_name}}</span>
                                            <div class="treeview__level-btns">
                                                <div class="btn btn-default btn-sm level-add"><span class="fa fa-plus"></span></div>
                                                <div class="btn btn-default btn-sm level-remove"><span
                                                        class="fa fa-trash text-danger"></span></div>
                                                <div class="btn btn-default btn-sm level-sub"><span>Add Sub Level</span></div>
                                            </div>
                                        </div>
                                    </li>
                                @endif

                            @endforeach

                        </ul>
                    </li>
                @else
                    <li>
                        <div class="treeview__level" data-level="A">
                            <span class="level-title">{{$menu->menu_name}}</span>
                            <div class="treeview__level-btns">
                                <div class="btn btn-default btn-sm level-add"><span class="fa fa-plus"></span></div>
                                <div class="btn btn-default btn-sm level-remove"><span class="fa fa-trash text-danger"></span></div>
                                <div class="btn btn-default btn-sm level-sub"><span>Add Sub Level</span></div>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>


    <template id="levelMarkup">
        <li>
            <div class="treeview__level" data-level="A">
                <span class="level-title">Level A</span>
                <div class="treeview__level-btns">
                    <div class="btn btn-default btn-sm level-add"><span class="fa fa-plus"></span></div>
                    <div class="btn btn-default btn-sm level-remove"><span class="fa fa-trash text-danger"></span></div>
                    <div class="btn btn-default btn-sm level-same"><span>Add Same Level</span></div>
                    <div class="btn btn-default btn-sm level-sub"><span>Add Sub Level</span></div>
                </div>
            </div>
            <ul>
            </ul>
        </li>
    </template>
















    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Total: <span class="badge badge-secondary" id="total_data"></span></h3>
            <a href="{{route('admin.menu/menu_create')}}" type="button" class="btn-sm btn-success" style="margin-left: 85%">Create Menu</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered yajra-datatable">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Menu Name</th>
                    <th>Menu Bangla Name</th>
                    <th>Activation Status</th>
                    <th>Icon Class</th>
                    <th>Parent Menu</th>
                    <th>Route</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


@endsection
@push('js')
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
{{--    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>--}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
{{--    <script src="{{ asset('js/datatables.js') }}"></script>--}}
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
        // load data table
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                "order": [[1, 'desc']],
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
                processing: true,
                serverSide: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                drawCallback: function (settings) {
                    var api = this.api();
                    $('#total_data').html(api.ajax.json().recordsTotal);
                },
                ajax: {
                    url: "{{ url('admin/menu/menu_search') }}",
                    type: 'POSt',
                    data: function (d) {
                        d._token = '{{csrf_token()}}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                    {data: 'menu_name', name: 'menu_name'},
                    {data: 'menu_name_bn', name: 'menu_name_bn'},
                    {data: 'menu_is_active', name: 'menu_is_active'},
                    {data: 'menu_icon_class', name: 'menu_icon_class'},
                    {data: 'parent_menu', name: 'parent_menu'},
                    {data: 'route', name: 'route'},
                    {data: 'action', name: 'action', searchable: false},
                ],
            });
            $('#search_form').on('submit', function (event) {
                event.preventDefault();
                table.draw(true);
            });
        });
    </script>


    <script>
        $(function () {
            let treeview = {
                resetBtnToggle: function () {
                    $(".js-treeview")
                        .find(".level-add")
                        .find("span")
                        .removeClass()
                        .addClass("fa fa-plus");
                    $(".js-treeview")
                        .find(".level-add")
                        .siblings()
                        .removeClass("in");
                },
                addSameLevel: function (target) {
                    let ulElm = target.closest("ul");
                    let sameLevelCodeASCII = target
                        .closest("[data-level]")
                        .attr("data-level")
                        .charCodeAt(0);
                    ulElm.append($("#levelMarkup").html());
                    ulElm
                        .children("li:last-child")
                        .find("[data-level]")
                        .attr("data-level", String.fromCharCode(sameLevelCodeASCII));
                },
                addSubLevel: function (target) {
                    let liElm = target.closest("li");
                    let nextLevelCodeASCII = liElm.find("[data-level]").attr("data-level").charCodeAt(0) + 1;
                    liElm.children("ul").append($("#levelMarkup").html());
                    liElm.children("ul").find("[data-level]")
                        .attr("data-level", String.fromCharCode(nextLevelCodeASCII));
                },
                removeLevel: function (target) {
                    target.closest("li").remove();

                }
            };

            // Treeview Functions
            $(".js-treeview").on("click", ".level-add", function () {
                $(this).find("span").toggleClass("fa-plus").toggleClass("fa-times text-danger");
                $(this).siblings().toggleClass("in");
            });

            // Add same level
            $(".js-treeview").on("click", ".level-same", function () {
                treeview.addSameLevel($(this));
                treeview.resetBtnToggle();
            });

            // Add sub level
            $(".js-treeview").on("click", ".level-sub", function () {
                treeview.addSubLevel($(this));
                treeview.resetBtnToggle();
            });
            // Remove Level
            $(".js-treeview").on("click", ".level-remove", function () {
                treeview.removeLevel($(this));
            });

            // Selected Level
            $(".js-treeview").on("click", ".level-title", function () {
                let isSelected = $(this).closest("[data-level]").hasClass("selected");
                !isSelected && $(this).closest(".js-treeview").find("[data-level]").removeClass("selected");
                $(this).closest("[data-level]").toggleClass("selected");
            });
        });

    </script>
@endpush
