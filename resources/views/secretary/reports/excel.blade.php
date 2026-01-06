<table>
    <thead>
        <tr>
            <th colspan="5">Tithes ({{ $from->toDateString() }} - {{ $to->toDateString() }})</th>
        </tr>
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
    <thead>
        <tr>
            <th colspan="5">Offerings ({{ $from->toDateString() }} - {{ $to->toDateString() }})</th>
        </tr>
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
