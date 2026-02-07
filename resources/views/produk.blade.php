<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fastprint Test</title>
    <link rel="stylesheet" href="">
</head>

<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="m-3">

        <a href="{{ route('api.fetch') }}" class="btn btn-primary">Singkronkan Data API</a>
        <a href="{{ route('produk.view') }}" class="btn btn-primary">Tambah Produk</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Action</th>
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
                    <td>
                        <a href="{{ route('produk.edit', $item->id_produk) }}">Edit</a>
                        <form action="{{ route('produk.delete', $item->id_produk) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" onclick="alert('Apakah yakin ingin menghapus {{ $item->nama_produk }} ?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
