<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\PengajuanSpj;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung Ringkasan Data
        $total_pegawai = Pegawai::count();
        $total_spj_valid = PengajuanSpj::where('status_verifikasi', 'Valid')->count();
        
        // Menjumlahkan total uang yang sudah cair dari SPJ yang Valid
        $total_anggaran = PengajuanSpj::where('status_verifikasi', 'Valid')->sum('nominal_diajukan');

        // 2. Mengambil 5 riwayat SPJ terbaru untuk ditampilkan di tabel aktivitas
        $spj_terbaru = PengajuanSpj::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact('total_pegawai', 'total_spj_valid', 'total_anggaran', 'spj_terbaru'));
    }
}