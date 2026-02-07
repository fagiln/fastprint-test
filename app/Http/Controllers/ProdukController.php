<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProdukController extends Controller
{

    public function fetchAndSaveData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date('d');
        $bln = date('m');
        $thn = date('y');
        $jam = date('H');

        $username = "tesprogrammer{$tgl}{$bln}{$thn}C{$jam}";
        $password = md5("bisacoding-{$tgl}-{$bln}-{$thn}");

        $response = Http::asForm()->post('https://recruitment.fastprint.co.id/tes/api_tes_programmer', [
            'username' => $username,
            'password' => $password
        ]);

        if ($response->successful()) {
            $result = $response->json();
            if (isset($result['error']) && $result['error'] != 0) {
                return "Gagal mengambil data: " . ($result['ket'] ?? 'Error tidak diketahui');
            }


            $produk = $result['data'];

            DB::transaction(function () use ($produk) {
                foreach ($produk as $item) {
                    $kategori = Kategori::firstOrCreate(
                        ['nama_kategori' => $item['kategori']]
                    );
                    $status = Status::firstOrCreate(
                        [
                            'nama_status' => $item['status']
                        ]
                    );
                    Produk::updateOrCreate([
                        'id_produk' => $item['id_produk']
                    ], [
                        'nama_produk' => $item['nama_produk'],
                        'harga'       => $item['harga'],
                        'id_kategori' => $kategori->id_kategori,
                        'id_status'   => $status->id_status,
                    ]);
                }
            });
            return redirect()->back()->with('success', 'Data berhasil di simpan');
        }
        return "Request API gagal " . $response->status() . " " . $response->reason() . " " . $username . " " . $password;
    }
    public function index()
    {
        $produk = Produk::with(['kategori', 'status'])->whereHas('status', function ($query) {
            $query->where('nama_status', 'bisa dijual');
        })->get();
        return view('produk', compact('produk'));
    }

    public function view()
    {
        $kategori =    Kategori::all();
        $status =    Status::all();
        return view('store', compact('kategori', 'status'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required|exists:kategori,id_kategori',
            'status' => 'required|exists:status,id_status',
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'id_kategori' => $request->kategori,
            'id_status' => $request->status,
        ];

        Produk::create($data);
        return redirect()->route('produk.index')->with('success', 'Berhasil menambah barang');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        $status = Status::all();
        return view('edit', compact('produk', 'kategori', 'status'));
    }

    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|number',
            'kategori' => 'required|exists:kategori,id_kategori',
            'status' => 'required|exists:status,id_status',

        ]);

        $data  = [
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'id_kategori' => $request->kategori,
            'id_status' => $request->status,
        ];

        $produk->update($data);
        return redirect()->route('produk.index')->with('success', 'Berhasil Update Produk');
    }
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Berhasil Update Produk');
    }
}
