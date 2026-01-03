<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $report->title }}</title>

    <style>
        /*body {*/
        /*    font-family: sans-serif;*/
        /*    font-size: 12px;*/
        /*}*/
        /*table {*/
        /*    width: 100%;*/
        /*    border-collapse: collapse;*/
        /*    margin-top: 20px;*/
        /*}*/


        body {
            position: relative;
        }

/* .watermark {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 100px;
            font-weight: bold;
            color: #e5e7eb;
            z-index: 0;
        } */

        table {
            position: relative;
            z-index: 1;
        }

        th, td {
            border: 1px solid #ddd;
            /*padding: 6px;*/
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        /*.watermark {*/
        /*    position: fixed;*/
        /*    top: 50%;*/
        /*    left: 50%;*/
        /*    transform: translate(-50%, -50%) rotate(-45deg);*/
        /*    font-size: 80px;*/
        /*    font-weight: bold;*/
        /*    color: rgba(0, 0, 0, 0.05);*/
        /*    z-index: -1;*/
        /*    white-space: nowrap;*/
        /*}*/
    </style>
</head>

<body>
{{-- <div class="watermark">MoCLA</div> --}}

<div class="header">
    <h2>{{ $report->title }}</h2>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>#</th>
        @foreach($columns as $column)
            <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($providers as $index => $provider)
        <tr>
            <td>{{ $index + 1 }}</td>
            @foreach($columns as $column)
                <td>{{ data_get($provider, $column, '') }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
