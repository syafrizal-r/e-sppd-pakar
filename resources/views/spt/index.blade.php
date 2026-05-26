@extends('layouts.app')

@section('title', 'Manajemen Surat Perintah Tugas (SPT)')

@section('content')
<div class="row">
    @if(session('sukses'))
        <div class="col-12 alert alert-success shadow-sm">{{ session('sukses') }}</div>
    @endif

    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white fw-bold">
                <i class="bi bi-file-earmark-plus"></i> Input Parameter Dokumen SPT
            </div>
            <div class="card-body">
                <form action="{{ route('spt.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label fw-semibold">1. Nomor SPT</label>
                        <input type="text" name="nomor_spt" class="form-control" placeholder="Contoh: 000/123/SPT/05/2026">
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label fw-semibold">2. Kode Rekening DPA</label>
                            <input type="text" name="dasar_rekening" class="form-control" placeholder="5.1.02.04...">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tanggal DPA</label>
                            <input type="date" name="dasar_tanggal" class="form-control">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">3. Maksud / Dalam Rangka</label>
                        <textarea name="dalam_rangka" class="form-control" rows="2" placeholder="Contoh: Melakukan koordinasi ketahanan pangan..." required></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">4. Tempat / Yang Dikunjungi</label>
                        <input type="text" name="yang_dikunjungi" class="form-control" placeholder="Contoh: Dinas Pertanian Kab. Deli Serdang" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tgl Mulai</label>
                            <input type="date" name="tgl_mulai" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tgl Selesai</label>
                            <input type="date" name="tgl_selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Ditetapkan SPT</label>
                        <input type="date" name="tgl_spt" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-danger"><i class="bi bi-people"></i> 5. Centang Pegawai Tugas (Bisa Banyak):</label>
                        <div class="border rounded p-3 bg-white" style="max-height: 150px; overflow-y: auto;">
                            @foreach($data_pegawai as $p)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="pegawai_ids[]" value="{{ $p->id }}" id="p{{ $p->id }}">
                                    <label class="form-check-label" for="p{{ $p->id }}">
                                        <strong>{{ $p->nama }}</strong> <small class="text-muted">({{ $p->golongan }})</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold"><i class="bi bi-printer-fill"></i> Terbitkan & Simpan SPT</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nomor SPT / Maksud</th>
                            <th>Pegawai Terlibat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_spt as $idx => $s)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td>
                                <strong>{{ $s->nomor_spt ?? 'Belum Diisi' }}</strong><br>
                                <small class="text-muted">{{ Str::limit($s->dalam_rangka, 60) }}</small>
                            </td>
                            <td>
                                <ol class="ps-3 mb-0" style="font-size: 11pt;">
                                    @foreach($s->pegawai as $peg)
                                        <li>{{ $peg->nama }}</li>
                                    @endforeach
                                </ol>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('spt.cetak', $s->id) }}" target="_blank" class="btn btn-sm btn-primary">🖨️ Cetak A4</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada SPT terbit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection