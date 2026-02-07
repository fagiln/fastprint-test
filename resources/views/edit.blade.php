<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
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
    <form action="{{ route('produk.update', $produk->id_produk) }}" method="post">

        @csrf
        @method('PUT')
        <div>
            <label for="">Nama Barang</label>
            <input type="text" required name="nama_produk" value="{{ $produk->nama_produk }}">
        </div>
        <div>
            <label for="">Harga</label>
            <input type="number" required name="harga" value="{{ $produk->harga }}">
        </div>
        <div>
            <label for="">Kategori</label>
            <select name="kategori" id="">
                @foreach ($kategori as $item)
                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="">Status</label>
            <select name="status" id="">
                @foreach ($status as $item)
                    <option value="{{ $item->id_status }}">{{ $item->nama_status }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Edit</button>
    </form>
</body>

</html>
