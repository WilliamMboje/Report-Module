<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $record->title }}</title>
    <style> body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            display: inline-block;
        }

        .badge-success {
            background-color: #10b981; /* Green */
        }

        .badge-danger {
            background-color: #ef4444; /* Red */
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.05);
            z-index: -1;
            white-space: nowrap;
        } </style>
</head>
<body>
<div class="watermark">MoCLA</div>
<div class="header"><h1>{{ $record->title }}</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p></div>
<table>
    <thead>
    <tr>
        <th style="width: 40px;">#</th> @foreach($columns as $column)
            <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
        @endforeach </tr>
    </thead>
    <tbody> @foreach($providers as $index => $provider)
        <tr>
            <td>{{ $index + 1 }}</td> @foreach($columns as $column)
                <td> {{ $provider->$column }} </td>
            @endforeach </tr>
    @endforeach </tbody>
</table>
</body>
</html>
