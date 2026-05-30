<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak SPD - {{ $spd->nomor_surat ?? 'Draft' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Pengaturan Font dan Kertas untuk Dokumen Pemerintahan */
        body {
            /* Menggunakan Aptos Narrow, dengan cadangan Arial Narrow jika Aptos tidak ada */
            font-family: "Aptos Narrow", "Arial Narrow", Arial, sans-serif;
            font-size: 16px;
            line-height: 1.1;
        }

        /* CSS Khusus Print */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0.5cm 1cm 0.5cm 1cm;
                /* Margin atas dan bawah diperkecil agar kop naik dan muat */
            }

            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }
        }

        /* Styling Tabel Custom agar presisi seperti gambar */
        .table-spd {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            /* Margin diperkecil */
        }

        .table-spd th,
        .table-spd td {
            border: 1px solid #000 !important;
            padding: 3px 5px;
            /* Padding diperkecil agar baris tidak terlalu lebar */
            vertical-align: top;
        }

        /* Hilangkan border pada nested table untuk Pengikut */
        .table-pengikut {
            width: 100%;
            border-collapse: collapse;
        }

        .table-pengikut th,
        .table-pengikut td {
            border: none !important;
            border-right: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
            padding: 2px 5px;
        }

        .table-pengikut th:last-child,
        .table-pengikut td:last-child {
            border-right: none !important;
        }

        .table-pengikut tr:last-child td {
            border-bottom: none !important;
        }

        /* Class khusus untuk menghilangkan garis halus di tabel keterangan kanan atas */
        .table-no-border {
            width: 100%;
            border-collapse: collapse;
        }

        .table-no-border td {
            border: none !important;
            padding: 1px 4px !important;
            vertical-align: top;
        }

        .garis-kop {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-bottom: 10px;
            margin-top: 5px;
        }

        .btn-print {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 180px;
            padding: 10px;
            text-align: center;
            background-color: #0d6efd;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            z-index: 1000;
        }
    </style>
</head>

<body>

    <button class="no-print btn-print" onclick="window.print()">🖨️ Print Dokumen SPD</button>

    <table width="100%" style="table-layout: fixed;">
        <tr>
            <td width="15%" style="text-align:center; vertical-align:middle;">
                <img src="{{ asset('logo.png') }}" width="85">
            </td>
            <td width="85%" style="text-align:center; vertical-align:middle;">
                <div style="font-size:14pt; font-weight:bold; letter-spacing:0.5px;">
                    PEMERINTAH PROVINSI SUMATERA UTARA
                </div>
                <div style="font-size:16pt; font-weight:bold; margin-top:2px;">
                    DINAS PERTANIAN DAN KETAHANAN PANGAN
                </div>
                <div style="font-size:11pt; margin-top:3px;">
                    Jalan Jenderal Besar Dr. Abdul Haris Nasution No. 6 Gedung Johor Medan
                </div>
                <div style="font-size:11pt;">
                    Kode Pos : 20143 ; Telp/Fax. 7863567-78060633
                </div>
                <div style="font-size:11pt;">
                    <b>Website: http://dpkp.sumutprov.go.id</b> | E-mail : dinaspertapanprovusu@gmail.com
                </div>
            </td>
        </tr>
    </table>

    <div class="garis-kop"></div>

    <div class="row mb-2">
        <div class="col-7"></div>
        <div class="col-5">
            <table class="table-no-border">
                <tr>
                    <td width="35%">Lembar ke</td>
                    <td width="5%">:</td>
                    <td width="60%">....................</td>
                </tr>
                <tr>
                    <td>Kode No</td>
                    <td>:</td>
                    <td>....................</td>
                </tr>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td>{{ $spd->nomor_surat ?? '094/008/KEU/V/2026' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="text-center mb-3">
        <h5 class="fw-bold text-decoration-underline mb-0">SURAT PERJALANAN DINAS (SPD)</h5>
    </div>

    <table class="table-spd">
        <tr>
            <td width="5%" class="text-center">1</td>
            <td width="45%">Pengguna Anggaran/Kuasa Pengguna Anggaran</td>
            <td width="50%">{{ $kuasa_anggaran->nama ?? '..............................' }}</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>Nama/NIP yang melaksanakan perjalanan dinas</td>
            <td>
                {{ $pegawai->nama ?? '..............................' }}<br>
                NIP. {{ $pegawai->nip ?? '..............................' }}
            </td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>
                a. Pangkat dan Golongan<br>
                b. Jabatan/Instansi<br>
                c. Tingkat Biaya Perjalanan Dinas
            </td>
            <td>
                a. {{ $pegawai->pangkat ?? '..........' }} / {{ $pegawai->golongan ?? '..........' }}<br>
                b. {{ $pegawai->jabatan ?? '..............................' }}<br>
                c. {{ $spd->tingkat_biaya ?? '..........' }}
            </td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>Maksud Perjalanan Dinas</td>
            <td>{{ $spd->SampleSpt->maksud_tujuan ?? '........................................................' }}</td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>Alat angkutan yang dipergunakan</td>
            <td>{{ $spd->alat_angkut ?? '..............................' }}</td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>
                a. Tempat berangkat<br>
                b. Tempat Tujuan
            </td>
            <td>
                a. {{ $spd->tempat_berangkat ?? 'Medan' }}<br>
                b. {{ $spd->tempat_tujuan ?? '..............................' }}
            </td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>
                a. Lamanya Perjalanan Dinas<br>
                b. Tanggal Berangkat<br>
                c. Tanggal harus kembali/tiba di tempat baru
            </td>
            <td>
                a. {{ $spd->SampleSpt->lama_hari ?? '....' }} Hari<br>
                b. {{ $spd->SampleSpt->tgl_berangkat ?? '....................' }}<br>
                c. {{ $spd->SampleSpt->tgl_kembali ?? '....................' }}
            </td>
        </tr>

        @php
            // Filter agar pegawai utama tidak masuk ke daftar pengikut
            $daftar_pengikut = isset($spd->pengikut) ? $spd->pengikut->where('pegawai_id', '!=', $spd->pegawai_id)->values() : collect();
            // Menghitung rowspan dinamis (minimal 3 baris agar format a dan b tetap muncul)
            $jumlah_baris = $daftar_pengikut->count() > 0 ? $daftar_pengikut->count() + 1 : 3;
        @endphp

        <tr>
            <td class="text-center" rowspan="{{ $jumlah_baris }}">8</td>
            <td class="fw-bold">Pengikut :</td>
            <td class="p-0">
                <table width="100%" style="border-collapse: collapse; height: 100%; margin: 0;">
                    <tr>
                        <td width="50%" class="text-center fw-bold" style="border-right: 1px solid #000 !important; border-bottom: none !important; border-top: none !important; border-left: none !important; padding: 3px 5px;">Tanggal Lahir</td>
                        <td width="50%" class="text-center fw-bold" style="border: none !important; padding: 3px 5px;">Keterangan</td>
                    </tr>
                </table>
            </td>
        </tr>

        @if($daftar_pengikut->count() > 0)
            @foreach($daftar_pengikut as $index => $p)
            <tr>
                <td>{{ $index + 1 }}. {{ $p->pegawai->nama }} (NIP. {{ $p->pegawai->nip }})</td>
                <td class="p-0">
                    <table width="100%" style="border-collapse: collapse; height: 100%; margin: 0;">
                        <tr>
                            <td width="50%" class="text-center" style="border-right: 1px solid #000 !important; border-bottom: none !important; border-top: none !important; border-left: none !important; padding: 3px 5px;">{{ \Carbon\Carbon::parse($p->pegawai->tgl_lahir)->format('d-m-Y') }}</td>
                            <td width="50%" style="border: none !important; padding: 3px 5px;">{{ $p->keterangan }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td>1.........</td>
                <td class="p-0">
                    <table width="100%" style="border-collapse: collapse; height: 100%; margin: 0;">
                        <tr>
                            <td width="50%" style="border-right: 1px solid #000 !important; border-bottom: none !important; border-top: none !important; border-left: none !important; padding: 3px 5px;">a. ...................</td>
                            <td width="50%" style="border: none !important; padding: 3px 5px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>2. dst ......</td>
                <td class="p-0">
                    <table width="100%" style="border-collapse: collapse; height: 100%; margin: 0;">
                        <tr>
                            <td width="50%" style="border-right: 1px solid #000 !important; border-bottom: none !important; border-top: none !important; border-left: none !important; padding: 3px 5px;">b. dst ...............</td>
                            <td width="50%" style="border: none !important; padding: 3px 5px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endif

        <tr>
            <td class="text-center">9</td>
            <td>
                Pembebanan Anggaran :<br>
                a. SKPD<br>
                b. Kode Rekening
            </td>
            <td>
                <br>
                a. {{ $spd->skpd ?? '..............................' }}<br>
                b. {{ $spd->kode_rekening ?? '..............................' }}
            </td>
        </tr>
        <tr>
            <td class="text-center">10</td>
            <td>Keterangan Lain-lain</td>
            <td>{{ $spd->keterangan_lain ?? '' }}</td>
        </tr>
    </table>

    <div class="row mt-3">
        <div class="col-6"></div>
        <div class="col-6">
            <table class="table-no-border mb-0">
                <tr>
                    <td width="40%">Dikeluarkan di</td>
                    <td width="5%">:</td>
                    <td width="55%">Medan</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #000 !important;">Pada Tanggal</td>
                    <td style="border-bottom: 1px solid #000 !important;">:</td>
                    <td style="border-bottom: 1px solid #000 !important;">
                        @if(isset($spd->tgl_dikeluarkan))
                        &nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($spd->tgl_dikeluarkan)->locale('id')->translatedFormat(' F Y') }}
                        @else
                        ................... 2026
                        @endif
                    </td>
                </tr>
            </table>

            <div class="mt-2 text-start">
                <p style="margin-bottom: 60px;">
                    PENGGUNA ANGGARAN/<br>
                    KUASA PENGGUNA ANGGARAN
                </p>
                <p class="fw-bold text-decoration-underline mb-0">{{ $kuasa_anggaran->nama ?? 'NAMA JELAS' }}</p>
                <p class="mb-0">Pangkat: {{ $kuasa_anggaran->pangkat ?? '................' }}</p>
                <p class="mb-0">NIP. {{ $kuasa_anggaran->nip ?? '................' }}</p>
            </div>
        </div>
    </div>

</body>

</html>