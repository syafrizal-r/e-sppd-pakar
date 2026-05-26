<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SbmSumut;

class SbmController extends Controller
{
    // 1. Menampilkan daftar seluruh data SBM (Read)
    public function index()
    {
        $data_sbm = SbmSumut::orderBy('jenis_biaya', 'asc')->get();
        return view('sbm.index', compact('data_sbm'));
    }

    // 2. Menyimpan data SBM baru (Create)
    public function store(Request $request)
    {
        $request->validate([
            'jenis_biaya' => 'required',
            'golongan_atau_eselon' => 'required',
            'lokasi_tujuan' => 'required',
            'batas_maksimal' => 'required|numeric'
        ]);

        SbmSumut::create($request->all());
        return back()->with('sukses', 'Data SBM baru berhasil ditambahkan!');
    }

    // 3. Menghapus data SBM (Delete)
    public function destroy($id)
    {
        $sbm = SbmSumut::findOrFail($id);
        $sbm->delete();
        
        return back()->with('sukses', 'Data SBM berhasil dihapus!');
    }
    
    // (Catatan: Untuk fungsi edit/update bisa dikembangkan lebih lanjut nanti, 
    // saat ini kita fokus ke Tambah, Lihat, dan Hapus agar cepat diuji).
}