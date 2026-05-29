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
            font-family: "Times New Roman", serif;
            font-size: 16px;
            line-height: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }
        .kop td { border: none; }
        .no-border td { border: none; }
        .underline {
            border-bottom: 1px solid black;
            display: inline-block;
            padding-bottom: 2px;
        }

        /* Tombol Cetak */
        @media print {
            .no-print { display: none; }
            .box-pakar { border: 1px solid #000 !important; }
        }
        .btn-print {
            display: block; width: 200px; margin: 20px auto; padding: 10px;
            text-align: center; background-color: #0d6efd; color: white;
            text-decoration: none; font-weight: bold; border-radius: 5px;
            cursor: pointer; border: none;
        }
        
        .box-pakar {
            border: 2px dashed #198754;
            padding: 10px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
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
                $temp = " ". $huruf[$nilai];
            } else if ($nilai <20) {
                $temp = penyebut($nilai - 10). " Belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " Seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " Seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
            }
            return $temp;
        }

        function terbilang($nilai) {
            if($nilai<0) {
                $hasil = "minus ". trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
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

    <hr style="border:2px solid black; margin-top:8px;">

    <table class="no-border mt-10">
        <tr>
            <td width="60%"></td>
            <td width="40%">
                <table>
                    <tr>
                        <td width="120">No. BKU</td>
                        <td width="10">:</td>
                        <td>{{ $spj->no_bku ?? '.....................' }}</td>
                    </tr>
                    <tr>
                        <td>Kode Rekening</td>
                        <td>:</td>
                        <td>{{ $spj->kode_rekening ?? '.....................' }}</td>
                    </tr>
                    <tr>
                        <td>Kode DPA</td>
                        <td>:</td>
                        <td>{{ $spj->kode_dpa ?? '.....................' }}</td>
                    </tr>
                    <tr>
                        <td>T.A</td>
                        <td>:</td>
                        <td>{{ date('Y') }}</td>
                    </tr>
                    <tr>
                        <td>No. BP</td>
                        <td>:</td>
                        <td>{{ $spj->no_bp ?? '.....................' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h2 style="text-align:center; text-decoration: underline; margin-bottom:20px;">
        KUITANSI
    </h2>

    <table style="width:100%;">
        <tr>
            <td width="150">Sudah terima dari</td>
            <td width="10">:</td>
            <td>Bendahara Pengeluaran/Bendahara Pengeluaran Pembantu</td>
        </tr>
        <tr>
            <td>Sebesar</td>
            <td>:</td>
            <td><b>Rp {{ number_format($spj->nominal_diajukan,0,',','.') }}</b></td>
        </tr>
        <tr>
            <td>Terbilang Rupiah</td>
            <td>:</td>
            <td style="padding-bottom:5px; font-style: italic; font-weight: bold;">
                == {{ terbilang($spj->nominal_diajukan) }} Rupiah ==
            </td>
        </tr>
        <tr>
            <td>Untuk pengeluaran</td>
            <td>:</td>
            <td style="padding-bottom:5px;">
                Biaya Perjalanan Dinas ({{ $spj->jenis_biaya_diajukan }}) dalam rangka melaksanakan kegiatan ke {{ $spj->tujuan_dinas ?? '-' }}
            </td>
        </tr>
    </table>

    <br>

    <table style="width:100%;">
        <tr>
            <td width="30%">
                <div class="box-pakar">
                    VERIFIKASI SISTEM PAKAR:<br>
                    Telah Sesuai Standar Biaya Masukan (SBM)
                </div>
            </td>
            <td width="70%">
                <table style="width:100%; margin-left: 20px;">
                    <tr>
                        <td width="200">1. {{ $spj->jenis_biaya_diajukan }}</td>
                        <td width="20">:</td>
                        <td width="100" style="text-align:right;">
                            {{ number_format($spj->nominal_diajukan,0,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>2. Biaya Lainnya</td>
                        <td>:</td>
                        <td style="text-align:right;">0</td>
                    </tr>
                    <tr>
                        <td><b>Total</b></td>
                        <td><b>:</b></td>
                        <td style="text-align:right; border-top: 1px solid #000;">
                            <b>{{ number_format($spj->nominal_diajukan,0,',','.') }}</b>
                        </td>
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
                Medan, {{ \Carbon\Carbon::parse($spj->created_at)->translatedFormat('d F Y') }}<br>
                Penerima
                <br><br><br><br>
                <span style="text-decoration: underline; font-weight: bold;">{{ strtoupper($spj->nama_pegawai) }}</span><br>
                NIP. 
            </td>
        </tr>
        <tr><td colspan="2"><br><br></td></tr>
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
                <br><br><br><br>
                <span style="text-decoration: underline;">(............................................)</span><br>
                NIP.
            </td>
        </tr>
    </table>

</body>
</html>