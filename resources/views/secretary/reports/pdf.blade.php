<h2>Finance Report ({{ $from->toDateString() }} - {{ $to->toDateString() }})</h2>
<h3>Tithes</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Date</th>
            <th>Member</th>
            <th>Amount</th>
            <th>Remarks</th>
            <th>Encoder</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tithes as $tithe)
            <tr>
                <td>{{ $tithe->date }}</td>
                <td>{{ $tithe->member->first_name ?? 'N/A' }} {{ $tithe->member->last_name ?? '' }}</td>
                <td>{{ $tithe->amount }}</td>
                <td>{{ $tithe->remarks }}</td>
                <td>{{ $tithe->encoder->name ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<h3>Offerings</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Date</th>
            <th>Mass</th>
            <th>Amount</th>
            <th>Remarks</th>
            <th>Encoder</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($offerings as $offering)
            <tr>
                <td>{{ $offering->created_at->toDateString() }}</td>
                <td>{{ $offering->mass->title ?? 'N/A' }}</td>
                <td>{{ $offering->amount }}</td>
                <td>{{ $offering->remarks }}</td>
                <td>{{ $offering->encoder->name ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
