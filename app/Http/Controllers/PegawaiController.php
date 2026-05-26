<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    // Menampilkan halaman data pegawai
    public function index()
    {
        // Mengambil data pegawai diurutkan berdasarkan nama (abjad)
        $data_pegawai = Pegawai::orderBy('nama', 'asc')->get();
        return view('pegawai.index', compact('data_pegawai'));
    }

    // Menyimpan data pegawai baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:pegawai,nip', // NIP tidak boleh sama
            'pangkat' => 'required',
            'golongan' => 'required',
            'jabatan' => 'required'
        ], [
            'nip.unique' => 'NIP tersebut sudah terdaftar di sistem!'
        ]);

        Pegawai::create($request->all());

        return back()->with('sukses', 'Data Pegawai berhasil ditambahkan!');
    }

    // Menghapus data pegawai
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return back()->with('sukses', 'Data Pegawai berhasil dihapus!');
    }
}
