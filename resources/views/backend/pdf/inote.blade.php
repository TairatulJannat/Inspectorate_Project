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
            color: black;
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

        .next_page div p {
            padding: 0;
            margin: 0;
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

        .row-height {
            height: 120px;
        }
    </style>

</head>

<body>
    <div class="print-container col-sm-12 col-xl-12 ">
        <div class="  inote_boc">
            <div class="p-2">
                <div class="d-flex justify-content-end pe-2">
                    <p>বি.এ.এফ.ওয়াই - ১৯৭৬ এর পরিবর্তে</p>
                </div>
                <div class="header-box">
                    <div class="title">
                        <b class="text-decoration-underline"> পরিদর্শন পত্র </b>
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


                    <div class="text-center m-2 p-2"><b class="text-decoration-underline">পরিদর্শন প্রত্যয়ন পত্র</b> </div>

                    <div class="row">
                        <div class="col-6 ">
                            <div>
                                ১. মূলাবেদন গ্রহন অথবা চুক্তিপত্র অথবা দর/ধারাবাহিক চুক্তিপত্র নং ও
                                তারিখ- {{ $inote_letter->contract_reference_no }}
                            </div>
                            <div>
                                ৩. সরবরাহকারীর নাম ও ঠিকানা- {{ $inote_letter->supplier_info }}

                            </div>

                        </div>
                        <div class="col-6 ">
                            <div>
                                ২. চাহিদা পত্র নং ও তারিখ- {{ $inote_letter->indent_reference_no }}

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
                                ৭. সরবরাহকারীর অর্পন পত্র নং ও তারিখ- {{ $inote_letter->supplier_orpon_letter }}

                            </div>

                        </div>
                        <div class="col-6 ">
                            <div>
                                *৬. দ্রব্যাদি পরিদর্শনের জন্য অর্পন/প্রেরন রেলযোগে করা
                                হইল- {{ $inote_letter->visiting_process }}

                            </div>
                            <div>
                                *৮. পূর্ন/অংশ/বাদ বাকি অংশ অর্পন করা হইল- {{ $inote_letter->status }}

                            </div>
                        </div>
                        <div class="col-6 ">
                            <div>
                                *৯. দ্রব্যাদি পরিভাষিত সময়ে অথবা যোগ্য কর্তৃপক্ষ কর্তৃক বর্ধিত
                                সময়ে সরবরাহ করা হইয়াছে/না হইয়াছে/শাস্তি প্রদানের জন্য ক্রয় অফিসারকে জ্ঞাত করা
                                হইল- {{ $inote_letter->punishment }}

                            </div>

                        </div>
                        <div class="col-6 ">

                            <div>
                                ১০. রেল রশিদ ফেরত নং ও তারিখ- {{ $inote_letter->slip_return? $inote_letter->slip_return : "............................................................"}}
                                <br>
                                অফিস কপিতে বাতিল মাল .......................................................................................................
                                <br>
                                বাতিল দ্রবাদি পাইলাম .......................................................................................................
                                <br>
                                সরবরাহকারীর স্বাক্ষর
                                 .......................................................................................................

                            </div>
                        </div>
                    </div>


                </div>
                <div class="mt-4 ">

                    <table class="table table-bordered custom-table-border">
                        <thead>
                            <tr class="text-center">
                                <th colspan="13" class="text-decoration-underline">দ্রব্যাদি পরিদর্শনের বিবরণী</th>
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
                                <td> একক</td>
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
                                        <div>উপরোক্ত দ্রব্যাদি পরিদর্শন করিয়া উহার ফলাফল প্রত্যেকটি দ্রব্যের বিরীত
                                            উল্লেখপূবর্ক প্রত্যয়ন করা হইল।
                                            <br>
                                            স্টেশন- {{ $inote_letter->station }} &nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;তারিখ-
                                            {{ $inote_letter->date }}
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
                        *অপ্রয়োজনীয় বিষয় বাদ দিতে হইবে। & পরিসংখ্যান সেকশন কতৃর্ক শুধুমাত্র কপি নং
                        ৬ এ
                        পূরণ করিবে।
                        <br>
                        দ্রষ্টব্যঃ সবশেষ আইটেমের পরে একটি লাইন টানিয়া উক্ত লাইনের নিচে মোট আইটেমের সংখ্যা উল্লেখ করিতে
                        হইবে
                        যাহা আলাদাভাবে &quot;দ্রব্যাদির বিবরণসহ পরিদর্শিত আইটেম
                        নং---------------------------------------
                        (কথায়)&quot; প্রকাশ করিতে হইবে।
                    </div>

                </div>
            </div>


        </div>

    </div>
    <hr>

    <div class="print-container col-sm-12 col-xl-12 ">
        <div class="inote_boc">
            <div class="p-2">
                <div class="header-box">
                    <div class="title mt-3">
                        <b class="text-decoration-underline"> ২। সরবরাহকারীর জন্য </b>
                    </div>
                    <div class="mt-3">
                        <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ৯০% আগাম অর্থ পাওয়ার জন্য সরবরাহকারীকে পরিদর্শন
                            পত্র কপি নং ২, ৪ এবং ৫ সহ ৯০% আগাম বিল নং ও তাং দিয়া বিল পরিশোধের জন্য পেশ করিতে হইবে।</p>
                    </div>

                </div>
                <div class="header-box next_page">
                    <div class="title mt-3">
                        <b class="text-decoration-underline"> ৩। প্রাপ্তি প্রত্যয়ন </b>
                    </div>
                    <div class="mt-3">
                        <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ১০০% পুরা অর্থ পরিশোধের জন্য গ্রাহক অফিস কর্তৃক
                            পরিদর্শন পত্র কপি নং ১, ২, ৪ এবং ৫; কপি নং ২ এবং ৫ ৯০% আগাম এবং বাকি ১০% অর্থ পরিশোধের জন্য
                            পূরন করিতে হইবে।</p>
                    </div>
                    <div class="mt-3">
                        <p> ১। &nbsp; &nbsp; &nbsp; &nbsp; প্রত্যয়ন করা হইতেছে যে, পশ্চাৎভাগে গ্রহনকৃত দ্রব্যাদি
                            নিম্নলিখিত ব্যতিক্রম ছাড়া ভাল অবস্থায় পাওয়া গিয়াছে।</p>
                        <p> ২। &nbsp; &nbsp; &nbsp; &nbsp; দ্রব্যাদি হিসাবভুক্ত করা হইল গ্রহন রশিদ নং
                            ................................................... আমার পরিবহন/মজুদ ইত্যাদি (পুরন করিতে
                            হইবে) .......................................................................... <br>&nbsp;
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;মাস হিসাবে সময়কাল
                            .........................................</p>
                        <p> ৩।&nbsp; &nbsp; &nbsp; &nbsp; চুক্তিপত্রের শর্তানুযায়ী ঘাটতি/ভাংগা/অথবা ভাড়ার জন্য ক্ষতি সরবরাহকারীর নিকট হইতে
                            আদায়কল্পে গ্রাহক অফিস কর্তৃক প্রস্তাবের বিবরণী।</p>

                    </div>

                </div>

                <div class="mt-4 ">

                    <table class="table table-bordered custom-table-border">

                        <tbody>
                            <tr>
                                <td class="col-1">
                                    আইটেম</td>
                                <td class="col-3"> কারনসমুহ</td>
                                <td class="col-2"> পরিমান</td>
                                <td class="col-1"> আইটেম</td>
                                <td class="col-3"> কারনসমুহ</td>
                                <td class="col-2"> পরিমান</td>

                            </tr>
                            <tr class="row-height">
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

                <div class="footer-box  d-flex">
                    <div class="col-6">
                        ষ্টেশন ........................................................... তাং
                        .............................................................
                        <br>
                        এরিয়া
                        সার্কেল....................................................................................................................
                    </div>
                    <div class="col-6 mt-4 mb-4">
                        স্বাক্ষর ..........................................
                        <br>
                        পদনাম .........................................
                    </div>

                </div>
                <div class="header-box">
                    <div class="title">
                        <b class="text-decoration-underline"> ৪। কপিসমূহ বিতরণ </b>
                    </div>
                    <div class="row next_page mt-3">
                        <div class="col-1"></div>
                        <div class="col-5">
                            <p class="mb-3"><strong>কপি নং</strong></p>
                            <p>১। "এ্যাকাউন্ট অফিস কপি নং ১"</p>
                            <p>২। "এ্যাকাউন্ট অফিস কপি নং ২"</p>
                            <p>*৩। "সরবরাহকারীর অফিস কপি"</p>
                            <p>৪। গ্রাহকের কপি যখন সরবরাহকারীর দ্রব্যাদি প্রেরন করিবে শুধুমাত্র তাহাকে দিতে হইবে</p>
                            <p>৫। এ্যাকাউন্ট অফিসারের জন্য অতিরিক্ত কপি সরবরাহকারীকে দিতে হইবে।</p>
                            <p>*এইরুপ চিহ্নিত কপিসহ দ্রব্যাদি বাতিল হইলে প্রদান করা উচিত।</p>
                            <p>পিপিডি শাখা-৩১১৩৯/৮৯-৯০/(এম)-০৩-০৬-১৯৯০-২,৫০০ প্যাড।</p>
                        </div>
                        <div class="col-6">
                            <p class="mb-3"><strong>কপি নং</strong></p>
                            <p>*৬। ক্রয় অফিসারের কপি (পরিদর্শক পাঠাইবে যখন সে পরিদর্শন করে।</p>
                            <p>*৭। পরিদর্শকের অফিস কপি।</p>
                            <p>৮। গ্রাহকের অগ্রিম কপি (পরিদর্শক পাঠাইবে)।</p>
                            <p>৯। গ্রাহকের কপি।</p>
                            <p>*১০। পরিদর্শক কর্তৃপক্ষের কপি (যখন পরিদর্শন পরিদর্শক কর্তৃপক্ষের দ্বারা করা হয় না</p>
                        </div>
                        <div class="col-1"></div>
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
