<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karta urlopowa - {{ $user->name }} - {{ $startDate->format('d.m.Y') }} - {{ $endDate->format('d.m.Y') }}</title>
    <style>
        body {
            font-family: DejaVu Sans;
            margin: 30px;
        }

        .header {
            width: 100%;
            display: table;
        }

        .header > div {
            display: table-cell;
            width: 50%;
        }

        .header .left {
            text-align: left;
        }

        .header .right {
            text-align: right;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .employer {
            text-align: right;
            margin-bottom: 50px;
        }

        .request {
            text-align: center;
            margin-bottom: 80px;
        }

        .footer {
            width: 100%;
            display: table;
        }

        .footer > div {
            display: table-cell;
            width: 50%;
            font-size: 14px;
        }

        .footer .right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="left">{{ $user->name }}</div>
        <div class="right">Łódź, dnia {{ $currentDate }}</div>
    </div>
    <h1>WNIOSEK O UDZIELENIE URLOPU WYPOCZYNKOWEGO</h1>

    <div class="employer">
        WEB SYSTEMS<br>
        Janówka, Bursztynowa 4<br>
        95-020 Andrespol
    </div>

    <div class="request">
        Zwracam się z prośbą o udzielenie mi urlopu w @if ($workingDays > 1)dniach {{ $startDate->format("d.m.Y") }} - {{ $endDate->format("d.m.Y") }}@else w dniu {{ $startDate->format("d.m.Y") }}@endif w ilości {{ $vacationHours }} godzin ({{ $vacationDays }} dni).
    </div>

    <div class="footer">
        <div class="left">{{ $currentDate }} ....................................<br><small>(data i podpis bezpośredniego przełożonego)</small></div>
        <div class="right">{{ $currentDate }} ....................................<br><small>(data i podpis pracownika)</small></div>
    </div>
</body>
</html>