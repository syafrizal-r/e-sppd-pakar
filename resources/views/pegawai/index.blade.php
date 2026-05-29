@extends('layouts.app')

@section('title', 'Master Data Pegawai')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('sukses'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal menyimpan data! Pastikan NIP belum terdaftar.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Pegawai Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('pegawai.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap (beserta Gelar)</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Ir. Fulan, M.Si"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">NIP</label>
                            <input type="number" name="nip" class="form-control" placeholder="18 digit NIP" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pangkat</label>
                            <input type="text" name="pangkat" class="form-control" placeholder="Contoh: Penata Tingkat I"
                                required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Golongan</label>
                                <input type="text" name="golongan" class="form-control" placeholder="Contoh: III/d"
                                    required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control"
                                    placeholder="Contoh: Kepala Seksi..." required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold"><i class="bi bi-save"></i> Simpan
                            Data</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-success text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama & NIP</th>
                                    <th>Pangkat / Gol.</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_pegawai as $index => $row)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $row->nama }}</strong><br>
                                            <span class="text-muted">NIP. {{ $row->nip }}</span>
                                        </td>
                                        <td>
                                            {{ $row->pangkat }}<br>
                                            <span class="badge bg-secondary">{{ $row->golongan }}</span>
                                        </td>
                                        <td>{{ $row->jabatan }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('pegawai.edit', $row->id) }}"
                                                    class="btn btn-warning btn-sm text-white" title="Edit Data">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="{{ route('pegawai.destroy', $row->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Hapus Data"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data pegawai.</td>
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