<style>
    @font-face {
        font-family: 'Nikosh';
        src: url('http://sonnetdp.github.io/nikosh/css/nikosh.css') format('truetype');
    }

    @page {
        margin-top: 75px;
        margin-bottom: 45px;
    }

    header {
        position: fixed;
        top: -80px;
        left: 0;
        right: 0;
        height: 50px;
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
</style>

<div class="row">
    <header>
        <p>RESTRICTED</p>
    </header>

    <div style="overflow: auto;">
        <div style="float: left; width: 40%; position:fixed; top:100px;">{{ $cover_letter->letter_reference_no }}</div>
        <div class="header" style="float: right; width: 30%;">
            <p>{{ $cover_letter->inspectorate_name }}</p>
            <p>{{ $cover_letter->inspectorate_place }}</p>
            <p>Tel: {{ $cover_letter->mobile }}</p>
            <p>Fax: {{ $cover_letter->fax }}</p>
            <p>E-mail: {{ $cover_letter->email }}</p>
            <p>{{ $cover_letter->letter_date }}</p>
        </div>

        <div style="clear: both; text-decoration: underline;">
            <h4 style="padding:0px; margin-top:5px">{{ $cover_letter->subject }}</h4>
        </div>
        <div style="padding:0px; margin:0px">
            <p style="padding:0px; margin:0px">Refs:</p>
            <div class='refs_body_1'>{!! $cover_letter->body_1 !!}</div>
            <div>
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
    <div>
        <p style="margin: 10px 0;">Distr:</p>
        <div>{!! $cover_letter->distr !!}</div>
    </div>
    <div>
        <p style="margin: 10px 0;">Extl:</p>
        <div>{!! $cover_letter->extl !!}</div>
    </div>
    <div>
        <p style="margin: 10px 0;">Act:</p>
        <div>{!! $cover_letter->act !!}</div>
    </div>
    <div>
        <p style="margin: 10px 0;">Info:</p>
        <div>{!! $cover_letter->info !!}</div>
    </div>

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



    <footer>
        <p>RESTRICTED</p>
    </footer>

</div>
