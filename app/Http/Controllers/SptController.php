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
    // Menyimpan SPT Baru beserta validasi bentrok jadwal
    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'dalam_rangka' => 'required',
            'pegawai_ids' => 'required|array',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $tglMulaiBaru = $request->tgl_mulai;
        $tglSelesaiBaru = $request->tgl_selesai;

        // 2. ALGORITMA CEK BENTURAN JADWAL
        // Kita periksa satu per satu pegawai yang dicentang
        foreach ($request->pegawai_ids as $pegawai_id) {

            // Cari apakah pegawai ini punya riwayat SPT yang tanggalnya tumpang tindih
            $bentrok = Spt::whereHas('pegawai', function ($query) use ($pegawai_id) {
                $query->where('pegawai.id', $pegawai_id);
            })->where(function ($query) use ($tglMulaiBaru, $tglSelesaiBaru) {
                // Logika Tumpang Tindih Tanggal
                $query->where('tgl_mulai', '<=', $tglSelesaiBaru)
                    ->where('tgl_selesai', '>=', $tglMulaiBaru);
            })->first();

            // Jika ditemukan data yang bentrok, hentikan proses dan kembalikan error
            if ($bentrok) {
                $pegawai = Pegawai::find($pegawai_id);
                $nomor = $bentrok->nomor_spt ?? $bentrok->dalam_rangka;

                return back()->with('error', "GAGAL! Pegawai a.n. {$pegawai->nama} tidak bisa dipilih karena sudah memiliki jadwal dinas pada tanggal tersebut (SPT: {$nomor}).")->withInput();
            }
        }

        // 3. Jika aman (lolos validasi), simpan data utama SPT
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

        // 4. Hubungkan dengan ID pegawai
        $spt->pegawai()->attach($request->pegawai_ids);

        return back()->with('sukses', 'Dokumen SPT Multi-Pegawai berhasil diterbitkan tanpa ada jadwal yang bentrok!');
    }
    // Fungsi Cetak Format A4 Resmi
    public function cetak($id)
    {
        $spt = Spt::with('pegawai')->findOrFail($id);
        return view('spt.cetak', compact('spt'));
    }

    // Menampilkan halaman form edit SPT
    public function edit($id)
    {
        $spt = Spt::with('pegawai')->findOrFail($id);
        $data_pegawai = Pegawai::orderBy('golongan', 'desc')->get();

        // Mengambil ID pegawai yang sudah tercentang di SPT ini
        $pegawai_terpilih = $spt->pegawai->pluck('id')->toArray();

        return view('spt.edit', compact('spt', 'data_pegawai', 'pegawai_terpilih'));
    }

    // Memproses penyimpanan perubahan data SPT
    public function update(Request $request, $id)
    {
        $request->validate([
            'dalam_rangka' => 'required',
            'pegawai_ids' => 'required|array',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $spt = Spt::findOrFail($id);
        $tglMulaiBaru = $request->tgl_mulai;
        $tglSelesaiBaru = $request->tgl_selesai;

        // ALGORITMA CEK BENTURAN JADWAL (Mengecualikan SPT ini sendiri)
        foreach ($request->pegawai_ids as $pegawai_id) {
            $bentrok = Spt::whereHas('pegawai', function ($query) use ($pegawai_id) {
                $query->where('pegawai.id', $pegawai_id);
            })->where('id', '!=', $id) // <-- Penting: Jangan cek dengan diri sendiri
                ->where(function ($query) use ($tglMulaiBaru, $tglSelesaiBaru) {
                    $query->where('tgl_mulai', '<=', $tglSelesaiBaru)
                        ->where('tgl_selesai', '>=', $tglMulaiBaru);
                })->first();

            if ($bentrok) {
                $pegawai = Pegawai::find($pegawai_id);
                $nomor = $bentrok->nomor_spt ?? $bentrok->dalam_rangka;
                return back()->with('error', "GAGAL! Pegawai a.n. {$pegawai->nama} tidak bisa dipilih karena bentrok dengan jadwal SPT lain (SPT: {$nomor}).")->withInput();
            }
        }

        // Update data utama SPT
        $spt->update([
            'nomor_spt' => $request->nomor_spt,
            'dasar_rekening' => $request->dasar_rekening,
            'dasar_tanggal' => $request->dasar_tanggal,
            'dalam_rangka' => $request->dalam_rangka,
            'yang_dikunjungi' => $request->yang_dikunjungi,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'tgl_spt' => $request->tgl_spt,
        ]);

        // Fungsi sync() sangat canggih: otomatis menghapus centang lama dan mengganti dengan centang baru
        $spt->pegawai()->sync($request->pegawai_ids);

        return redirect()->route('spt.index')->with('sukses', 'Dokumen SPT berhasil diperbarui!');
    }

    // Menghapus data SPT
    public function destroy($id)
    {
        $spt = Spt::findOrFail($id);

        // Putuskan dulu relasi pegawai di tabel perantara agar tidak error
        $spt->pegawai()->detach();

        // Baru hapus dokumen SPT-nya
        $spt->delete();

        return back()->with('sukses', 'Dokumen SPT beserta daftar pegawainya berhasil dihapus permanen!');
    }
}
