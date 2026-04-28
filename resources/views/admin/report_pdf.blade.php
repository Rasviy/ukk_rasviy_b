<h2>Report Penjualan POS</h2>

<table width="100%" border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Total</th>
    </tr>

    @foreach($transactions as $t)
    <tr>
        <td>{{ $t->id }}</td>
        <td>{{ $t->created_at }}</td>
        <td>{{ $t->total }}</td>
    </tr>
    @endforeach
</table>