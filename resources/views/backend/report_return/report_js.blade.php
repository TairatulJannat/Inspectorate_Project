<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/40.2.0/ckeditor.min.js"
    integrity="sha512-8gumiqgUuskL3/m+CdsrNnS9yMdMTCdo5jj5490wWG5QaxStAxJSYNJ0PRmuMNYYtChxYVFQuJD0vVQwK2Y1bQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // save cover letter
    $('#myForm').submit(function(e) {

        e.preventDefault()

        var formData = {}; // Object to store form data

        $(this).find('input, textarea, select').each(function() {
            var fieldId = $(this).attr('id');
            var fieldValue = $(this).val();
            formData[fieldId] = fieldValue;
        });
        var report_html=$('#report_html').html();
        formData['report_html'] = report_html;

        $.ajax({
            url: '{{ url('admin/report_returns/store') }}',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastr.success('Information Saved', 'Saved');
            },
            error: function(error) {
                console.error('Error sending data:', error);
            }
        });
    });
//start update
    $('#update_form').off().on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData($('#update_form')[0]);
        $.ajax({
            url: "{{ url('admin/reportreturn/update') }}",
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
                    
                }
                if (response.success) {
                    // enableeButton()
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    toastr.success('Information Updated', 'Saved');
                    // $('#edit_model').modal('hide');
                }
                setTimeout(window.location.href = "", 40000);
            },
            error: function(response) {
                
                // clear_error_field();
                error_notification('Please fill up the form correctly and try again')
                

            }
        });
    })
//end update
    $('#rr_filter_btn').click(function(event) {
        event.preventDefault();
        var fromDate = $('input[name="from_date"]').val();
        var toDate = $('input[name="to_date"]').val();

        console.log(fromDate);
        console.log(toDate);

        $.ajax({
            url: "{{ url('admin/rr/report_data') }}",
            type: "POST",
            data: {
                'fromDate': fromDate,
                'toDate': toDate
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.error) {
                    error_notification(response.error)

                }
                if (response.success) {

                    toastr.success('Information Status', 'Found');
                    $('#report').html(report(response.reports))
                    ckEditor();
                }
                // setTimeout(window.location.href = "{{ route('admin.prelimgeneral/view') }}", 40000);
            },
            error: function(response) {

                error_notification('Please fill up the form correctly and try again')

            }
        });
    });

    function report(reports) {
        var html = `
            <div class="" >
                <div class="">
                    <div class="">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Weekly Report</h4>

                        </div>
                        <div class="modal-body">

                            <div class="row">

                                    <div class="col-12 text-center m-2">
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="col-1 m-2">
                                                <select name="page_size" class="form-control bg-success text-light" id="page_size">
                                                    <option value="A4">Select Page Size</option>
                                                    <option value="A4">A4</option>
                                                    <option value="Legal">Legal</option>
                                                    <option value="Letter">Letter</option>
                                                </select>
                                            </div>
                                            <div class="col-2 m-2">
                                                <input type="text" id="header_footer" class="form-control "
                                                    placeholder="Header Here">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-6 align-self-end">
                                            <div class="input-group ">
                                                <div class="input-group-prepend ">
                                                    <span class="input-group-text">23.01.901.051. </span>
                                                </div>
                                                <input type="text" class="form-control " id="letter_reference_no">
                                                <div class="input-group-append ">
                                                    <span class="input-group-text "> .{{ \Carbon\Carbon::now()->format('d.m.y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">

                                        </div>
                                        <div class="col-4">
                                            <div>
                                                <input type="text" class="form-control inspectorate_name" id="inspectorate_name"
                                                    name="inspectorate_name" placeholder="Inspectorate Name" value="I E & I">
                                                <input type="text" class="form-control place" id="place" name="place"
                                                    placeholder="Address" value="Dhaka Cantt">
                                                <input type="text" class="form-control mobile" id="mobile" name="mobile"
                                                    placeholder="Telephone" value="8711111 Ext-7122">
                                                <input type="text" class="form-control fax" id="fax" name="fax"
                                                    placeholder="fax" value="9837120">
                                                <input type="text" class="form-control email" id="email" name="email"
                                                    placeholder="email" value="iei.dci@army.mil.bd">
                                                <input type="text" class="form-control date" id="date" name="date"
                                                    placeholder="date">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <textarea class="form-control my-2" name="subject" id="subject" placeholder="Subject"></textarea>
                                        {{-- <input type="text" id="subject" class="form-control my-2" placeholder="Subject"> --}}
                                    </div>
                                    <div class="my-2">
                                        <label for="body_1">Refs: </label>
                                        <textarea class="form-control " name="body_1" id="body_1"></textarea>
                                    </div>
                                    <div class="my-2">
                                        <label for="body_2">Body </label>
                                        <textarea class="form-control " name="body_2" id="body_2"></textarea>
                                    </div>
                        `
        html += `<div class="row mt-2" id='report_html'>
            <div class="body_2_serial">
                1. In It of ref ltr, weekly return/reports of this inspectorate is as under:
            </div>
    <div class="col-12">`;
        let i=97
        for (const [category, values] of Object.entries(reports)) {
            const serial = String.fromCharCode(i++);
            html += `
            <p class=" m-0 pt-3"><b> ${serial}. ${category} Vetting</b></p>
        <table class="table table-bordered m-0 p-0">
            
            <tr class="m-0 p-0">
                <th>Sl no</th>
                <th>Received</th>
                <th>Vetted</th>
                <th>Under Vetted</th>
                <th>Cancelled/Rejected</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>Ctrl:${values.receive.controll} <br> Unctrl:${values.receive.uncontroll}</td>
                <td>Ctrl:${values.vetted.controll} <br> Unctrl:${values.vetted.uncontroll}</td>
                <td>Ctrl:${values.undervetted.controll} <br> Unctrl:${values.undervetted.uncontroll}</td>
                <td>Ctrl:Nil <br> Unctrl:Nil</td>
            </tr>
            <tr>
                <td class='text-end'><b>Total:</b></td>
                <td>${values.receive.total}</td>
                <td>${values.vetted.total}</td>
                <td>${values.undervetted.total}</td>
                <td>-</td>
            </tr>
        </table>`;
        }

        // Close the remaining divs
        html += `</div></div>`;

        // Add total row
        html += `
                </div>
            </div>`;
        html += `
                        <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4"></div>
                                        <div class="col-4 mt-5">

                                            <div class="mt-2">
                                                <label for="signature">Signature Details </label>
                                                <textarea class="form-control " name="signature" id="signature"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <label for="anxs">Anxs: </label>
                                            <textarea class="form-control" name="anxs" id="anxs"></textarea>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12 mt-2">
                                            <div>
                                                <label for="distr">Distr: </label>
                                                <textarea class="form-control" name="distr" id="distr"></textarea>
                                            </div>
                                            <div>
                                                <label for="extl">Extl: </label>
                                                <textarea class="form-control" name="extl" id="extl"></textarea>
                                            </div>
                                            <div>
                                                <label for="act">Act: </label>
                                                <textarea class="form-control" name="act" id="act"></textarea>
                                            </div>
                                            <div>
                                                <label for="info">info: </label>
                                                <textarea class="form-control" name="info" id="info"></textarea>
                                            </div>
                                            {{-- <input type="text" class="form-control" id="distr" placeholder="Distr">
                                                <input type="text" class="form-control" id="extl" placeholder="Extl">
                                                <input type="text" class="form-control" id="act" placeholder="Act">
                                                <input type="text" class="form-control" id="info" placeholder="info"> --}}

                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div>
                                            <label for="anxs">Internal: </label>
                                            <textarea class="form-control" name="internal" id="internal">
                                            </textarea>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12 mt-2">
                                            <div>
                                                <label for="anxs">Act: </label>
                                                <textarea class="form-control" name="internal_act" id="internal_act">
                                                    </textarea>
                                            </div>
                                            <div>
                                                <label for="anxs">Info: </label>
                                                <textarea class="form-control" name="internal_info" id="internal_info">
                                                    </textarea>
                                            </div>
                                            {{-- <input type="text" class="form-control" id="internal_act" placeholder="Act">
                                                <input type="text" class="form-control" id="internal_info" placeholder="Info"> --}}

                                        </div>
                                    </div>
                                    {{-- <div class="col-12 text-center">RESTRICTED</div> --}}

                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-success"> Save </button>
                                    </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
            `;

        return html;
    }

    function ckEditor() {
        ClassicEditor
            .create(document.querySelector('#body_1'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#body_2'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#anxs'))
            .catch(error => {

            });

        ClassicEditor
        .create(document.querySelector('#anxsEdit'))
        .catch(error => {

        });
        ClassicEditor
            .create(document.querySelector('#distr'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#extl'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#act'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#info'))
            .catch(error => {

            });

        ClassicEditor
            .create(document.querySelector('#internal'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#internal_info'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#internal_act'))
            .catch(error => {

            });

        ClassicEditor
            .create(document.querySelector('#signature'))
            .catch(error => {

            });



    }
</script>
