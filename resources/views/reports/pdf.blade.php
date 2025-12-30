<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $record->title }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
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
            text-transform: uppercase;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            padding: 2px 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 16px;
            margin: 0;
            padding: 2px 0;
            text-transform: uppercase;
        }
        .header h3 {
            font-size: 14px;
            margin: 0;
            padding: 2px 0;
        }
        .logo {
            margin: 15px auto;
            width: 100px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            display: inline-block;
        }
        .badge-success {
            background-color: #10b981;
        }
        .badge-danger {
            background-color: #ef4444;
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
        }
        .report-info {
            text-align: right;
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="watermark">MoCLA</div>
    
    <div class="header">
        <h1>THE UNITED REPUBLIC OF TANZANIA</h1>
        <h2>MINISTRY OF CONSTITUTIONAL AND LEGAL AFFAIRS</h2>
        <h3>(MoCLA)</h3>
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        <br>
         <h2><strong>Title:</strong> {{ $record->title }}<br></h2>
    </div>

    <div class="report-info">
       
        <strong>Generated on:</strong> {{ now()->format('Y-m-d H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">#</th>
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
                        <td>
                            @if($column === 'paid')
                                @if($provider->paid)
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Not Paid</span>
                                @endif
                            @else
                                {{ $provider->$column }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
