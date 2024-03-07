@extends('backend.app')
@section('title', 'I-Note')
@push('css')
    <style>
        .inote_boc {
            width: 100%;
            min-height: 600px;
            background-color: white
        }

        .header-box .title,
        .body-box .title {
            display: flex;
            justify-content: center;
            padding: 5px;
            margin: 5px;
        }

        .header-box .content {
            display: flex;
            justify-content: end;
        }

        .body-box .content {
            display: flex;
            justify-content: space-between;
        }
    </style>
@endpush
@section('main_menu', 'I-Note')
@section('active_menu', 'Layout')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="inote-tab" data-bs-toggle="tab" data-bs-target="#inote" type="button"
                    role="tab" aria-controls="inote" aria-selected="true">I-Note</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="daviation-tab" data-bs-toggle="tab" data-bs-target="#daviation" type="button"
                    role="tab" aria-controls="daviation" aria-selected="false">Daviation</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dpl5-tab" data-bs-toggle="tab" data-bs-target="#dpl5" type="button"
                    role="tab" aria-controls="dpl5" aria-selected="false">DPL-15</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="anx-tab" data-bs-toggle="tab" data-bs-target="#anx" type="button"
                    role="tab" aria-controls="anx" aria-selected="false">ANX </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            {{-- inote start here --}}
            <div class="tab-pane fade show active" id="inote" role="tabpanel" aria-labelledby="inote-tab">
                @include('backend.inote.all_inote_letter.inote_create')
            </div>
            {{-- inote end here --}}
            {{--  daviation start here --}}
            <div class="tab-pane fade" id="daviation" role="tabpanel" aria-labelledby="daviation-tab">
                @include('backend.inote.all_inote_letter.daviation_create')
            </div>
            {{--  daviation end here --}}

            {{-- dpl5 start here --}}
            <div class="tab-pane fade" id="dpl5" role="tabpanel" aria-labelledby="dpl5-tab">
                @include('backend.inote.all_inote_letter.dpl15_create')
            </div>
            {{-- dpl5 end here --}}
            {{-- ANX start here --}}
            <div class="tab-pane fade" id="anx" role="tabpanel" aria-labelledby="anx-tab">
                @include('backend.inote.all_inote_letter.anx_create')
            </div>
            {{-- dANXpl5 end here --}}
        </div>


    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            printCart()
            $('#saveInote').off().on('submit', function(event) {
                event.preventDefault();
                disableButton()
                var formData = new FormData($('#saveInote')[0]);

                $.ajax({
                    url: "{{ url('admin/inote_letter/store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.error) {
                            error_notification(response.error)
                            enableeButton()
                        }
                        if (response.success) {
                            enableeButton()
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            toastr.success('Information Saved', 'Saved');
                        }
                        var $active = $('.nav-tabs .nav-link.active');
                        var $next = $active.parent().next().find('.nav-link');

                        if ($next.length > 0) {
                            $next.tab('show');
                        }
                        // setTimeout(window.location.href =
                        //     "{{ route('admin.outgoing_inote/details', $inote->id) }}", 40000);
                    },
                    error: function(response) {
                        enableeButton()
                        clear_error_field();
                        error_notification('Please fill up the form correctly and try again')
                        $('#error_sender').text(response.responseJSON.errors.sender);
                        $('#error_reference_no').text(response.responseJSON.errors
                        .reference_no);
                        $('#error_inote_received_date').text(response.responseJSON.errors
                            .inote_received_date);
                        $('#error_inote_reference_date').text(response.responseJSON.errors
                            .inote_reference_date);

                    }
                });
            })

            $('#saveDeviation').off().on('submit', function(event) {
                event.preventDefault();
                disableButton()
                var formData = new FormData($('#saveDeviation')[0]);

                $.ajax({
                    url: "{{ url('admin/inote_deviation_letter/store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.error) {
                            error_notification(response.error)
                            enableeButton()
                        }
                        if (response.success) {
                            enableeButton()
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            toastr.success('Information Saved', 'Saved');
                        }

                        var $active = $('.nav-tabs .nav-link.active');
                        var $next = $active.parent().next().find('.nav-link');

                        if ($next.length > 0) {
                            $next.tab('show');
                        }
                        // setTimeout(window.location.href =
                        //     "{{ route('admin.outgoing_inote/details', $inote->id) }}", 40000);
                    },
                    error: function(response) {
                        enableeButton()
                        clear_error_field();
                        error_notification('Please fill up the form correctly and try again')
                        // $('#error_sender').text(response.responseJSON.errors.sender);
                        // $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                        // $('#error_inote_received_date').text(response.responseJSON.errors
                        //     .inote_received_date);
                        // $('#error_inote_reference_date').text(response.responseJSON.errors
                        //     .inote_reference_date);

                    }
                });
            })

            $('#saveDPL').off().on('submit', function(event) {
                event.preventDefault();
                disableButton()
                var formData = new FormData($('#saveDPL')[0]);

                $.ajax({
                    url: "{{ url('admin/inote_dpl_letter/store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.error) {
                            error_notification(response.error)
                            enableeButton()
                        }
                        if (response.success) {
                            enableeButton()
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            toastr.success('Information Saved', 'Saved');
                        }
                        var $active = $('.nav-tabs .nav-link.active');
                        var $next = $active.parent().next().find('.nav-link');

                        if ($next.length > 0) {
                            $next.tab('show');
                        }
                        // setTimeout(window.location.href =
                        //     "{{ route('admin.outgoing_inote/details', $inote->id) }}", 40000);
                    },
                    error: function(response) {
                        enableeButton()
                        clear_error_field();
                        error_notification('Please fill up the form correctly and try again')
                        // $('#error_sender').text(response.responseJSON.errors.sender);
                        // $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                        // $('#error_inote_received_date').text(response.responseJSON.errors
                        //     .inote_received_date);
                        // $('#error_inote_reference_date').text(response.responseJSON.errors
                        //     .inote_reference_date);

                    }
                });
            })

            $('#saveAnx').off().on('submit', function(event) {
            event.preventDefault();
            disableButton()
            var formData = new FormData($('#saveAnx')[0]);

                $.ajax({
                    url: "{{ url('admin/iNote/anx') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.error) {
                            error_notification(response.error)
                            enableeButton()
                        }
                        if (response.success) {
                            enableeButton()
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            toastr.success('Information Saved', 'Saved');
                        }
                        var $active = $('.nav-tabs .nav-link.active');
                        var $next = $active.parent().next().find('.nav-link');

                        if ($next.length > 0) {
                            $next.tab('show');
                        }

                    },
                    error: function(response) {
                        enableeButton()
                        // clear_error_field();
                        // error_notification('Please fill up the form correctly and try again')
                        // $('#error_sender').text(response.responseJSON.errors.sender);
                        // $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                        // $('#error_inote_received_date').text(response.responseJSON.errors
                        //     .inote_received_date);
                        // $('#error_inote_reference_date').text(response.responseJSON.errors
                        //     .inote_reference_date);

                    }
                });
             })
            $('#cartItemBtn').on('click', function(event) {
                event.preventDefault(); // Prevent default form submission
                $("#cartItem").append('');
                // Example of getting individual input values
                var serial_1_value = $('#serial_1').val();
                var serial_2to4_value = $('#serial_2to4').val();
                var serial_5_value = $('#serial_5').val();
                var serial_6_value = $('#serial_6').val();
                var serial_7_value = $('#serial_7').val();
                var serial_8_value = $('#serial_8').val();
                var serial_9_value = $('#serial_9').val();
                var serial_10_value = $('#serial_10').val();
                var serial_11_value = $('#serial_11').val();
                var serial_12_value = $('#serial_12').val();
                var serial_13_value = $('#serial_13').val();

                // Merge new data with existing data
                var formData = {
                    serial_1: serial_1_value,
                    serial_2to4: serial_2to4_value,
                    serial_5: serial_5_value,
                    serial_6: serial_6_value,
                    serial_7: serial_7_value,
                    serial_8: serial_8_value,
                    serial_9: serial_9_value,
                    serial_10: serial_10_value,
                    serial_11: serial_11_value,
                    serial_12: serial_12_value,
                    serial_13: serial_13_value
                };

                saveitem(formData);
                printCart()

            });
            $("body").on("click", ".delete", function() {
                event.preventDefault(); // Prevent default form submission

                let id = $(this).data("id");
                alert(id);
                $("#cartItem").append('');
                // delItem(id)
                // printCart();
            });


            function disableButton() {
                var btn = document.getElementById('form_submission_button');
                btn.disabled = true;
                btn.innerText = 'Saving....';
            }

            function enableeButton() {
                var btn = document.getElementById('form_submission_button');
                btn.disabled = false;
                btn.innerText = 'Save'
            }

            function saveitem(formData) {
                let cart = localStorage.getItem('formData');

                if (cart != null) {
                    cart = JSON.parse(cart);
                    cart.push(formData);
                    localStorage.setItem('formData', JSON.stringify(cart));

                } else {
                    cart = [];
                    cart.push(formData);
                    localStorage.setItem('formData', JSON.stringify(cart));
                }
            }

            function delItem(id) {
                event.preventDefault();
                let cart = localStorage.getItem("formData");
                if (cart != null) {
                    cart = JSON.parse(cart);
                    let tmp = [];

                    cart.forEach(function(item, i) {
                        if (id != item.serial_1) {
                            tmp.push(item);
                        }
                    });
                    localStorage.setItem('formData', JSON.stringify(tmp));

                }
            }


            function printCart() {
                let cart = localStorage.getItem('formData');
                let items = JSON.parse(cart);
                console.log(items);

                let $bill = "";

                if (items != null) {

                    items.forEach(function(item, i) {
                        //console.log(item.name);
                        let $html = `<tr>
                            <td rowspan="2"> ${item.serial_1} </td>
                            <td rowspan="2" colspan="3">
                                ${item.serial_1}
                            </td>

                            <td> ${item.serial_1}</td>
                            <td> ${item.serial_1}</td>
                            <td> ${item.serial_1}</td>
                            <td> ${item.serial_1}</td>
                            <td> ${item.serial_1}</td>
                            <td> ${item.serial_1}</td>
                            <td> ${item.serial_1}</td>
                            <td> ${item.serial_1}</td>
                            <td rowspan="2">
                                ${item.serial_1} <br>
                                <a href="#" class="delete btn btn-danger m-2"  data-id="${item.serial_1}">x</a>


                            </td>
                        </tr>
                        <tr>

                            <td colspan="8">
                                ${item.serial_1}
                            </td>


                        </tr>`
                        $bill += $html;

                    });
                }

                $("#cartItem").append($bill);
            }

            function clearCart() {
                localStorage.removeItem('formData');
                localStorage.setItem('formData', JSON.stringify([]));

            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Next button click event
            $("#nextBtn").click(function(e) {
                e.preventDefault()
                var $active = $('.nav-tabs .nav-link.active');
                var $next = $active.parent().next().find('.nav-link');

                if ($next.length > 0) {
                    $next.tab('show');
                }
            });

            // Previous button click event
            $("#prevBtn").click(function(e) {
                e.preventDefault()
                var $active = $('.nav-tabs .nav-link.active');
                var $prev = $active.parent().prev().find('.nav-link');

                if ($prev.length > 0) {
                    $prev.tab('show');
                }
            });
        });
    </script>
@endpush
