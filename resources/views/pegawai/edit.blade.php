@extends('layouts.app')

@section('title', 'Edit Data Pegawai')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-pencil-square me-2"></i> Form Perubahan Data Pegawai
            </div>
            <div class="card-body">
                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap (beserta Gelar)</label>
                        <input type="text" name="nama" class="form-control" value="{{ $pegawai->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIP</label>
                        <input type="number" name="nip" class="form-control" value="{{ $pegawai->nip }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pangkat</label>
                        <input type="text" name="pangkat" class="form-control" value="{{ $pegawai->pangkat }}" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Golongan</label>
                            <input type="text" name="golongan" class="form-control" value="{{ $pegawai->golongan }}" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ $pegawai->jabatan }}" required>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary fw-bold">Batal</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="bi bi-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection