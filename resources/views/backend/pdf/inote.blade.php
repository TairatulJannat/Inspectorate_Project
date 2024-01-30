<!DOCTYPE html>
<html lang="bn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>I-Note</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/bootstrap.css') }}">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color:black;
        }

        .inote_boc {
            width: 100%;
            min-height: 700px;
            background-color: white
        }

        .header-box .title,
        .body-box .title {
            display: flex;
            justify-content: center;

        }

        .header-box .content {
            display: flex;
            justify-content: end;
        }

        .body-box .content {
            display: flex;
            justify-content: space-between;
        }

        .print-container {
            page-break-before: always;
        }

        .custom-table-border {
            border-color: rgb(33, 33, 33);
        }
    </style>

</head>

<body>
    <div class="print-container col-sm-12 col-xl-12 ">
        <div class="  inote_boc">
            <div class="p-2">
                <div class="header-box">
                    <div class="title">
                        <b> পরিদর্শন পত্র </b>
                    </div>
                    <div class="content">

                        <div class="col-6">
                            <div class=" col-12 d-flex justify-content-between">
                                <div class=" d-flex col-4 ">বই নং : {{ $inote_letter->book_no }}</div>
                                <div class=" d-flex col-4 ">সেট নং : {{ $inote_letter->set_no }}</div>
                                <div class=" d-flex col-4 ">কপি সংখ্যা : {{ $inote_letter->copy_number }}
                                </div>
                            </div>
                            <div class=" col-12 d-flex justify-content-between">

                                <div class=" d-flex col-4 ">কপি নং : {{ $inote_letter->copy_no }}</div>
                                <div class=" d-flex col-8 ">পরিদর্শন পত্র নং : {{ $inote_letter->visiting_letter_no }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-2">


                    <div class="text-center m-2 p-2"><b>পরিদর্শন প্রত্যয়ন পত্র</b> </div>

                    <div class="row">
                        <div class="col-6 ">
                            <div>
                                ১. মূলাবেদন গ্রহন অথবা চুক্তিপত্র অথবা দর/ধারাবাহিক চুক্তিপত্র নং ও
                                তারিখ- {{ $inote_letter->contract_reference_no }}
                            </div>
                            <div>
                                ২. চাহিদা পত্র নং ও তারিখ- {{ $inote_letter->indent_reference_no }}

                            </div>
                        </div>
                        <div class="col-6 ">
                            <div>
                                ৩. সরবরাহকারীর নাম ও ঠিকানা- {{ $inote_letter->supplier_info }}

                            </div>
                            <div>
                                ৪. গ্রাহক- {{ $inote_letter->sender_id }}

                            </div>
                        </div>
                        <div class="col-6 ">
                            <div>
                                ৫. চাহিদাকারী-{{ $inote_letter->cahidakari }}

                            </div>
                            <div>
                                ৬. দ্রব্যাদি পরিদর্শনের জন্য অর্পন/প্রেরন রেলযোগে করা
                                হইল- {{ $inote_letter->visiting_process }}

                            </div>
                        </div>
                        <div class="col-6 ">
                            <div>
                                ৭. সরবরাহকারীর অর্পন পত্র নং ও তারিখ- {{ $inote_letter->supplier_orpon_letter }}

                            </div>
                            <div>
                                ৮. পূর্ন/অংশ/বাদ বাকি অংশ অর্পন করা হইল- {{ $inote_letter->status }}

                            </div>
                        </div>
                        <div class="col-6 ">
                            <div>
                                ৯. দ্রব্যাদি পরিভাষিত সময়ে অথবা যোগ্য কর্তৃপক্ষ কর্তৃক বর্ধিত
                                সময়ে সরবরাহ করা হইয়াছে/না হইয়াছে/শাস্তি প্রদানের জন্য ক্রয় অফিসারকে জ্ঞাত করা
                                হইল- {{ $inote_letter->punishment }}

                            </div>

                        </div>
                        <div class="col-6 ">

                            <div>
                                ১০. রেল রশিদ ফেরত নং ও তারিখ- {{ $inote_letter->slip_return }}

                            </div>
                        </div>
                    </div>


                </div>
                <div class="mt-4 ">

                    <table class="table table-bordered custom-table-border">
                        <thead>
                            <tr class="text-center">
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
                                <td rowspan="2"> {{ $inote_letter->serial_1 }} </td>
                                <td rowspan="2" colspan="3"> {{ $inote_letter->serial_2to4 }}
                                </td>


                                <td rowspan="2">{{ $inote_letter->serial_5 }} </td>
                                <td rowspan="2"> {{ $inote_letter->serial_6 }}</td>
                                <td>{{ $inote_letter->serial_7 }} </td>
                                <td> {{ $inote_letter->serial_8 }}</td>
                                <td>{{ $inote_letter->serial_9 }} </td>
                                <td>{{ $inote_letter->serial_10 }} </td>
                                <td> {{ $inote_letter->serial_11 }}</td>
                                <td> {{ $inote_letter->serial_12 }}</td>
                                <td rowspan="2">{{ $inote_letter->serial_13 }} </td>
                            </tr>
                            <tr>

                                <td colspan="6">
                                    {{ $inote_letter->body_info }}
                                </td>


                            </tr>
                            <tr class="">
                                <td colspan="13">
                                    <div class="d-flex justify-content-between p-2">
                                        <div>উপরোক্ত দ্রব্যাদি পরিদর্শন করিয়া উহার ফলাফল প্রত্যেকটি দ্রব্যের বিগরীত
                                            উল্লেখপূবর্ক প্রত্যয়ন করা হইল।
                                            <br>
                                            স্টেশন- Dhaka Cantonment তারিখ-11 Apr 2023
                                        </div>
                                        <div><br> ------------------------------<br> পদনামসহ পরিদর্শকের সাক্ষর</div>
                                    </div>


                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="footer-box  ">
                    <div>
                        *অপ্রয়োজনীয় বিষয় বাদ দিতে হইবে। &nbsp;&nbsp;&nbsp; *পরিসংখ্যান সেকশন কতৃর্ক শুধুমাত্র কপি নং
                        ৬ এ
                        পূরণ করিবে।
                        <br>
                        দ্রষ্টব্যঃ সবশেষ আইটেমের পরে একটি লাইন টানিয়া উক্ত লাইনের নিচে মোট আইটেমের সংখ্যা উল্লেখ করিতে
                        হইবে
                        যাহা আলাদাভাবে &quot;দ্রব্যাদির বিবরণসহ পরিদর্শিত আইটেম নং--
                        (কথায়)&quot; প্রকাশ করিতে হইবে।
                    </div>

                </div>
            </div>


        </div>

    </div>
    <hr>

    <div class="print-container col-sm-12 col-xl-12 ">
        <div class="  inote_boc">
            <div class="p-2">
                <div class="header-box">
                    <div class="title">
                        <b> 2 পরিদর্শন পত্র </b>
                    </div>
                    <div>
                        <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
                    </div>

                </div>
                <div class="header-box">
                    <div class="title">
                        <b> 3 পরিদর্শন পত্র </b>
                    </div>
                    <div>
                        <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
                    </div>
                    <div>
                        <p> 1. aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
                        <p> 2. bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb</p>
                        <p> 3. ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc</p>

                    </div>

                </div>

                <div class="mt-4 ">

                    <table class="table table-bordered custom-table-border">

                        <tbody>
                            <tr>
                                <td class="col-1">
                                    আইটেম</td>
                                <td class="col-3"> দ্রব্যাদি (আর্মির জন্য)</td>
                                <td class="col-2"> ক্যাট/পার্ট নং</td>
                                <td class="col-1"> দ্রব্যাদির বিবরণ</td>
                                <td class="col-3"> হিসাবের একক</td>
                                <td class="col-2"> †একক</td>

                            </tr>
                            <tr>
                                <td> ১</td>
                                <td> ২</td>
                                <td> ৩</td>
                                <td> ৪</td>
                                <td> ৫</td>
                                <td> ৬</td>

                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="footer-box  ">
                    <div>
                        Station .....................Date................
                        <br>
                        Aria Circel......................................
                    </div>

                </div>
                <div class="header-box">
                    <div class="title">
                        <b> 4 পরিদর্শন পত্র </b>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p>1.mmmmmmmmmmmmmmmmmm</p>
                            <p>2.cccccccccccccccccc</p>
                            <p>3.fffffffffffffffffff</p>
                        </div>
                        <div class="col-6">
                            <p>1.mmmmmmmmmmmmmmmmmm</p>
                            <p>2.cccccccccccccccccc</p>
                            <p>3.fffffffffffffffffff</p>
                        </div>

                    </div>

                </div>
            </div>
            <div>
                <button class="btn btn-info print-button m-5 px-5 py-3" id="print_button">Print</button>
            </div>

        </div>

    </div>
    <script>
        document.getElementById('print_button').addEventListener('click', function() {
            printPage();
        });

        function printPage() {
            // Set the print styles
            var printStyles = `
            @page {
                size: legal landscape;
                margin-top: 0.5cm;
                margin-left: 1.18cm;
                margin-right: 0.75cm;
                margin-bottom: 0.5cm;

                @top-center {
                    content: "Your Page Header Here";
                }
                @bottom-center {
                    content: "Your Page Footer Here";
                }
            }
                @media print {
                    body {
                        margin: 0;
                    }
                    .print-button {
                        display: none !important;
        }
                }`;

            // Create a style element and append it to the head
            var style = document.createElement('style');
            style.type = 'text/css';
            style.innerHTML = printStyles;
            document.head.appendChild(style);

            // Print the page
            window.print();

            // Remove the added style element after printing
            style.parentNode.removeChild(style);
        }
    </script>

</body>

</html>
