<!DOCTYPE html>
<html>

<head>
    <title>Cetak Kuitansi SPJ - {{ $spj->nama_pegawai }}</title>
    <style>
        @page {
            size: A4;
            margin: 0.5cm 1cm 1cm 1cm;
        }

        body {
            /* Menggunakan Aptos Narrow, dengan cadangan Arial Narrow jika Aptos tidak ada */
            font-family: "Aptos Narrow", "Arial Narrow", Arial, sans-serif;
            font-size: 16px;
            line-height: 1.1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding-bottom: 3px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .kop td {
            border: none;
        }

        .no-border td {
            border: none;
        }

        .underline {
            border-bottom: 1px solid black;
            display: inline-block;
            padding-bottom: 2px;
        }

        /* Tombol Cetak */
        @media print {
            .no-print {
                display: none !important;
            }
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

        .box-pakar {
            border: 2px dashed #198754;
            padding: 10px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            width: 85%;
        }
    </style>
</head>

<body>

    @php
    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp=" " . $huruf[$nilai];
        } else if ($nilai <20) {
            $temp=penyebut($nilai - 10). " Belas" ;
        } else if ($nilai < 100) {
            $temp=penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp=" Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp=penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp=" Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp=penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp=penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
        }
        return $temp;
    }

    function terbilang($nilai) {
        if($nilai<0) {
            $hasil="minus " . trim(penyebut($nilai));
        } else {
            $hasil=trim(penyebut($nilai));
        }
        return $hasil;
    }
    @endphp

    <button class="no-print btn-print" onclick="window.print()">🖨️ Cetak Kuitansi</button>

    <table width="100%" style="table-layout: fixed;">
        <tr>
            <td width="15%" style="text-align:center; vertical-align:middle;">
                <img src="{{ asset('logo.png') }}" width="90" alt="Logo">
            </td>

            <td width="85%" style="text-align:center; vertical-align:middle;">
                <div style="font-size:16pt; font-weight:bold; letter-spacing:0.5px;">
                    PEMERINTAH PROVINSI SUMATERA UTARA
                </div>
                <div style="font-size:20pt; font-weight:bold; margin-top:2px;">
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

    <hr style="border:2px solid black; margin-top:8px;">

    <table class="no-border mt-10" style="width: 100%;">
        <tr>
            <td width="60%" style="vertical-align: top;">
                <div class="box-pakar">
                    VERIFIKASI SISTEM PAKAR:<br>
                    Telah Sesuai Standar Biaya Masukan (SBM)
                </div>
            </td>
            <td width="40%">
                <table style="width: 100%;">
                    <tr>
                        <td width="110">No. BKU</td>
                        <td width="15" class="center">:</td>
                        <td>{{ $spj->no_bku ?? '.....................' }}</td>
                    </tr>
                    <tr>
                        <td>Kode Rekening</td>
                        <td class="center">:</td>
                        <td>{{ $spj->kode_rekening ?? '.....................' }}</td>
                    </tr>
                    <tr>
                        <td>Kode DPA</td>
                        <td class="center">:</td>
                        <td>{{ $spj->kode_dpa ?? '.....................' }}</td>
                    </tr>
                    <tr>
                        <td>T.A</td>
                        <td class="center">:</td>
                        <td>{{ date('Y') }}</td>
                    </tr>
                    <tr>
                        <td>No. BP</td>
                        <td class="center">:</td>
                        <td>{{ $spj->no_bp ?? '.....................' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h2 style="text-align:center; text-decoration: underline; margin-bottom:20px; margin-top: 15px;">
        KUITANSI
    </h2>

    <table style="width:100%;">
        <tr>
            <td width="160">Sudah terima dari</td>
            <td width="15" class="center">:</td>
            <td>Bendahara Pengeluaran / Bendahara Pengeluaran Pembantu</td>
        </tr>
        <tr>
            <td>Sebesar</td>
            <td class="center">:</td>
            <td><b>Rp {{ number_format($spj->nominal_diajukan,0,',','.') }}</b></td>
        </tr>
        <tr>
            <td>Terbilang Rupiah</td>
            <td class="center">:</td>
            <td style="font-style: italic; font-weight: bold;">
                == {{ terbilang($spj->nominal_diajukan) }} Rupiah ==
            </td>
        </tr>
        <tr>
            <td>Untuk pengeluaran</td>
            <td class="center">:</td>
            <td style="text-align: justify;">
                
                <div style="border-bottom: 2px dotted #000; padding-bottom: 5px; margin-bottom: 5px;">
                    Biaya Perjalanan Dinas ({{ $spj->jenis_biaya_diajukan }}) dalam rangka melaksanakan kegiatan ke {{ $spj->tujuan_dinas ?? '-' }}
                </div>
                
                dengan rincian :
                <table style="width: 100%; margin-top: 5px;">
                    <tr>
                        <td width="280">1. Uang Harian</td>
                        <td width="15" class="center">:</td>
                        <td>{{ stripos($spj->jenis_biaya_diajukan, 'Harian') !== false ? number_format($spj->nominal_diajukan, 0, ',', '.') : '' }}</td>
                    </tr>
                    <tr>
                        <td>2. Biaya Transportasi</td>
                        <td class="center">:</td>
                        <td>{{ stripos($spj->jenis_biaya_diajukan, 'Transport') !== false ? number_format($spj->nominal_diajukan, 0, ',', '.') : '' }}</td>
                    </tr>
                    <tr>
                        <td>3. Biaya Penginapan</td>
                        <td class="center">:</td>
                        <td>{{ stripos($spj->jenis_biaya_diajukan, 'Penginapan') !== false ? number_format($spj->nominal_diajukan, 0, ',', '.') : '' }}</td>
                    </tr>
                    <tr>
                        <td>4. Uang Representasi perjalanan dinas</td>
                        <td class="center">:</td>
                        <td>{{ stripos($spj->jenis_biaya_diajukan, 'Representasi') !== false ? number_format($spj->nominal_diajukan, 0, ',', '.') : '' }}</td>
                    </tr>
                    <tr>
                        <td>5. Biaya Taksi</td>
                        <td class="center">:</td>
                        <td>{{ stripos($spj->jenis_biaya_diajukan, 'Taksi') !== false ? number_format($spj->nominal_diajukan, 0, ',', '.') : '' }}</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

    <br><br>

    <table style="width:100%; text-align:center;">
        <tr>
            <td width="50%">
                Pejabat Pelaksana Teknis<br>
                Kegiatan
                <br><br><br><br>
                <span style="text-decoration: underline;">(............................................)</span><br>
                NIP.
            </td>
            <td width="50%">
                Medan, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ \Carbon\Carbon::parse($spj->created_at)->locale('id')->translatedFormat('F Y') }}<br>
                Penerima
                <br><br><br><br>
                <span style="text-decoration: underline; font-weight: bold;">{{ $spj->nama_pegawai }}</span><br>
                NIP.
            </td>
        </tr>
        <tr>
            <td colspan="2"><br><br></td>
        </tr>
        <tr>
            <td>
                Menyetujui<br>
                Pengguna Anggaran /<br>
                Kuasa Pengguna Anggaran
                <br><br><br><br>
                <span style="text-decoration: underline;">(............................................)</span><br>
                NIP.
            </td>
            <td>
                Bendahara Pengeluaran /<br>
                Bendahara Pengeluaran Pembantu
                <br><br><br><br><br>
                <span style="text-decoration: underline;">(............................................)</span><br>
                NIP.
            </td>
        </tr>
    </table>

</body>
</html>