<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fastprint Test</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="m-3">

        <a href="{{ route('api.fetch') }}" class="btn btn-primary">Singkronkan Data API</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $index => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->kategori->nama_kategori }}</td>
                    <td>{{ $item->status->nama_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
