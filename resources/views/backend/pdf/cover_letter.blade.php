<style>
    @font-face {
        font-family: 'Nikosh';
        src: url('http://sonnetdp.github.io/nikosh/css/nikosh.css') format('truetype');
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
    <div style="width: 100%; text-align: center; margin-bottom:30px;">
        <p>RESTRICTED</p>
    </div>
    <div style="overflow: auto;">
        <div style="float: left; width: 40%;">{{$cover_letter->letter_reference_no}}</div>
        <div class="header" style="float: right; width: 30%;">
            <p>{{$cover_letter->inspectorate_name}}</p>
            <p>{{$cover_letter->inspectorate_place}}</p>
            <p>Tel: {{$cover_letter->mobile}}</p>
            <p>Fax: {{$cover_letter->fax}}</p>
            <p>E-mail: {{$cover_letter->email}}</p>
            <p>{{$cover_letter->letter_date}}</p>
        </div>
        <div style="clear: both; text-decoration: underline;"><h4>{{$cover_letter->subject}}</h4></div>
        <div>
            <p>Fefs:</p>
            <div>{!! $cover_letter->body_1 !!}</div>
            <div>{!! $cover_letter->body_2 !!}</div>
        </div>
    </div>

    <div style="float: right; width: 30%; margin-top:50px;">{!!$cover_letter->name!!}</div>
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
    <div style="width: 100%; text-align: center; margin-top:20px">
        <p>RESTRICTED</p>
    </div>

</div>



