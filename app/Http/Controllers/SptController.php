<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spt;
use App\Models\Pegawai;

class SptController extends Controller
{
    // Tampilan daftar SPT dan Form Input
    public function index()
    {
        $data_spt = Spt::with('pegawai')->orderBy('created_at', 'desc')->get();
        $data_pegawai = Pegawai::orderBy('nama', 'asc')->get();
        
        return view('spt.index', compact('data_spt', 'data_pegawai'));
    }

    // Menyimpan SPT Baru beserta beberapa pegawai terpilih
    public function store(Request $request)
    {
        $request->validate([
            'dalam_rangka' => 'required',
            'pegawai_ids' => 'required|array' // Memastikan input berbentuk pilihan banyak (array)
        ]);

        // 1. Simpan data utama SPT
        $spt = Spt::create([
            'nomor_spt' => $request->nomor_spt,
            'dasar_rekening' => $request->dasar_rekening,
            'dasar_tanggal' => $request->dasar_tanggal,
            'dalam_rangka' => $request->dalam_rangka,
            'yang_dikunjungi' => $request->yang_dikunjungi,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'tgl_spt' => $request->tgl_spt,
        ]);

        // 2. Hubungkan dengan ID pegawai-pegawai yang dicentang di form
        $spt->pegawai()->attach($request->pegawai_ids);

        return back()->with('sukses', 'Dokumen SPT Multi-Pegawai berhasil diterbitkan!');
    }

    // Fungsi Cetak Format A4 Resmi
    public function cetak($id)
    {
        $spt = Spt::with('pegawai')->findOrFail($id);
        return view('spt.cetak', compact('spt'));
    }
}