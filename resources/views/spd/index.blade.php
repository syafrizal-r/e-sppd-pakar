@extends('layouts.app')

@section('title', 'Daftar Surat Perjalanan Dinas')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">Riwayat & Daftar Dokumen SPD</h6>
            <a href="{{ route('spd.create') }}" class="btn btn-light btn-sm fw-bold">
                <i class="bi bi-plus-circle-fill me-1"></i> Buat SPD Baru
            </a>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nomor SPD</th>
                            <th>Nama Pegawai / NIP</th>
                            <th>Maksud Perjalanan Dinas</th>
                            <th>Tempat Tujuan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($spds as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $item->nomor_surat }}</td>
                            <td>
                                {{ $item->pegawai->nama }}<br>
                                <small class="text-muted">NIP. {{ $item->pegawai->nip }}</small>
                            </td>
                            <td>{{ $item->SampleSpt->maksud_tujuan ?? '-' }}</td>
                            <td>{{ $item->tempat_tujuan }}</td>
                            <td class="text-center">
                                <a href="{{ route('spd.cetak', $item->id) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="bi bi-printer-fill me-1"></i> Cetak SPD
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada dokumen SPD yang diterbitkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection