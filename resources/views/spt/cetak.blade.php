<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak SPT - {{ $spt->nomor_spt }}</title>
    <style>
        @page {
            size: A4;
            margin: 0.5cm 1cm 1cm 1cm;
        }
        body {
            font-family: "Times New Roman", serif;
            font-size: 16px;
            line-height: 1.4;
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
            padding: 2px 0;
        }
        .center { text-align: center; }
        .justify { text-align: justify; }
        .bold { font-weight: bold; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }
        .underline { text-decoration: underline; }
        
        /* Layout Pembagian Kolom Poin Utama */
        .indented-table {
            width: 100%;
            margin-top: 5px;
        }
        .sub-label {
            width: 100px;
        }
        .dots {
            width: 15px;
            text-align: center;
        }

        /* Penempatan Tanda Tangan Kanan Bawah (Poin 7) */
        .ttd-section {
            width: 45%;
            float: right;
            margin-top: 40px;
            text-align: left;
            font-size: 16px;
        }
        .clear { clear: both; }

        @media print {
            .no-print { display: none; }
        }
        .btn-print {
            display: block; width: 160px; margin: 10px auto; padding: 8px;
            text-align: center; background-color: #0d6efd; color: white;
            text-decoration: none; font-weight: bold; border-radius: 4px; border: none; cursor: pointer;
        }
    </style>
</head>
<body>

    <button class="no-print btn-print" onclick="window.print()">🖨️ Print Dokumen SPT</button>

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

    <hr style="border:2px solid black; margin-top:5px; margin-bottom: 15px;">

    <div class="center">
        <div class="bold underline" style="font-size: 14pt; letter-spacing: 1px;">SURAT TUGAS</div>
        <div style="margin-top: 3px;">Nomor: {{ $spt->nomor_spt ?? '......./......./ SPT /......./2026' }}</div>
    </div>

    <table class="mt-20" style="width: 100%;">
        <tr>
            <td width="90" class="bold">Dasar</td>
            <td width="20" class="center">:</td>
            <td class="justify">
                DPA APBD Dinas Pertanian dan Ketahanan Pangan Provinsi Sumatera Utara Tahun Anggaran 2026, 
                Kode Rekening: <strong>{{ $spt->dasar_rekening ?? '.........................................' }}</strong>, 
                Tanggal: <strong>{{ $spt->dasar_tanggal ? \Carbon\Carbon::parse($spt->dasar_tanggal)->translatedFormat('d F Y') : '....................... 2026' }}</strong>.
            </td>
        </tr>
    </table>

    <div class="center bold mt-20" style="letter-spacing: 2px;">MEMERINTAHKAN:</div>

    <table class="mt-10" style="width: 100%;">
        <tr>
            <td width="90" class="bold">Kepada</td>
            <td width="20" class="center">:</td>
            <td>
                @foreach($spt->pegawai as $index => $peg)
                <div class="justify mb-10" style="margin-bottom: 12px;">
                    <table>
                        <tr>
                            <td width="25">{{ $index + 1 }}.</td>
                            <td class="sub-label">Nama</td>
                            <td class="dots">:</td>
                            <td class="bold">{{ $peg->nama }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Pangkat/Gol</td>
                            <td>:</td>
                            <td>{{ $peg->pangkat }} / {{ $peg->golongan }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NIP</td>
                            <td>:</td>
                            <td>{{ $peg->nip }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>{{ $peg->jabatan }}</td>
                        </tr>
                    </table>
                </div>
                @endforeach
            </td>
        </tr>
    </table>

    <table class="mt-10" style="width: 100%;">
        <tr>
            <td width="90" class="bold">Untuk</td>
            <td width="20" class="center">:</td>
            <td>
                <table class="indented-table">
                    <tr>
                        <td width="25">1.</td>
                        <td class="justify">Dalam Rangka: {{ $spt->dalam_rangka }}</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td class="justify">Yang Dikunjungi: {{ $spt->yang_dikunjungi }}</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td class="justify">
                            Terhitung Mulai Tanggal {{ \Carbon\Carbon::parse($spt->tgl_mulai)->translatedFormat('d F Y') }} s.d. 
                            {{ \Carbon\Carbon::parse($spt->tgl_selesai)->translatedFormat('d F Y') }}.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="ttd-section">
        <table>
            <tr>
                <td width="100">Ditetapkan di</td>
                <td width="15">:</td>
                <td>Medan</td>
            </tr>
            <tr>
                <td>Pada Tanggal</td>
                <td>:</td>
                <td>{{ $spt->tgl_spt ? \Carbon\Carbon::parse($spt->tgl_spt)->translatedFormat('d F Y') : '....................... 2026' }}</td>
            </tr>
        </table>
        
        <div class="bold mt-10" style="margin-top: 15px; line-height: 1.2;">
            KEPALA DINAS PERTANIAN DAN KETAHANAN PANGAN PROVINSI SUMATERA UTARA
        </div>
        
        <div style="height: 70px;"></div>
        
        <div class="bold underline">Ir. RAJALI, S.Sos., M.S.P.</div>
        <div>Pembina Utama Muda</div>
        <div>NIP. 19680315 199303 1 003</div>
    </div>
    <div class="clear"></div>

</body>
</html>