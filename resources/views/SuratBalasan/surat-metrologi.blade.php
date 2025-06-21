<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat keterangan - Sobat Dagang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
            padding: 30px;
            color: #333;
        }


        .bold-underline {
            font-weight: bold;
            text-decoration: underline;
        }

        .italic-underline {
            font-style: italic;
            text-decoration: underline;
        }

        .kop {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }

        .kop .logo {
            margin-top: -40px;
        }

        .kop .logo img {
            margin-bottom: -100px;
            height: 80px;
        }

        .kop .text {
            margin-top: -40px;
            flex: 1;
            text-align: center;
            font-size: 10pt;
            line-height: 1.3;
        }

        .kop h1,
        .kop h2 {
            margin: 0;
            text-transform: uppercase;
        }

        .kop h1 {
            font-size: 14pt;
        }

        .kop h2 {
            font-size: 16pt;
            font-weight: bold;
        }


        .kop p {
            font-size: 8pt;
            margin: 4px 0;
        }

        .isi_surat, 
        .isi_surat p,
        .isi_surat div,
        .isi_surat span {
            text-align: justify !important;
            text-justify: inter-word;
        }

        .isi_surat p {
            margin-bottom: 10px;
        }

        .bold {
            font-weight: bold;
        }

        .ttd {
            margin-top: 50px;
            float: right;
        }

        .ttd p {
            font-size: 10pt;
            text-align: right;
            margin-top: -10px;
        }

        .ttd .nama_kadis {
            font-weight: 300;
            text-decoration: underline;
        }

        .ttd .ttd_QR {
            display: flex;
            margin-top: 20px;
        }

        .ttd .ttd_QR img {
            height: 100px;
            margin-left: 200px;
            margin-bottom: 10px;
        }

        .judul {
            display: grid;
            text-align: right;
            margin: 0;
            padding: 0;
        }

        .judul h1 {
            font-size: 16px;
        }

        .judul p {
            margin-top: -10px;
        }
    </style>
</head>

<body>

    <div class="kop">
        <div class="logo">
            <img src="{{ public_path('assets/img/logoparepare.png') }}" alt="Logo">
        </div>
        <div class="text">
            <h1>Pemerintah Kota Parepare</h1>
            <h2>Dinas Perdagangan</h2>
            <p>Jalan Jend. Sudirman No.6 Parepare, Telp (0421)21426, Faks. (0421)28132</p>
            <p>Kode Pos 91122 Email: perindag@pareparekota.go.id & dinas.perdagangan.pare@gmail.com</p>
        </div>
    </div>
    

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <!-- Kolom Kiri -->
            <td style="width: 50%; vertical-align: top;"><br><br>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 1;">Nomor</td>
                        <td style="padding: 1;">: {{ $nomor_surat }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Sifat</td>
                        <td style="padding: 1;">: Biasa</td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Lampiran</td>
                        <td style="padding: 1;">: </td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Hal</td>
                        <td style="padding: 1;">: Pemberitahuan Pelaksanaan Tera/Tera Ulang UTTP</td>
                    </tr>
                </table>
            </td>

            <!-- Kolom Kanan -->
            <td style="width: 50%; text-align: right; vertical-align: top;">
                <p style="margin: 1; padding: 1;"><strong>Parepare, {{ \Carbon\Carbon::parse($tanggal_pembuatan_surat)->translatedFormat('d F Y') }}</strong></p><br>
                <p style="margin: 1; padding: 1;">Kepada</p>
                <p style="margin: 1; padding: 1;">YTH, {{ $nama_yang_dituju }}</p><br>
                <p style="margin: 1; padding: 1;">di</p>
                <p style="margin: 1; padding: 1;">Tempat</p>
            </td>

        </tr>
    </table><br>

    <div style="text-align: justify; text-justify: inter-word;">
        {!! $isi_surat !!}
    </div>

    <div class="ttd">
        <p>KEPALA DINAS PERDAGANGAN</p>
        <p>KOTA PAREPARE</p>
        <div class="ttd_QR">
            <img src="{{ public_path('assets/ttd/qr.png') }}" alt="QR Code">
        </div>
        <div></div>
        <p class="nama_kadis">HJ A WISNAH T SE MSI</p>
        <p>NIP. 19711026 199203 2 010</p>
    </div>

</body>

</html>