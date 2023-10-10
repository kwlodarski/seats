<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Karta urlopowa - {{ $user->name }} - {{ $startDate->format('d.m.Y') }} - {{ $endDate->format('d.m.Y') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <table>
        <tr>
            <td class="text-xl">{{ $vacation->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $workingDays }}</td>
            <td>{{ $vacationDays }}</td>
            <td>{{ $vacationHours }}</td>
        </tr>
    </table>
</body>
</html>