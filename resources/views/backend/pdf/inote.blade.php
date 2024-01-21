<!DOCTYPE html>
<html lang="bn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>I-Note</title>
 
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
  
</head>

<body>
    <div class="col-sm-12 col-xl-12">
        <div class=" inote_boc">
            <div class="header-box">
                <div class="title">
                    পরিদর্শন পত্র
                </div>
                <div class="content">

                    <div class="col-6">
                        <div class=" col-12 d-flex justify-content-between">
                            <div class=" d-flex col-4 p-2">বই নং : <input type="text " class="form-control"></div>
                            <div class=" d-flex col-4 p-2">সেট নং : <input type="text" class="form-control"></div>
                            <div class=" d-flex col-4 p-2">কপি সংখ্যা : <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class=" col-12 d-flex justify-content-between">

                            <div class=" d-flex col-4 p-2">কপি নং :<input type="text" class="form-control"></div>
                            <div class=" d-flex col-8 p-2">পরিদর্শন পত্র নং :<input type="text"
                                    class="form-control">
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
                            <label for="bookNumber">১. মূলাবেদন গ্রহন অথবা চুক্তিপত্র অথবা দর/ধারাবাহিক চুক্তিপত্র নং ও
                                তারিখ-</label>
                            <input type="text" id="bookNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="copyNumber">২। চাহিদা পত্র নং ও তারিখ-</label>
                            <input type="text" id="copyNumber" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inspectionNumber">৩ সরবরাহকারীর নাম ও ঠিকানা</label>
                            <input type="text" id="inspectionNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inspectionNumber">৪ গ্রাহক</label>
                            <input type="text" id="inspectionNumber" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inspectionNumber">৫ চাহিদাকারী-</label>
                            <input type="text" id="inspectionNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inspectionNumber">৬ দ্রব্যাদি পরিদর্শনের জন্য অর্পন/প্রেরন রেলযোগে করা
                                হইল-</label>
                            <input type="text" id="inspectionNumber" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inspectionNumber">৭ সরবরাহকারীর অর্পন পত্র নং ও তারিখ-</label>
                            <input type="text" id="inspectionNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inspectionNumber">৮ পূর্ন/অংশ/বাদ বাকি অংশ অর্পন করা হইল- </label>
                            <input type="text" id="inspectionNumber" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inspectionNumber">৯ দ্রব্যাদি পরিভাষিত সময়ে অথবা যোগ্য কর্তৃপক্ষ কর্তৃক বর্ধিত
                                সময়ে সরবরাহ করা হইয়াছে/না হইয়াছে/শাস্তি প্রদানের জন্য ক্রয় অফিসারকে জ্ঞাত করা
                                হইল</label>
                            <input type="text" id="inspectionNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inspectionNumber">১০ রেল রশিদ ফেরত নং ও তারিখ--</label>
                            <input type="text" id="inspectionNumber" class="form-control">
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
                            <td rowspan="2"> <input type="text" class="form-control"> </td>
                            <td rowspan="2" colspan="3">
                                <textarea name="" id="" class="form-control"></textarea>
                            </td>


                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"></td>
                            <td rowspan="2"> <input type="text" class="form-control"></td>
                        </tr>
                        <tr>

                            <td colspan="8">
                                <textarea name="" id="" class="form-control"></textarea>
                            </td>


                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer-box">

            </div>
        </div>

    </div>
</body>

</html>
