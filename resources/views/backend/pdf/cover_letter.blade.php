<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cover letter</title>
    <style>
        @page {
            margin-top: 75px;
            margin-bottom: 45px;
        }

        @font-face {
            font-family: 'bengali';
            src: url('/BengaliFont.ttf') format('truetype');
            /* Replace with the actual path to your Bangla font file */
        }

        body {
            font-family: 'bengali', 'Arial', sans-serif;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            text-align: center;
            padding: 10px;
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            padding: 10px;
        }

        .header p {
            padding: 2px;
            margin: 0;
            font-size: 14px;
        }

        .row {
            font-size: 14px;
            font-family: 'nikosh', 'Times New Roman', sans-serif;
            /* Use single quotes around font family name */
        }

        .refs_body_1 {
            margin-top: 4px;

        }

        .refs_body_1 p {
            padding: 0px;
            margin: 0px;

        }

        .signature p {
            padding: 0px;
            margin: 0px;

        }

        /* .content {
            margin-top: 80px;
            margin-bottom: 60px;
        } */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        tr,
        td {
            padding: 5px;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <header>
        <p> {!! $cover_letter->header_footer !!}</p>
    </header>
    <footer>
        <p>{!! $cover_letter->header_footer !!}</p>
    </footer>
    <div class="row">

        <div class="content">
            <div style="overflow: auto;">
                <div style="float: left; width: 40%; position:fixed; top:105px; ">
                    {{ $cover_letter->letter_reference_no }}
                </div>
                <div class="header" style="float: right; width: 30%;">
                    <p>{{ $cover_letter->inspectorate_name }}</p>
                    <p>{{ $cover_letter->inspectorate_place }}</p>
                    <p>Tel: {{ $cover_letter->mobile }}</p>
                    <p>Fax: {{ $cover_letter->fax }}</p>
                    <p>E-mail: {{ $cover_letter->email }}</p>
                    <p>{{ $cover_letter->letter_date }}</p>
                </div>

                <div style="clear: both; text-decoration: underline;">
                    <h4 style="padding:0px; margin-top:8px ; text-align: justify;">{{ $cover_letter->subject }}</h4>
                </div>
                <div style="padding:0px; margin:0px">
                    <p style="padding:0px; margin:0px">Refs:</p>
                    <div class='refs_body_1' style="text-align: justify;">{!! $cover_letter->body_1 !!}</div>
                    <div style="text-align: justify;">
                        {!! $cover_letter->body_2 !!}
                    </div>
                </div>
            </div>

            <div class="signature" style="float: right; width: 30%; margin-top:70px;">
                {!! $cover_letter->signature !!}

            </div>

            <div style="clear: both;">
                <p style="margin: 10px 0;">Anxs / Enclosures:</p>
                <div>{!! $cover_letter->anxs !!}</div>
            </div>
            {{-- @if ($cover_letter->distr) --}}
                <div>
                    <p style="margin: 10px 0;">Distr:</p>
                    <div>{!! $cover_letter->distr !!}</div>
                </div>
            {{-- @endif --}}
            {{-- @if ($cover_letter->extl) --}}
                <div>
                    <p style="margin: 10px 0;">Extl:</p>
                    <div>{!! $cover_letter->extl !!}</div>
                </div>
            {{-- @endif --}}
            {{-- @if ($cover_letter->act) --}}
                <div>
                    <p style="margin: 10px 0;">Act:</p>
                    <div>{!! $cover_letter->act !!}</div>
                </div>
            {{-- @endif --}}
            {{-- @if ($cover_letter->info) --}}
                <div>
                    <p style="margin: 10px 0;">Info:</p>
                    <div>{!! $cover_letter->info !!}</div>
                </div>
            {{-- @endif --}}


            @if ($cover_letter->internal)
                <div>
                    <p style="margin: 10px 0;">Internal:</p>
                    <div>{!! $cover_letter->internal !!}</div>
                </div>
                <div>
                    <p style="margin: 10px 0;">Act:</p>
                    <div>{!! $cover_letter->internal_act !!}</div>
                </div>
                <div>
                    <p style="margin: 10px 0;">Info:</p>
                    <div>{!! $cover_letter->internal_info !!}</div>
                </div>
            @endif

        </div>
    </div>
</body>

</html>
