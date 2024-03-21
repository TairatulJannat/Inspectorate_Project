<div class="inote_boc mb-2">
    <form action="" id='saveInote' method="POST" enctype="multipart/form-data">
        <input type="hidden" id="inote_reference_no" name="inote_reference_no" value="{{ $inote->reference_no }}">
        <div class="header-box">
            <div class="title">
                পরিদর্শন পত্র
            </div>
            <div class="content">

                <div class="col-6">
                    <div class=" col-12 d-flex justify-content-between">
                        <div class=" d-flex col-4 p-2">বই নং : <input type="text " class="form-control" id='book_no'
                                name='book_no'></div>
                        <div class=" d-flex col-4 p-2">সেট নং : <input type="text" class="form-control"
                                id='set_no' name='set_no'></div>
                        <div class=" d-flex col-4 p-2">কপি সংখ্যা : <input type="text" class="form-control"
                                id='copy_number' name='copy_number'>
                        </div>
                    </div>
                    <div class=" col-12 d-flex justify-content-between">

                        <div class=" d-flex col-4 p-2">কপি নং :<input type="text" class="form-control" id='copy_no'
                                name='copy_no'></div>
                        <div class=" d-flex col-8 p-2">পরিদর্শন পত্র নং :<input type="text" class="form-control"
                                id='visiting_letter_no' name='visiting_letter_no'>
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
                            value="{{ $inote->contract_reference_no ? $inote->contract_reference_no : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="supplier_info">৩ সরবরাহকারীর নাম ও ঠিকানা</label>
                        <input type="text" id="supplier_info" name='supplier_info' class="form-control"
                            value="{{ $supplier_details ? $supplier_details : '' }}">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="indent_reference_no">২। চাহিদা পত্র নং ও তারিখ-</label>
                        <input type="text" id="indent_reference_no" name='indent_reference_no' class="form-control"
                            value="{{ $inote->indent_reference_no ? $inote->indent_reference_no : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="sender_id">৪. গ্রাহক-</label>
                        <input type="text" id="sender_id" name='sender_id' class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cahidakari">৫. চাহিদাকারী-</label>
                        <input type="text" id="cahidakari" name="cahidakari" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="supplier_orpon_letter">৭. সরবরাহকারীর অর্পন পত্র নং ও তারিখ-</label>
                        <input type="text" id="inspectionNumber" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="visiting_process">৬. দ্রব্যাদি পরিদর্শনের জন্য অর্পন/প্রেরন রেলযোগে করা
                            হইল-</label>
                        <input type="text" id="visiting_process" name='visiting_process' class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="status">৮. পূর্ন/অংশ/বাদ বাকি অংশ অর্পন করা হইল- </label>
                        <input type="text" id="status" name="status" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="punishment">৯. দ্রব্যাদি পরিভাষিত সময়ে অথবা যোগ্য কর্তৃপক্ষ কর্তৃক বর্ধিত
                            সময়ে সরবরাহ করা হইয়াছে/না হইয়াছে/শাস্তি প্রদানের জন্য ক্রয় অফিসারকে জ্ঞাত করা
                            হইল</label>
                        <input type="text" id="punishment" name="punishment" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="slip_return">১০. রেল রশিদ ফেরত নং ও তারিখ--</label>
                        <input type="text" id="slip_return" name="slip_return" class="form-control">
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
                    <tr>
                        <td rowspan="2"> <input type="text" id="serial_1" name="serial_1"
                                class="form-control"> </td>
                        <td rowspan="2" colspan="3">
                            <textarea id="serial_2to4" name="serial_2to4" class="form-control"></textarea>
                        </td>

                        <td> <input type="text" id="serial_5" name="serial_5" class="form-control"></td>
                        <td> <input type="text" id="serial_6" name="serial_6" class="form-control"></td>
                        <td> <input type="text" id="serial_7" name="serial_7" class="form-control"></td>
                        <td> <input type="text" id="serial_8" name="serial_8" class="form-control"></td>
                        <td> <input type="text" id="serial_9" name="serial_9" class="form-control"></td>
                        <td> <input type="text" id="serial_10" name="serial_10" class="form-control"></td>
                        <td> <input type="text" id="serial_11" name="serial_11" class="form-control"></td>
                        <td> <input type="text" id="serial_12" name="serial_12" class="form-control"></td>
                        <td rowspan="2">
                            <input type="text" id="serial_13" name="serial_13" class="form-control">
                            <a href="#" class="btn btn-success m-2" id="cartItemBtn">+</a>

                        </td>
                    </tr>
                    <tr>

                        <td colspan="8">
                            <textarea id="body_info" name="body_info" class="form-control"></textarea>
                        </td>
                    </tr>
                </tbody>
                <tbody id="cartItem">
                </tbody>
            </table>
            <div class="d-flex col-4 mt-3">
                <p class="">স্টেশন- </p><input type="text" class="form-control me-5" id="station"
                    name="station">
                <p>তারিখ-</p><input type="date" class="form-control me-5" id="date" name="date">
            </div>
        </div>

        <div class="footer-box d-flex justify-content-center mt-3 pb-2">

            <button type="submit" class="btn btn-success px-4 py-3" id="form_submission_button"><b>Save &
                    Continue</b></button>
        </div>
    </form>
</div>
