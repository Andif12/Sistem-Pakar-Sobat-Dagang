<h3>Pemberitahuan UTTP Kedaluwarsa</h3>

<p>Halo {{ $dataAlatUkur->uttp->user->nama }},</p>

<p>Masa aktif status valid UTTP Anda dengan rincian berikut akan segera berakhir:</p>

<ul>
    <li>Nama Usaha: <strong>{{ $dataAlatUkur->uttp->nama_usaha }}</strong></li>
    <li>Jenis Alat: <strong>{{ $dataAlatUkur->uttp->jenis_alat }}</strong></li>
    <li>Merk/Type: <strong>{{ $dataAlatUkur->uttp->merk_type }}</strong></li>
    <li>Nomor Seri: <strong>{{ $dataAlatUkur->uttp->nomor_seri }}</strong></li>
    <li>No Registrasi: <strong>{{ $dataAlatUkur->uttp->no_registrasi }}</strong></li>
    <li>Tanggal Expired: <strong>{{ \Carbon\Carbon::parse($dataAlatUkur->tanggal_exp)->format('d-m-Y') }}</strong></li>
</ul>

<p>Silakan lakukan tera ulang melalui sistem kami "SOBAT DAGANG".</p>