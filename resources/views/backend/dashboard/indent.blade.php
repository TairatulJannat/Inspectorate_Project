<style>
    .new-arrival-header {
        background-color: #1B4C43 !important;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px !important;
    }

    .new-arrival-header h3 {
        font-size: 32px !important;
        font-weight: bold;
        color: #ffffff;
        margin: 0 !important;
        padding: 0 !important;
    }

    .new-arrival-body {
        display: flex;
        justify-content: center;
        align-items: center;

        min-height: 120px;
    }

    .new-arrival-body h1 {
        font-size: 72px !important;
        font-weight: bold;
        color: #1B4C43;
        margin: 0 !important;
        padding: 0 !important;
    }

    .new-arrival-body h1 sub {
        font-size: 32px !important;
        font-weight: bold;
        color: #1B4C43;
        margin: 0 !important;
        padding: 0 !important;
    }

    .new-arrival-footer {
        display: flex;
        justify-content: end;
        align-items: center;
        padding: 0 20px 20px 0;
    }

    .new-arrival-footer a {
        color: #1B4C43;
        font-weight: bold;
    }

    .card {
        border-radius: 5px 5px 15px 15px;
    }

    .approved-header {
        background-color: #BA895D !important;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px !important;
    }

    .approved-header h3 {
        font-size: 32px !important;
        font-weight: bold;
        color: #ffffff;
        margin: 0 !important;
        padding: 0 !important;
    }

    .approved-body {
        display: flex;
        justify-content: center;
        align-items: center;

        min-height: 120px;
    }

    .approved-body h1 {
        font-size: 72px !important;
        font-weight: bold;
        color: #BA895D;
        margin: 0 !important;
        padding: 0 !important;
    }

    .approved-body h1 sub {
        font-size: 32px !important;
        font-weight: bold;
        color: #BA895D;
        margin: 0 !important;
        padding: 0 !important;
    }

    .approved-footer {
        display: flex;
        justify-content: end;
        align-items: center;
        padding: 0 20px 20px 0;
    }

    .approved-footer a {
        color: #BA895D;
        font-weight: bold;
    }

    .outgoing-header {
        background-color: #31D2F2 !important;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px !important;
    }

    .outgoing-header h3 {
        font-size: 32px !important;
        font-weight: bold;
        color: #ffffff;
        margin: 0 !important;
        padding: 0 !important;
    }

    .outgoing-body {
        display: flex;
        justify-content: center;
        align-items: center;

        min-height: 120px;
    }

    .outgoing-body h1 {
        font-size: 72px !important;
        font-weight: bold;
        color: #31D2F2;
        margin: 0 !important;
        padding: 0 !important;
    }

    .outgoing-body h1 sub {
        font-size: 32px !important;
        font-weight: bold;
        color: #31D2F2;
        margin: 0 !important;
        padding: 0 !important;
    }

    .outgoing-footer {
        display: flex;
        justify-content: end;
        align-items: center;
        padding: 0 20px 20px 0;
    }

    .outgoing-footer a {
        color: #31D2F2;
        font-weight: bold;
    }

    .dispatch-header {
        background-color: #D22D3D !important;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px !important;
    }

    .dispatch-header h3 {
        font-size: 32px !important;
        font-weight: bold;
        color: #ffffff;
        margin: 0 !important;
        padding: 0 !important;
    }

    .dispatch-body {
        display: flex;
        justify-content: center;
        align-items: center;

        min-height: 120px;
    }

    .dispatch-body h1 {
        font-size: 72px !important;
        font-weight: bold;
        color: #D22D3D;
        margin: 0 !important;
        padding: 0 !important;
    }

    .dispatch-body h1 sub {
        font-size: 32px !important;
        font-weight: bold;
        color: #D22D3D;
        margin: 0 !important;
        padding: 0 !important;
    }

    .dispatch-footer {
        display: flex;
        justify-content: end;
        align-items: center;
        padding: 0 20px 20px 0;
    }

    .dispatch-footer a {
        color: #D22D3D;
        font-weight: bold;
    }
</style>

<div class="col-xl-12 box-col-12 des-xl-100 mt-4">
    <div class="row">
        <div class="col-xl-3 col-50 box-col-6 des-xl-50">
            <div class="card">
                <div class="card-header new-arrival-header">
                    <div class="header-top d-sm-flex align-items-center">
                        <h3>New Arrival</h3>

                    </div>
                </div>
                <div class="card-body new-arrival-body p-0">
                    <div id="chart-dashbord"></div>
                    <div class="code-box-copy">
                        <h1>38 <sub>Indent</sub></h1>

                    </div>
                </div>
                <div class="footer new-arrival-footer">
                    <div class="code-box-copy">
                        <a href="{{ route('admin.indent/view') }}">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-50 box-col-6 des-xl-50">
            <div class="card">
                <div class="card-header approved-header">
                    <div class="header-top d-sm-flex align-items-center">
                        <h3>Decision</h3>

                    </div>
                </div>
                <div class="card-body approved-body p-0">
                    <div id="chart-dashbord"></div>
                    <div class="code-box-copy">
                        <h1>20 <sub>Indent</sub></h1>

                    </div>
                </div>
                <div class="footer approved-footer">
                    <div class="code-box-copy">
                        <a href="{{ route('admin.indent_approved/view') }}">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-50 box-col-6 des-xl-50">
            <div class="card">
                <div class="card-header outgoing-header">
                    <div class="header-top d-sm-flex align-items-center">
                        <h3>Outgoing</h3>

                    </div>
                </div>
                <div class="card-body outgoing-body p-0">
                    <div id="chart-dashbord"></div>
                    <div class="code-box-copy">
                        <h1>16 <sub>Indent</sub></h1>

                    </div>
                </div>
                <div class="footer outgoing-footer">
                    <div class="code-box-copy">
                        <a href="{{ route('admin.indent/outgoing') }}">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-50 box-col-6 des-xl-50">
            <div class="card">
                <div class="card-header dispatch-header">
                    <div class="header-top d-sm-flex align-items-center">
                        <h3>Dispatch</h3>

                    </div>
                </div>
                <div class="card-body dispatch-body p-0">
                    <div id="chart-dashbord"></div>
                    <div class="code-box-copy">
                        <h1>10 <sub>Indent</sub></h1>

                    </div>
                </div>
                <div class="footer dispatch-footer">
                    <div class="code-box-copy">
                        <a href="{{ route('admin.indent_dispatch/view') }}">View Details</a>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-xl-6 box-col-6">
        <div class="card">
          <div class="card-header pb-0">
            <h5>Indent report for last 4 month</h5>
          </div>
          <div class="card-body">
            <div id="basic-bar"></div>
          </div>
        </div>
      </div>
    <div class="col-sm-12 col-xl-6 box-col-6">
        <div class="card">
            <div class="card-header pb-0">
            <h5>   Overall Indent Report</h5>
            </div>
            <div class="card-body apex-chart">
                <div id="donutchart"></div>
            </div>
        </div>
    </div>

</div>
