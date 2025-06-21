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

        p {
            font-size: 10pt;
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

        .isi p {
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
        }

        .ttd .ttd_QR img {
            height: 100px;
            margin-left: 200px;
            margin-bottom: 10px;
        }

        .judul {
            display: grid;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .judul h1 {
            font-size: 14px;
        }

        .judul p {
            margin-top: -10px;
        }

        .penutup p {
            text-align: justify;
        }
        .data-pengirim {
            font-size: 10pt;
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
            <p>Kode Pos 91122 Email: perindag@pareparekota.go.id</p>
            <p>Website: pareparekota.go.id</p>
        </div>
    </div>
    <div class="judul">
        <h1>SURAT KETERANGAN</h1>
    </div>
    <p>Yang Bertanda tangan dibawah ini:</p>
    <table class="data-pengirim" style="width: 98%; border-collapse: collapse; margin-left: 30px; ">
        <tr>
            <td style="padding: 4px;">Nama</td>
            <td style="padding: 4px;">: {{ $nama_pengirim }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;">Jabatan</td>
            <td style="padding: 4px;">: {{ $jabatan }}</td>
        </tr>
    </table>
    <p>Dengan ini Menerangkan Bahwa:</p>
    <table class="data-pengirim" style="width: 90%; border-collapse: collapse; margin-left: 30px; ">
        <tr>
            <td style="padding: 4px; width: 160px; ">Nama</td>
            <td style="padding: 4px;">: {{$nama_penerima}}</td>
        </tr>
        <tr>
            <td style="padding: 4px; width: 160px;">Tempat, tanggal lahir</td>
            <td style="padding: 4px;">: {{$tampat_lahir}}, {{ \Carbon\Carbon::parse($tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 4px; width: 160px;">Jenis Kelamin</td>
            <td style="padding: 4px;">: {{$jenis_kelamin}}</td>
        </tr>
        <tr>
            <td style="padding: 4px; width: 160px;">Alamat</td>
            <td style="padding: 4px;">: {{$alamat_lengkap}}</td>
        </tr>
        <tr>
            <td style="padding: 4px; width: 160px;">Agama</td>
            <td style="padding: 4px;">: {{$agama}}</td>
        </tr>
        <tr>
            <td style="padding: 4px; width: 160px;">Status</td>
            <td style="padding: 4px;">: {{$status_pernikahan}}</td>
        </tr>
    </table>
    <p>
        {!! $isi !!}
    </p>
    <div class="penutup">
        <p>
            Demikian Surat Keterangan ini dibuat untuk menjadi salah satu persyaratan izin usaha dan bukan merupakan surat perizinan.
        </p>
    </div>
    <div class="ttd">
        <p>Dikeluarkan di : Parepare</p>
        <p>Pada Tanggal : {{ \Carbon\Carbon::parse($tanggal_surat)->translatedFormat('d F Y') }}</p>
        <div></div>
        <p>KEPADA DINAS PERDAGANGAN</p>
        <p>KOTA PAREPARE</p>
        <div></div>
        <div class="ttd_QR">
            <img src="{{ public_path('assets/ttd/ttd_kadis.png') }}" alt="QR Code">
        </div>
        <div></div>
        <p class="nama_kadis">HJ A WISNAH T SE MSI</p>
        <p>NIP. 19711026 199203 2 010</p>
    </div>

</body>

</html>