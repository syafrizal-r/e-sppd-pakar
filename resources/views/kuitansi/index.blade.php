@extends('layouts.app')

@section('title', 'Data Kuitansi')

@section('content')
<div class="container-fluid py-2">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h6 class="mb-0 fw-bold">Daftar Kuitansi Perjalanan Dinas</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nomor Kuitansi</th>
                            <th>SPD Terkait</th>
                            <th>Jumlah</th>
                            <th>Pejabat TTD</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kuitansis as $k)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $k->nomor_kuitansi }}</td>
                            <td>{!! $k->spd->nomor_surat ?? '<span class="text-danger">Belum Dihubungkan</span>' !!}</td>
                            <td>Rp {{ number_format($k->jumlah_uang, 0, ',', '.') }}</td>
                            <td>{{ $k->pejabatTtd->nama ?? '-' }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data kuitansi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection