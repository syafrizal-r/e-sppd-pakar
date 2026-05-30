<?php

namespace App\Http\Controllers;

use App\Models\Kuitansi;
use App\Models\Spd;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class KuitansiController extends Controller
{
    public function create($spd_id)
    {
        $spd = Spd::findOrFail($spd_id);
        $pegawai = Pegawai::all(); // Untuk dropdown Select2
        return view('kuitansi.create', compact('spd', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'spd_id' => 'required',
            'nomor_kuitansi' => 'required|unique:kuitansi',
            'jumlah_uang' => 'required',
            'tanggal_kuitansi' => 'required|date',
            'pejabat_ttd_id' => 'required',
        ]);

        Kuitansi::create($request->all());

        return redirect()->route('spd.index')->with('success', 'Kuitansi berhasil dibuat!');
    }

    public function index()
    {
        // Mengambil data dari kedua sumber jika perlu, 
        // atau jika Anda ingin migrasi total ke tabel 'kuitansi', 
        // cukup panggil model Kuitansi saja.
        $kuitansis = Kuitansi::with(['spd', 'pejabatTtd', 'bendahara'])->orderBy('created_at', 'desc')->get();

        return view('kuitansi.index', compact('kuitansis'));
    }

    public function edit($id)
    {
        $kuitansi = \App\Models\Kuitansi::findOrFail($id);
        $spd_list = \App\Models\Spd::all(); // Untuk memilih SPD yang benar
        $pegawai = \App\Models\Pegawai::all();
        return view('kuitansi.edit', compact('kuitansi', 'spd_list', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $kuitansi = \App\Models\Kuitansi::findOrFail($id);
        $kuitansi->update($request->all());
        return redirect()->route('kuitansi.index')->with('success', 'Kuitansi berhasil diupdate!');
    }
}
