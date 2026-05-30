@extends('layouts.app') @section('content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Form Penerbitan Surat Perjalanan Dinas (SPD)</h6>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('spd.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Data Administrasi & APBD</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor SPD</label>
                            <input type="text" name="nomor_surat" class="form-control" placeholder="Contoh: 090/.../2026" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Referensi Dasar (SPT)</label>
                            <select name="spt_id" class="form-select" required>
                                <option value="">-- Pilih SPT --</option>
                                @foreach($spt as $s)
                                    <option value="{{ $s->id }}">{{ $s->nomor_surat }} - Tujuan: {{ $s->tempat_tujuan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tingkat Biaya Perjalanan</label>
                            <select name="tingkat_biaya" class="form-select" required>
                                <option value="Tingkat A">Tingkat A (Pejabat Eselon I/II)</option>
                                <option value="Tingkat B">Tingkat B (Pejabat Eselon III)</option>
                                <option value="Tingkat C" selected>Tingkat C (Pejabat Eselon IV/Staf)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Rekening Pembebanan</label>
                            <input type="text" name="kode_rekening" class="form-control" placeholder="Contoh: 5.1.02.04.01.0001" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Dikeluarkan</label>
                            <input type="date" name="tgl_dikeluarkan" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3">Data Personil & Tujuan</h5>

                        <div class="mb-3">
                            <label class="form-label">Pegawai yang Diperintah (Utama)</label>
                            <select name="pegawai_id" class="form-select" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }} (NIP. {{ $p->nip }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pejabat / Kuasa Pengguna Anggaran (KPA)</label>
                            <select name="kuasa_anggaran_id" class="form-select" required>
                                <option value="">-- Pilih Pejabat Penandatangan --</option>
                                @foreach($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pengikut (Bisa Pilih Lebih dari 1)</label>
                            <select name="pengikut_ids[]" class="form-select" multiple size="4">
                                @foreach($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Tahan tombol <b>CTRL</b> untuk memilih banyak pengikut.</small>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Alat Angkut</label>
                                <input type="text" name="alat_angkut" class="form-control" placeholder="Cth: Kendaraan Dinas" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Tempat Tujuan</label>
                                <input type="text" name="tempat_tujuan" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan Lain-lain (Opsional)</label>
                            <textarea name="keterangan_lain" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-3 mt-3 text-end">
                    <button type="reset" class="btn btn-secondary">Reset Form</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Data & Terbitkan SPD</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection