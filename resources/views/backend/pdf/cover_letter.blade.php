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
    .header p{
        padding: 2px;
        margin: 0;
        font-size: 14px;
    }
    .row{
        font-size: 14px;
    }

</style>

<div class="row">
    <header>
        <p>RESTRICTED</p>
    </header>

    <div style="overflow: auto;">
        <div style="float: left; width: 40%; position:fixed; top:100px;">{{$cover_letter->letter_reference_no}}</div>
        <div class="header" style="float: right; width: 30%;">
            <p>{{$cover_letter->inspectorate_name}}</p>
            <p>{{$cover_letter->inspectorate_place}}</p>
            <p>Tel: {{$cover_letter->mobile}}</p>
            <p>Fax: {{$cover_letter->fax}}</p>
            <p>E-mail: {{$cover_letter->email}}</p>
            <p>{{$cover_letter->letter_date}}</p>
        </div>

        <div style="clear: both; text-decoration: underline;"><h4 style="padding:0px; margin-top:5px">{{$cover_letter->subject}}</h4></div>
        <div style="padding:0px; margin:0px">
            <p style="padding:0px; padding-top:5px; margin:0px">Fefs:</p>
            <div><p>{!! $cover_letter->body_1 !!}</p></div>
            <div><p>{!! $cover_letter->body_2 !!}</p></div>
        </div>
    </div>

    <div style="float: right; width: 30%; margin-top:70px;">
        {!!$cover_letter->name!!}
        <br>

        {!!$cover_letter->designation!!}
        <br>
        For Chief Inspector


    </div>

    <div style="clear: both;">
        <p>Anxs:</p>
        <div>{!! $cover_letter->anxs !!}</div>

    </div>
    <div>
        <p>Distr:</p>
        <div>{!! $cover_letter->distr !!}</div>
    </div>
    <div>
        <p>Extl:</p>
        <div>{!! $cover_letter->extl !!}</div>
    </div>
    <div>
        <p>Act:</p>
        <div>{!! $cover_letter->act !!}</div>
    </div>
    <div>
        <p>Info:</p>
        <div>{!! $cover_letter->info !!}</div>
    </div>

    <footer>
        <p>RESTRICTED</p>
    </footer>

</div>



