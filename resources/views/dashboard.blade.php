@extends('layouts.app')

@section('title', 'Dashboard e-SPPD')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Selamat Datang di e-SPPD</h4>
    <p class="text-muted">Ringkasan aktivitas perjalanan dinas dan serapan anggaran saat ini.</p>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase fw-semibold"><i class="bi bi-people-fill me-2"></i> Total Pegawai</h6>
                <h2 class="mt-3 mb-0">{{ $total_pegawai }} <span class="fs-6 fw-normal">Orang</span></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase fw-semibold"><i class="bi bi-check-circle-fill me-2"></i> SPJ Tervalidasi</h6>
                <h2 class="mt-3 mb-0">{{ $total_spj_valid }} <span class="fs-6 fw-normal">Dokumen</span></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card bg-warning shadow-sm border-0 h-100">
            <div class="card-body text-dark">
                <h6 class="card-title text-uppercase fw-semibold"><i class="bi bi-wallet2 me-2"></i> Serapan Anggaran</h6>
                <h2 class="mt-3 mb-0 text-truncate">Rp {{ number_format($total_anggaran, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold py-3">
        <i class="bi bi-clock-history me-2"></i> 5 Aktivitas Pengajuan SPJ Terakhir
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Nama Pegawai</th>
                        <th>Tujuan</th>
                        <th>Nominal</th>
                        <th>Status Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spj_terbaru as $spj)
                    <tr>
                        <td class="ps-3 fw-medium">{{ $spj->nama_pegawai }}</td>
                        <td>{{ $spj->tujuan_dinas }}</td>
                        <td>Rp {{ number_format($spj->nominal_diajukan, 0, ',', '.') }}</td>
                        <td>
                            @if($spj->status_verifikasi == 'Valid')
                                <span class="badge bg-success rounded-pill px-3">Valid</span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat pengajuan SPJ.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection