@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Input Kuitansi - SPD {{ $spd->nomor_surat }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kuitansi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="spd_id" value="{{ $spd->id }}">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nomor Kuitansi</label>
                        <input type="text" name="nomor_kuitansi" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Jumlah Uang (Rp)</label>
                        <input type="number" name="jumlah_uang" class="form-control" required>
                    </div>
                </div>

                <div class="card border-primary mb-4">
                    <div class="card-header bg-primary text-white py-2">Otorisasi & Penandatangan</div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Pejabat Penandatangan (KPA)</label>
                                <select name="pejabat_ttd_id" class="form-select select2-pejabat" required>
                                    <option value="">Pilih Pejabat...</option>
                                    @foreach($pegawai as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nip }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Bendahara Pengeluaran</label>
                                <select name="bendahara_id" class="form-select select2-pejabat">
                                    <option value="">Pilih Bendahara...</option>
                                    @foreach($pegawai as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nip }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Simpan Kuitansi</button>
            </form>
        </div>
    </div>
</div>
@endsection