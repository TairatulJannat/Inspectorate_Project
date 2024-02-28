<!DOCTYPE html>
<html lang="bn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DPL5</title>
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
                <div class="col-10 ">
                    <p class="text-end">DPL-15</p>
                </div>
            </div>
            <div class="row">
                <h5 class="text-center underline mb-1">DIRECTORATE GENERAL DEFENCE PURCHASE </h5>
                <h5 class="text-center underline mb-1">MINISTRY OF DEFENCE, DHAKA</h5>
                <h5 class="text-center underline mb-3">WARRANTY</h5>
            </div>

            {{-- this section for no 1  --}}
            <div class="row  mb-2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3 mb-2"><b> Firm's Name</b></div>
                        <div class="col-9 mb-2">:{{ $dpl15->firms_name }} </div>
                    </div>
                </div>
            </div>
            <div class="row  mb-2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3 mb-2"><b> Nomenclature of store</b></div>
                        <div class="col-9 mb-2">: {{ $dpl15->nomenclature }} </div>
                    </div>
                </div>
            </div>
            <div class="row  mb-2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3 mb-2"><b>Contract no</b></div>
                        <div class="col-9 mb-2">: {{ $dpl15->contract_no }} </div>
                    </div>
                </div>
            </div>
            <div class="row  mb-2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3 mb-2"><b>Qty</b> </div>
                        <div class="col-9 mb-2">: {{ $dpl15->qty }} </div>
                    </div>
                </div>
            </div>
            <div class="row  mb-2 mt-3">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-2">{{ $dpl15->warranty }} </div>

                    </div>
                </div>
            </div>
            <div class="row  mb-2 mt-3">
                <div class="col-12">
                    <div class="row">
                        <div class="col-7 mb-2"></div>
                        <div class="col-5 mb-2 mt-3">Signature <br>Date...................... </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <h6 class="text-center underline mt-2 mb-5 pb-5">COUNTERSIGNED</h6>

            </div>

            <div class="row mb-2">
                <div class="col-6 ">

                    <p>Action:</p>
                    <p>{{ $dpl15->action }}</p>
                    {{-- <p>AFMSD</p> --}}
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
