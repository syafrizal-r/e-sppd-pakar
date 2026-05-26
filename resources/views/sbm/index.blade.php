<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Master Data SBM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ url('/') }}" class="btn btn-secondary">&larr; Kembali ke Form SPJ</a>
        <h3 class="fw-bold text-dark">Data Master SBM (Basis Pengetahuan)</h3>
    </div>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    + Tambah Aturan SBM Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('sbm.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Jenis Biaya</label>
                            <input type="text" name="jenis_biaya" class="form-control" placeholder="Cth: Penginapan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori / Golongan</label>
                            <input type="text" name="golongan_atau_eselon" class="form-control" placeholder="Cth: Golongan IV" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Wilayah Tujuan</label>
                            <input type="text" name="lokasi_tujuan" class="form-control" placeholder="Cth: Kota Medan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Batas Maksimal (Rp)</label>
                            <input type="number" name="batas_maksimal" class="form-control" placeholder="Cth: 1500000" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Aturan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Biaya</th>
                                    <th>Golongan/Jabatan</th>
                                    <th>Tujuan</th>
                                    <th>Pagu Maksimal (Rp)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_sbm as $index => $row)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $row->jenis_biaya }}</td>
                                    <td>{{ $row->golongan_atau_eselon }}</td>
                                    <td>{{ $row->lokasi_tujuan }}</td>
                                    <td class="text-end">{{ number_format($row->batas_maksimal, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('sbm.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aturan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>