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
        $produk = Produk::with(['kategori', 'status'])->get();
        return view('produk', compact('produk'));
    }
}
