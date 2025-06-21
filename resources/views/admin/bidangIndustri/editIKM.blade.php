@extends('layouts.admin')
@section('title', 'Edit Data IKM')

@section('content')
<main class="flex-1 flex flex-col bg-gray-100 min-h-screen py-10 px-6">
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-6">
    <h1 class="text-2xl font-bold mb-6 text-center text-[#083458]">Edit Data IKM</h1>

    <form action="{{ route('dataIKM.store') }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $ikm->id }}">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 font-medium">Nama Usaha</label>
          <input name="nama_ikm" type="text" value="{{ old('nama_ikm', $ikm->nama_ikm) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Luas Usaha</label>
          <input name="luas" type="text" value="{{ old('luas', $ikm->luas) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Nama Pemilik</label>
          <input name="nama_pemilik" type="text" value="{{ old('nama_pemilik', $ikm->nama_pemilik) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Jenis Kelamin</label>
          <select name="jenis_kelamin" required class="border border-black p-2 rounded-xl w-full">
            <option value="Laki-laki" {{ $ikm->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ $ikm->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>

        <div>
          <label class="block mb-1 font-medium">Kecamatan</label>
          <input name="kecamatan" type="text" value="{{ old('kecamatan', $ikm->kecamatan) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Kelurahan</label>
          <input name="kelurahan" type="text" value="{{ old('kelurahan', $ikm->kelurahan) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Komoditi</label>
          <input name="komoditi" type="text" value="{{ old('komoditi', $ikm->komoditi) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Jenis Industri</label>
          <input name="jenis_industri" type="text" value="{{ old('jenis_industri', $ikm->jenis_industri) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Alamat</label>
          <input name="alamat" type="text" value="{{ old('alamat', $ikm->alamat) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">NIB</label>
          <input name="nib" type="text" value="{{ old('nib', $ikm->nib) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Nomor Telepon</label>
          <input name="no_telp" type="text" value="{{ old('no_telp', $ikm->no_telp) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>

        <div>
          <label class="block mb-1 font-medium">Jumlah Tenaga Kerja</label>
          <input name="tenaga_kerja" type="number" value="{{ old('tenaga_kerja', $ikm->tenaga_kerja) }}" required
                 class="border border-black p-2 rounded-xl w-full">
        </div>
      </div>

      <div class="mt-6 flex justify-center">
        <button type="submit"
                class="bg-[#083458] text-white px-6 py-2 rounded-xl hover:bg-[#0b4d7a] transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</main>
@endsection
