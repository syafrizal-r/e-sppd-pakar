@extends('layouts.app')

@section('title', 'Edit Surat Perintah Tugas (SPT)')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        
        @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0 fw-bold mb-3"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-pencil-square"></i> Form Perubahan Data SPT
            </div>
            <div class="card-body">
                <form action="{{ route('spt.update', $spt->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">1. Nomor SPT</label>
                        <input type="text" name="nomor_spt" class="form-control" value="{{ $spt->nomor_spt }}">
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">2. Kode Rekening DPA</label>
                            <input type="text" name="dasar_rekening" class="form-control" value="{{ $spt->dasar_rekening }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tanggal DPA</label>
                            <input type="date" name="dasar_tanggal" class="form-control" value="{{ $spt->dasar_tanggal }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">3. Maksud / Dalam Rangka</label>
                        <textarea name="dalam_rangka" class="form-control" rows="2" required>{{ $spt->dalam_rangka }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">4. Tempat / Yang Dikunjungi</label>
                        <input type="text" name="yang_dikunjungi" class="form-control" value="{{ $spt->yang_dikunjungi }}" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tgl Mulai</label>
                            <input type="date" name="tgl_mulai" class="form-control" value="{{ $spt->tgl_mulai }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tgl Selesai</label>
                            <input type="date" name="tgl_selesai" class="form-control" value="{{ $spt->tgl_selesai }}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tanggal Ditetapkan SPT</label>
                        <input type="date" name="tgl_spt" class="form-control" value="{{ $spt->tgl_spt }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-danger"><i class="bi bi-people"></i> 5. Centang Pegawai Tugas (Bisa Banyak):</label>
                        <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                            @foreach($data_pegawai as $p)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="pegawai_ids[]" value="{{ $p->id }}" id="p{{ $p->id }}" 
                                    {{ in_array($p->id, $pegawai_terpilih) ? 'checked' : '' }}>
                                <label class="form-check-label" for="p{{ $p->id }}">
                                    <strong>{{ $p->nama }}</strong> <small class="text-muted">({{ $p->golongan }})</small>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('spt.index') }}" class="btn btn-secondary fw-bold">Batal</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="bi bi-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection