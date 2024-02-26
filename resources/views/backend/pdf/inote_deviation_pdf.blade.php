<!DOCTYPE html>
<html lang="bn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deviation</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/bootstrap.css') }}">
    <style>
        .underline {
            text-decoration: underline;
        }

        * {
            font-size: 14px;
        }

        .deviation_box {
            margin: 40px;
        }
    </style>
</head>

<body>
    <div class=" col-sm-12 col-xl-12 ">
        <div class="deviation_box">
            <div class="row">
                <h5 class="text-center underline mb-2">APPLICATION FOR DEVIATION</h5>
            </div>
            {{-- this section for no 1  --}}
            <div class="row  mb-2">
                <div class="col-1">1.</div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-6 mb-2">Details of contract:</div>
                        <div class="col-6 mb-2">File no:</div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">a. Nomenclature:</div>

                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">b. Contract no & dt:</div>

                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">c. Supplier's name & address:</div>

                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">d. Quantity:</div>
                        <div class="col-6 mb-2">e. Others particulars:</div>

                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">(1) On order:</div>
                        <div class="col-6 mb-2">f. Classification of deviation</div>

                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <p>(2) Deviation required: </p>
                            <p>(3) Accepted to date:</p>

                        </div>
                        <div class="col-6 mb-2">g. Contract made on the basis on approved sample/advance sample basis.
                            The fol deviation (s) from particulars is/are recommended:</div>

                    </div>
                </div>

            </div>

            {{-- this section for no 2  --}}
            <div class="row mb-2">
                <div class="col-1">2.</div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-12 mb-2">The fol deviation (s) from particulars is/are recommended:</div>

                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">Text here</div>

                    </div>
                </div>
            </div>
            {{-- this section for no 3  --}}
            <div class="row mb-2">
                <div class="col-1">3.</div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-12 mb-2">The stores are required for issue to:</div>

                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">Text here</div>

                    </div>
                </div>
            </div>

            {{-- this section for no 4  --}}
            <div class="row mb-2">
                <div class="col-1">4.</div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-12 mb-2">It is considered that:</div>

                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">Text here</div>

                    </div>
                </div>
            </div>

            {{-- this section for no 5  --}}
            <div class="row mb-2">
                <div class="col-1">5.</div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-12 mb-2">Other remarks:</div>

                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">Text here</div>

                    </div>
                </div>
            </div>

            {{-- this section for no dci/go  --}}
            <div class="row mb-2">
                <div class="col-1"></div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4 mt-4">
                            <p class="p-0 m-0">DCI/GO</p>
                            <p class="p-0 m-0">Date......................</p>
                        </div>

                    </div>

                </div>
            </div>

            {{-- this section for no 6  --}}
            <div class="row mb-2">
                <div class="col-1">6.</div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-12">The deviation (s) applied for above is/are recommended/sanctioned in full
                            with &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; % price reduction is in part
                            .................................. above
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">Text here</div>

                    </div>
                </div>
            </div>


            {{-- this section for no sig and date  --}}
            <div class="row mb-2">
                <div class="col-1"></div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4  mt-3">
                            <p class="p-0 m-0">Col</p>
                            <p class="p-0 m-0">Chief Inspector</p>
                            <p class="p-0 m-0">I E & I, Dhaka Cantt</p>
                            <p class="p-0 m-0">Date......................</p>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6 ">
                    Copy to:
                    <p>DGDP</p>
                    <p>AFMSD</p>
                </div>

            </div>


        </div>
        <div>
            <button class="btn btn-info print-button m-5 px-5 py-3" id="print_button">Print</button>
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
                size: a4;
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
                    .deviation_box{
                        margin: 0px;
                        margin-left: 40px
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
