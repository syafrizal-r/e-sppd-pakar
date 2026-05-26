@extends('layouts.app')

@section('title', 'Riwayat & Kuitansi SPJ')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark"><i class="bi bi-clock-history"></i> Data Riwayat Verifikasi SPJ</h4>
            <a href="{{ url('/') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-circle"></i> Buat Pengajuan Baru</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-success text-center">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Input</th>
                                <th>Nama Pegawai</th>
                                <th>Tujuan & Jenis Biaya</th>
                                <th>Nominal Riil (Rp)</th>
                                <th>Status Sistem Pakar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_spj as $index => $row)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $row->nama_pegawai }}</strong><br>
                                        <small class="text-muted">{{ $row->golongan }}</small>
                                    </td>
                                    <td>
                                        {{ $row->tujuan_dinas }}<br>
                                        <span class="badge bg-secondary">{{ $row->jenis_biaya_diajukan }}</span>
                                    </td>
                                    <td class="text-end">{{ number_format($row->nominal_diajukan, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if ($row->status_verifikasi == 'Valid')
                                            <span class="badge bg-success mb-1"><i class="bi bi-check-circle"></i> Valid / Sesuai SBM</span>
                                            <br>
                                            <a href="{{ route('cetak.kwitansi', $row->id) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                <i class="bi bi-printer"></i> Cetak
                                            </a>
                                        @else
                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak / Melebihi Pagu</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data pengajuan SPJ.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection