<div class="inote_boc mb-2">
    <form action="" id='updateInote' method="POST" enctype="multipart/form-data">
        <input type="hidden" id="inote_letter_id" name="inote_letter_id" value="{{ $inoteLetter->id }}">
        <div class="header-box">
            <div class="title">
                পরিদর্শন পত্র
            </div>
            <div class="content">

                <div class="col-6">
                    <div class=" col-12 d-flex justify-content-between">
                        <div class=" d-flex col-4 p-2">বই নং : <input type="text " class="form-control" id='book_no'
                                name='book_no' value="{{ $inoteLetter->book_no ? $inoteLetter->book_no : '' }}"></div>
                        <div class=" d-flex col-4 p-2">সেট নং : <input type="text" class="form-control"
                                id='set_no' name='set_no'
                                value="{{ $inoteLetter->set_no ? $inoteLetter->set_no : '' }}"></div>
                        <div class=" d-flex col-4 p-2">কপি সংখ্যা : <input type="text" class="form-control"
                                id='copy_number' name='copy_number'
                                value="{{ $inoteLetter->copy_number ? $inoteLetter->copy_number : '' }}">
                        </div>
                    </div>
                    <div class=" col-12 d-flex justify-content-between">

                        <div class=" d-flex col-4 p-2">কপি নং :<input type="text" class="form-control" id='copy_no'
                                name='copy_no' value="{{ $inoteLetter->copy_no ? $inoteLetter->copy_no : '' }}"></div>
                        <div class=" d-flex col-8 p-2">পরিদর্শন পত্র নং :<input type="text" class="form-control"
                                id='visiting_letter_no' name='visiting_letter_no'
                                value="{{ $inoteLetter->visiting_letter_no ? $inoteLetter->visiting_letter_no : '' }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="container mt-4">


            <div class="text-center m-2 p-2">পরিদর্শন প্রত্যয়ন পত্র</div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contract_reference_no">১. মূলাবেদন গ্রহন অথবা চুক্তিপত্র অথবা দর/ধারাবাহিক
                            চুক্তিপত্র নং ও
                            তারিখ-</label>
                        <input type="text" id="contract_reference_no" name='contract_reference_no'
                            class="form-control"
                            value="{{ $inoteLetter->contract_reference_no ? $inoteLetter->contract_reference_no : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="supplier_info">৩ সরবরাহকারীর নাম ও ঠিকানা</label>
                        <input type="text" id="supplier_info" name='supplier_info' class="form-control"
                            value="{{ $inoteLetter->supplier_info ? $inoteLetter->supplier_info : '' }}">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="indent_reference_no">২। চাহিদা পত্র নং ও তারিখ-</label>
                        <input type="text" id="indent_reference_no" name='indent_reference_no' class="form-control"
                            value="{{ $inoteLetter->indent_reference_no ? $inoteLetter->indent_reference_no : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="sender_id">৪. গ্রাহক-</label>
                        <input type="text" id="sender_id" name='sender_id' class="form-control"
                            value="{{ $inoteLetter->sender_id ? $inoteLetter->sender_id : '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cahidakari">৫. চাহিদাকারী-</label>
                        <input type="text" id="cahidakari" name="cahidakari" class="form-control"
                            value="{{ $inoteLetter->cahidakari ? $inoteLetter->cahidakari : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="supplier_orpon_letter">৭. সরবরাহকারীর অর্পন পত্র নং ও তারিখ-</label>
                        <input type="text" id="inspectionNumber" class="form-control"
                            value="{{ $inoteLetter->inspectionNumber ? $inoteLetter->inspectionNumber : '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="visiting_process">৬. দ্রব্যাদি পরিদর্শনের জন্য অর্পন/প্রেরন রেলযোগে করা
                            হইল-</label>
                        <input type="text" id="visiting_process" name='visiting_process' class="form-control"
                            value="{{ $inoteLetter->visiting_process ? $inoteLetter->visiting_process : '' }}">
                    </div>

                    <div class="form-group">
                        <label for="status">৮. পূর্ন/অংশ/বাদ বাকি অংশ অর্পন করা হইল- </label>
                        <input type="text" id="status" name="status" class="form-control"
                            value="{{ $inoteLetter->status ? $inoteLetter->status : '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="punishment">৯. দ্রব্যাদি পরিভাষিত সময়ে অথবা যোগ্য কর্তৃপক্ষ কর্তৃক বর্ধিত
                            সময়ে সরবরাহ করা হইয়াছে/না হইয়াছে/শাস্তি প্রদানের জন্য ক্রয় অফিসারকে জ্ঞাত করা
                            হইল</label>
                        <input type="text" id="punishment" name="punishment" class="form-control"
                            value="{{ $inoteLetter->punishment ? $inoteLetter->punishment : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="slip_return">১০. রেল রশিদ ফেরত নং ও তারিখ--</label>
                        <input type="text" id="slip_return" name="slip_return" class="form-control"
                            value="{{ $inoteLetter->slip_return ? $inoteLetter->slip_return : '' }}">
                    </div>
                </div>
            </div>


        </div>
        <div class="container mt-4">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="13">দ্রব্যাদি পরিদর্শনের বিবরণী</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> মূল্যবেদন
                            আইটেম নং</td>
                        <td> দ্রব্যাদি (আর্মির জন্য)</td>
                        <td> ক্যাট/পার্ট নং</td>
                        <td> দ্রব্যাদির বিবরণ</td>
                        <td> হিসাবের একক</td>
                        <td> †একক</td>
                        <td> পরিদর্শনের জন্য অর্পন করা হইল
                        </td>
                        <td> গ্রহন করা হইল
                        </td>
                        <td> বাতিল করা
                            হইল
                        </td>
                        <td> আজ পর্যন্ত মোট গ্রহন করা হইল
                        </td>
                        <td> খতিয়ান </td>
                        <td> পাতা</td>
                        <td>
                            মন্তব্য</td>
                    </tr>
                    <tr>
                        <td> ১</td>
                        <td> ২</td>
                        <td> ৩</td>
                        <td> ৪</td>
                        <td> ৫</td>
                        <td> ৬</td>
                        <td> ৭</td>
                        <td> ৮</td>
                        <td> ৯</td>
                        <td> ১০</td>
                        <td> ১১</td>
                        <td> ১২</td>
                        <td> ১৩</td>
                    </tr>
                    @foreach ($inoteLetterDetails as $details)
                        <tr>
                            <td rowspan="2">
                                <input type="text" id="serial_1_{{ $details->id }}"
                                    name="serial_1_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_1 ? $details->serial_1 : '' }}">
                            </td>
                            <td rowspan="2" colspan="3">
                                <textarea id="serial_2to4_{{ $details->id }}" name="serial_2to4_{{ $details->id }}" class="form-control">{{ $details->serial_2to4 ? $details->serial_2to4 : '' }}</textarea>
                            </td>

                            <td> <input type="text" id="serial_5_{{ $details->id }}"
                                    name="serial_5_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_5 ? $details->serial_5 : '' }}"></td>
                            <td> <input type="text" id="serial_6_{{ $details->id }}"
                                    name="serial_6_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_6 ? $details->serial_6 : '' }}"></td>
                            <td> <input type="text" id="serial_7_{{ $details->id }}"
                                    name="serial_7_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_7 ? $details->serial_7 : '' }}"></td>
                            <td> <input type="text" id="serial_8_{{ $details->id }}"
                                    name="serial_8_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_8 ? $details->serial_8 : '' }}"></td>
                            <td> <input type="text" id="serial_9_{{ $details->id }}"
                                    name="serial_9_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_9 ? $details->serial_9 : '' }}"></td>
                            <td> <input type="text" id="serial_10_{{ $details->id }}"
                                    name="serial_10_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_10 ? $details->serial_10 : '' }}"></td>
                            <td> <input type="text" id="serial_11_{{ $details->id }}"
                                    name="serial_11_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_11 ? $details->serial_11 : '' }}"></td>
                            <td> <input type="text" id="serial_12_{{ $details->id }}"
                                    name="serial_12_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_12 ? $details->serial_12 : '' }}"></td>
                            <td rowspan="2">
                                <input type="text" id="serial_13_{{ $details->id }}"
                                    name="serial_13_{{ $details->id }}" class="form-control"
                                    value="{{ $details->serial_13 ? $details->serial_13 : '' }}">
                                <br>
                                <a href="#" class="detailsUpload btn btn-danger m-2"
                                     data-detailsID='{{ $details->id }}'
                                    data-letterID="{{ $inoteLetter->id }}">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                <textarea id="body_info_{{ $details->id }}" name="body_info_{{ $details->id }}" class="form-control">{{ $details->body_info ? $details->body_info : '' }}</textarea>
                            </td>
                        </tr>
                    @endforeach




                </tbody>
            </table>
            <div class="d-flex col-4 mt-3">
                <p class="">স্টেশন- </p><input type="text" class="form-control me-5" id="station"
                    name="station" value="{{ $inoteLetter->station ? $inoteLetter->station : '' }}">
                <p>তারিখ-</p><input type="date" class="form-control me-5" id="date" name="date"
                    value="{{ $inoteLetter->date ? $inoteLetter->date : '' }}">
            </div>
        </div>

        <div class="footer-box d-flex justify-content-center mt-3 pb-2">

            <button type="submit" class="btn btn-success px-4 py-3"
                id="form_submission_button"><b>Update</b></button>
        </div>
    </form>
</div>
