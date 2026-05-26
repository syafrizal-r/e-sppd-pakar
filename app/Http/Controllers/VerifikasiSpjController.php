<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSpj;
use App\Models\SbmSumut;
use App\Models\Pegawai;

class VerifikasiSpjController extends Controller
{
    // Fungsi ini adalah Mesin Inferensi (Inference Engine) dari Sistem Pakar Anda
    public function evaluasi(Request $request)
    {
        // 1. PENGUMPULAN FAKTA
        // Tarik profil lengkap pegawai dari database berdasarkan pilihan di form
        $pegawai = Pegawai::findOrFail($request->pegawai_id);

        $input = new PengajuanSpj();
        $input->nama_pegawai = $pegawai->nama;          // Otomatis terisi dari database!
        $input->golongan = $pegawai->golongan;          // Otomatis terisi dari database!
        $input->tujuan_dinas = $request->tujuan_dinas;
        $input->jenis_biaya_diajukan = $request->jenis_biaya;
        $input->nominal_diajukan = $request->nominal;

        // 2. PENCARIAN ATURAN (Menarik data dari Knowledge Base SBM)
        $rule_sbm = SbmSumut::where('jenis_biaya', $input->jenis_biaya_diajukan)
            ->where('lokasi_tujuan', $input->tujuan_dinas)
            // Jika aturan SBM sangat spesifik berdasarkan golongan, 
            // baris ini bisa diaktifkan kembali:
            // ->where('golongan_atau_eselon', $input->golongan)
            ->first();

        // 3. PROSES INFERENSI (Rule-Based dengan Logika IF-THEN)
        if (!$rule_sbm) {
            // Jika aturan untuk daerah/kriteria tersebut belum ada di database
            $input->status_verifikasi = 'Sistem Error';
            $input->pesan_sistem = 'Aturan SBM untuk parameter tersebut tidak ditemukan di basis pengetahuan.';
        } else {
            // EVALUASI KESESUAIAN (Mencocokkan Kuitansi dengan SBM)
            if ($input->nominal_diajukan <= $rule_sbm->batas_maksimal) {
                // RULE 1: Lolos Verifikasi
                $input->status_verifikasi = 'Valid';
                $input->pesan_sistem = 'Rincian biaya disetujui. Sesuai dengan pagu maksimal APBD.';
            } else {
                // RULE 2: Ditolak / Melebihi Batas
                $selisih = $input->nominal_diajukan - $rule_sbm->batas_maksimal;
                $input->status_verifikasi = 'Ditolak / Melebihi Pagu';

                // Format angka ke format Rupiah agar rapi
                $rupiah_selisih = 'Rp ' . number_format($selisih, 0, ',', '.');
                $rupiah_sbm = 'Rp ' . number_format($rule_sbm->batas_maksimal, 0, ',', '.');

                $input->pesan_sistem = "Peringatan: Nominal pengajuan melebihi aturan SBM sebesar $rupiah_selisih. Batas maksimal yang diizinkan untuk daerah tersebut adalah $rupiah_sbm.";
            }
        }

        // 4. SIMPAN HASIL KEPUTUSAN KE DATABASE
        $input->save();

        // Kembalikan pengguna ke halaman form sambil membawa hasil evaluasi
        return redirect()->back()->with('hasil_evaluasi', $input);
    }
    public function riwayat()
    {
        // Mengambil semua data pengajuan dari database, diurutkan dari yang terbaru
        $data_spj = PengajuanSpj::orderBy('created_at', 'desc')->get();

        // Melempar data tersebut ke file view bernama 'riwayat_spj'
        return view('riwayat_spj', compact('data_spj'));
    }
    // Fungsi untuk mencetak Kuitansi SPJ
    public function cetakKwitansi($id)
    {
        // Cari data SPJ berdasarkan ID, jika tidak ada akan muncul error 404
        $spj = PengajuanSpj::findOrFail($id);

        // Lempar data ke halaman cetak
        return view('cetak_kwitansi', compact('spj'));
    }
}
