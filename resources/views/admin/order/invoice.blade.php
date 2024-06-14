<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">


   <style>
        @page {
            size: a4;
            margin: 0px;
        }

        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0px;
        }

        body {
            color: #666;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.6em;
            overflow-x: hidden;
            background-color: #f5f6fa;
        }

        .ll-invoice-in {
            padding: 0px 50px 30px;
            max-width: 1120px;
            margin: 0px auto;
            background: white;
            overflow: hidden;
            min-height: 1092px;
            position: relative;
        }

        .ll-invoice-head {
            position: relative;
            height: 110px;
            margin-bottom: 15px;
        }

        .ll-invoice-head .ll-invoice-logo {
            float: left;
            width: 30%;
            padding: 35px 0px;
        }

        .ll-invoice-head .ll-invoice-title {
            float: left;
            width: 70%;
            font-size: 50px;
            line-height: 1em;
            color: white;
            text-transform: uppercase;
            text-align: right;
            position: relative;
            z-index: 99;
            padding: 30px 0px;
        }

        .ll-invoice-head .ll-invoice-bg-shape {
            position: absolute;
            height: 100%;
            width: 80%;
            -webkit-transform: skewX(35deg);
            transform: skewX(35deg);
            top: 0px;
            right: -95px;
            overflow: hidden;
            background-color: {{ $setting->main_color }};
        }

        .ll-invoice-info {
            position: relative;
            height: 30px;
            margin-bottom: 25px;
            vertical-align: middle;
        }

        .ll-invoice-info .ll-invoice-info_left {
            width: 30%;
            float: left;
            padding: 4px 0px;
            vertical-align: middle;
        }

        .ll-invoice-info_right {
            float: left;
            width: 70%;
            display: table;
            table-layout: fixed;
            color: white;
            position: relative;
            z-index: 999;
            padding: 4px 0px;
            vertical-align: middle;
        }

        .ll-invoice-info_right div {
            display: table-cell;
            text-align: right;
            padding: 0px;
            color: white !important;
            vertical-align: middle;
        }
        .ll-invoice-info_right div span,
        .ll-invoice-info_right div b{
            vertical-align: middle;
        }

        .ll-invoice-info .ll-invoice-info_shape {
            margin-right: 0;
            border-radius: 0;
            -webkit-transform: skewX(35deg);
            transform: skewX(35deg);
            position: absolute;
            height: 30px;
            width: 70%;
            right: -80px;
            overflow: hidden;
            border: none;
            background-color: {{ $setting->main_color }};
        }

        .ll-invoice-pay-to {
            display: table;
            table-layout: fixed;
            width: 100%;
        }

        .ll-invoice-pay-to div {
            display: table-cell;
        }

        .ll-invoice-pay-to .right-side {
            text-align: right;
        }

        .ll-invoice-main-table table {
            width: 100%;
            caption-side: bottom;
            border-collapse: collapse;
            vertical-align: middle;
        }

        .ll-invoice-main-table table th {
            padding: 10px 15px;
            text-align: left;
            color: white !important;
            vertical-align: middle;
        }
        .ll-invoice-main-table table th,
        .ll-invoice-main-table table td,
        .ll-invoice-footer-table .right-side table td{
            padding-bottom: 12px;
        }

        .ll-invoice-main-table table td {
            padding: 10px 15px;
            line-height: 1.55em;
            text-align: left;
            border-bottom: 1px solid #dbdfea;
            vertical-align: middle;
        }
        .ll-invoice-main-table table thead{
            vertical-align: middle;
        }

        .ll-invoice-main-table table thead tr {
            background-color: {{ $setting->main_color }};
            vertical-align: middle;
        }
        .ll-invoice-main-table table thead tr td{
            color: white !important;
        }
        .ll-invoice-main-table table tbody{
            vertical-align: middle;
        }

        .ll-invoice-footer-table {
            display: table;
            table-layout: fixed;
            width: 100%;
            margin-bottom: 30px;
        }

        .ll-invoice-footer-table .left-side {
            width: 58%;
            padding: 10px 15px;
            display: table-cell;
        }

        .ll-invoice-footer-table .right-side {
            display: table-cell;
            width: 40%;
        }

        .ll-invoice-footer-table .right-side table {
            width: 100%;
            caption-side: bottom;
            border-collapse: collapse;
        }

        .ll-invoice-footer-table .right-side table tr {
            vertical-align: middle;
        }

        .ll-invoice-footer-table .right-side table td {
            padding: 10px 15px;
            line-height: 1.55em;
            vertical-align: middle;
        }

        .w-15 {
            width: 25%;
        }

        .w-33 {
            width: 33.33%;
        }

        .w-16 {
            width: 16.66%;
        }

        .w-8 {
            width: 8.33%;
        }

        .text-right {
            text-align: right !important;
        }
    </style>
</head>

<body>
    <div class="ll-invoice-wrapper" id="download-section">
        <div class="ll-invoice-in">
            <div class="ll-invoice-head">
                <div class="ll-invoice-logo">
                    <img src="{{asset($setting->logo_image)}}" alt="">
                </div>
                <div class="ll-invoice-title">
                    Invoice
                </div>
                <div class="ll-invoice-bg-shape"></div>
            </div>
            <div class="ll-invoice-info">
                <div class="ll-invoice-info_left"></div>
                <div class="ll-invoice-info_right">
                    <div><span>Invoice No:</span> <b>#{{ $transaction->order_id }}</b></div>
                    <div style="width: 40%;"><span>Date:</span> <b>{{ formatTime($transaction->created_at, 'M d, Y') }}</b></div>
                </div>
                <div class="ll-invoice-info_shape"></div>
            </div>
            <div class="ll-invoice-pay-to">
                <div class="left-side">
                    <p style="margin-bottom: 2px; color: #111;">
                        <b>Invoice From:</b>
                    </p>
                    <p style="margin-bottom: 15px;">
                        {{ config('app.name') }} <br>
                        {{ $setting->email }} <br>
                        <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
                    </p>
                </div>
                <div class="right-side">
                    <p style="margin-bottom: 2px; color: #111;">
                        <b>Invoice To:</b>
                    </p>
                    <p style="margin-bottom: 15px;">
                        @if ($transaction->customer->name)
                            {{$transaction->customer->name }} <br>
                        @endif

                        @if ($transaction->customer->phone)
                            {{ $transaction->customer->phone }} <br>
                        @endif
                        @if ($transaction->customer->email)
                            {{ $transaction->customer->email }} <br>
                        @endif
                        @if ($transaction->customer->website)
                            <a href="{{ $transaction->customer->website }}">{{ $transaction->customer->website }}</a>
                        @endif
                    </p>
                </div>
            </div>
            <div class="ll-invoice-table-wrap">
                <div class="ll-invoice-main-table">
                    <table>
                        <thead>
                            <tr>
                                <td class="item-col">Plan </td>
                                <td>Description</td>
                                <td>Benefits</td>
                                <td>Price</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="item-col">
                                    {{ $transaction->plan->label }}
                                </td>
                                <td class="description-col">
                                    {{ $transaction->plan->description }}
                                </td>
                                <td>
                                    <span>Ads Limit : {{ $transaction->plan->ad_limit }}</span> <br>
                                    <span>Featured Ads Limit : {{ $transaction->plan->featured_limit }}</span> <br>
                                    <span>Premium Badge :
                                        @if ($transaction->plan->badge)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </span> <br>
                                    <br>
                                </td>
                                <td>
                                    {{ $transaction->currency_symbol }}{{ $transaction->amount }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="ll-invoice-footer-table">
                    <div class="left-side">
                        <p style="margin-bottom: 2px;"><b>Payment info:</b></p>
                        <p>Payment Method - {{ ucfirst($transaction->payment_provider) }}
                        {{-- <p>Payment Type - {{ str_replace('_', ' ', ucfirst($transaction->payment_type)) }} --}}
                        <br>Payment Status: {{ ucfirst($transaction->payment_status) }}
                        <br>Amount:  {{ $transaction->amount }}
                        </p>
                    </div>
                    <div class="right-side">
                        <table>
                            <tbody>
                                <tr style="background: #f5f6fa;">
                                    <td style="color: #111; font-weight: 700;border-top: 1px solid #dbdfea;">Subtoal</td>
                                    <td class="text-right" style="color: #111; font-weight: 700;border-top: 1px solid #dbdfea;">{{ $transaction->amount }}</td>
                                </tr>
                                <tr style="background-color: {{ $setting->main_color }}; color: white;">
                                    <td style="font-size: 16px; font-weight: 700;">Grand Total </td>
                                    <td style="font-size: 16px; font-weight: 700;" class="text-right">
                                        {{ $transaction->currency_symbol }}{{ $transaction->amount }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="position: absolute; bottom: 30px; left:50px; right: 50px; text-align: center;">
                <hr style="background: #dbdfea; margin-bottom: 15px;">
                <p style="margin-bottom: 2px"><b style="color:#111">Thank You!</b></p>
                {{-- <a href="" target="_blank" rel="noopener noreferrer">View Terms & Condition</a> --}}
            </div>
        </div>
    </div>
</body>

</html>
