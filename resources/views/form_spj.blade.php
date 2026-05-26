@extends('layouts.app')

@section('title', 'Verifikasi SPJ Sistem Pakar')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0"><i class="bi bi-input-cursor-text"></i> Input Rincian Kuitansi Perjalanan Dinas</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('evaluasi.spj') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Pegawai (Otomatis mendeteksi Golongan)</label>
                        <select name="pegawai_id" class="form-select" required>
                            <option value="">-- Silakan Pilih Pegawai --</option>
                            @foreach($data_pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }} (NIP. {{ $p->nip }}) - Gol. {{ $p->golongan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Wilayah Tujuan Dinas</label>
                            <select name="tujuan_dinas" class="form-select" required>
                                <option value="DKI Jakarta">DKI Jakarta</option>
                                <option value="Luar Kota (Sumut)">Luar Kota (Sumut)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jenis Biaya</label>
                            <select name="jenis_biaya" class="form-select" required>
                                <option value="Penginapan">Penginapan</option>
                                <option value="Uang Harian">Uang Harian</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nominal Riil Pengeluaran</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="nominal" class="form-control" placeholder="Contoh: 1200000" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-cpu"></i> Verifikasi dengan Sistem Pakar</button>
                    </div>
                </form>
            </div>
        </div>

        @if(session('hasil_evaluasi'))
            @php 
                $hasil = session('hasil_evaluasi');
                $status = is_array($hasil) ? $hasil['status_verifikasi'] : $hasil->status_verifikasi;
                $nama = is_array($hasil) ? $hasil['nama_pegawai'] : $hasil->nama_pegawai;
                $tujuan = is_array($hasil) ? $hasil['tujuan_dinas'] : $hasil->tujuan_dinas;
                $jenis = is_array($hasil) ? $hasil['jenis_biaya_diajukan'] : $hasil->jenis_biaya_diajukan;
                $nominal = is_array($hasil) ? $hasil['nominal_diajukan'] : $hasil->nominal_diajukan;
                $pesan = is_array($hasil) ? $hasil['pesan_sistem'] : $hasil->pesan_sistem;
                $warnaAlert = ($status == 'Valid') ? 'alert-success' : 'alert-danger';
                $ikon = ($status == 'Valid') ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
            @endphp
            
            <div class="alert {{ $warnaAlert }} shadow-sm border-0" role="alert">
                <h4 class="alert-heading fw-bold"><i class="bi {{ $ikon }}"></i> Kesimpulan Sistem Pakar: {{ $status }}</h4>
                <hr>
                <ul class="mb-3">
                    <li>Nama Pegawai: {{ $nama }}</li>
                    <li>Tujuan: {{ $tujuan }} | Jenis Biaya: {{ $jenis }}</li>
                    <li>Nominal Diajukan: <strong>Rp {{ number_format($nominal, 0, ',', '.') }}</strong></li>
                </ul>
                <p class="mb-0 fw-semibold text-dark">{{ $pesan }}</p>
            </div>
        @endif
    </div>
</div>
@endsection