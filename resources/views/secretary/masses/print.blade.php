<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Mass Attendance Report</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <style>
        /* Minimal styling for print page (no @media print rules) */
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 20mm;
        }

        h1,
        h2,
        h3 {
            margin: 0 0 8px 0;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .meta {
            font-size: 12px;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .center {
            text-align: center;
        }

        .summary {
            margin-top: 12px;
            font-size: 12px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
            <div><strong>{{ Auth::user()->secretary->church->name }}</strong></div>
        @endif
        <h2>Mass Attendance Report</h2>
        <div class="meta">
            <strong>Mass:</strong> {{ $mass->mass_title ?? ucfirst($mass->mass_type) . ' Mass' }}
            &nbsp; | &nbsp;
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($mass->mass_date)->format('F d, Y') }}
        </div>
    </div>

    <h3>Mass Details</h3>
    <table>
        <tr>
            <th style="width:160px">Title</th>
            <td>{{ $mass->mass_title ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ ucfirst($mass->mass_type) }}</td>
        </tr>
        <tr>
            <th>Date / Time</th>
            <td>{{ \Carbon\Carbon::parse($mass->mass_date)->format('F d, Y') }} — {{ $mass->start_time }} to
                {{ $mass->end_time }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $mass->description ?? 'N/A' }}</td>
        </tr>
    </table>

    <h3>Attendance</h3>
    <table>
        <thead>
            <tr>
                <th style="width:50px">#</th>
                <th>Member Name</th>
                <th style="width:100px" class="center">Attended</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $i => $member)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                    <td class="center">
                        {{ isset($attendances[$member->member_id]) && $attendances[$member->member_id] ? '✓' : '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Members:</strong> {{ $totalMembers }} &nbsp; | &nbsp;
        <strong>Attended:</strong> {{ $attendedCount }} &nbsp; | &nbsp;
        <strong>Absent:</strong> {{ $absentCount }}
    </div>

    <h3 style="margin-top:18px">Offerings</h3>
    @if ($mass->offerings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Encoded By</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mass->offerings as $offering)
                    <tr>
                        <td>₱{{ number_format($offering->amount, 2) }}</td>
                        <td>{{ $offering->remarks }}</td>
                        <td>{{ $offering->encoder->name ?? 'N/A' }}</td>
                        <td>{{ $offering->created_at->format('F j, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="summary"><strong>Total Offering:</strong> ₱{{ number_format($totalOffering, 2) }}</div>
    @else
        <p>No offerings recorded for this mass.</p>
    @endif

</body>

</html>
