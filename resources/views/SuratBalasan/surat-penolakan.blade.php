<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Penolakan - Sobat Dagang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
            padding: 30px;
            color: #333;
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
            margin: 2px 0;
        }

        .isi {
            margin-top: 30px;
        }

        .isi p {
            margin-bottom: 10px;
        }

        .bold {
            font-weight: bold;
        }

        .ttd {
            margin-top: 100px;
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
    <div class="isi">
        <p>Yth. <span class="bold">{{ $nama_pengirim }}</span></p>
        <p>Dengan ini kami sampaikan bahwa permohonan Anda <span class="bold">ditolak</span> dengan alasan sebagai berikut:</p>
        <p style="margin-left: 20px;">{!! $alasan !!}</p>
        <p>Demikian surat ini kami sampaikan. Atas perhatiannya kami ucapkan terima kasih.</p>
        <div></div>
        <p>Hormat kami,</p>
        <p><strong>Dinas Perdagangan Kota Parepare</strong></p>
    </div>
    <div class="ttd">
        <p>Dikeluarkan di : Parepare</p>
        <p>Pada Tanggal : {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
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