<?php

namespace App\Http\Controllers;

use App\Models\Spd;
use Illuminate\Http\Request;
use App\Models\Spt; // Pastikan model SPT di-import
use App\Models\Pegawai; // Pastikan model Pegawai di-import
use App\Models\SpdPengikut;
use Illuminate\Support\Facades\DB;

class SpdController extends Controller
{

    public function index()
    {
        // Mengambil semua data SPD beserta relasi pegawai dan SPT-nya
        $spds = Spd::with(['pegawai', 'SampleSpt'])->orderBy('created_at', 'desc')->get();

        return view('spd.index', compact('spds'));
    }

    public function cetak($id)
    {
        // Mengambil data SPD beserta seluruh relasinya sekaligus (Eager Loading) agar loading cepat
        $spd = Spd::with(['pegawai', 'kuasaAnggaran', 'SampleSpt', 'pengikut.pegawai'])
            ->findOrFail($id);

        // Mengirimkan satu variabel tunggal $spd yang sudah mengikat semua data terkait ke view
        return view('spd.cetak', compact('spd'));
    }

    // ... (fungsi cetak yang sebelumnya sudah ada) ...

    public function create()
    {
        // Mengambil data untuk pilihan di form
        $spt = Spt::all();
        $pegawai = Pegawai::orderBy('golongan', 'desc')->get(); // Diurutkan dari golongan tertinggi

        return view('spd.create', compact('spt', 'pegawai'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nomor_surat' => 'required|unique:spds,nomor_surat',
            'spt_id' => 'required',
            'pegawai_id' => 'required',
            'kuasa_anggaran_id' => 'required',
            'tingkat_biaya' => 'required',
            'alat_angkut' => 'required',
            'tempat_tujuan' => 'required',
            'kode_rekening' => 'required',
            'tgl_dikeluarkan' => 'required|date',
        ]);

        // Gunakan DB Transaction agar jika gagal simpan pengikut, data utama juga dibatalkan
        DB::beginTransaction();
        try {
            // 1. Simpan data utama ke tabel spds
            $spd = Spd::create([
                'nomor_surat' => $request->nomor_surat,
                'spt_id' => $request->spt_id,
                'pegawai_id' => $request->pegawai_id,
                'kuasa_anggaran_id' => $request->kuasa_anggaran_id,
                'tingkat_biaya' => $request->tingkat_biaya,
                'alat_angkut' => $request->alat_angkut,
                'tempat_berangkat' => 'Medan', // Default dari birokrasi Provsu
                'tempat_tujuan' => $request->tempat_tujuan,
                'skpd' => 'Dinas Pertanian dan Ketahanan Pangan Provsu',
                'kode_rekening' => $request->kode_rekening,
                'keterangan_lain' => $request->keterangan_lain,
                'tgl_dikeluarkan' => $request->tgl_dikeluarkan,
            ]);

            // 2. Simpan data pengikut (jika ada yang dipilih)
            if ($request->has('pengikut_ids')) {
                foreach ($request->pengikut_ids as $p_id) {
                    SpdPengikut::create([
                        'spd_id' => $spd->id,
                        'pegawai_id' => $p_id,
                        'keterangan' => 'Pengikut' // Bisa dikembangkan jadi input dinamis nanti
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('spd.index')->with('success', 'Data SPD berhasil diterbitkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
