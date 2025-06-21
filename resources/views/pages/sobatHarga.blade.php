@extends('layouts.home')
@section('title', 'Harga ' . $judul . ' - Perhari')
@section('content')

<div class="relative w-full h-64">

<img src="{{ asset('assets\img\background\dagang.jpg') }}" alt="Background" class="object-cover w-full h-full" />

<a href="{{ route('home') }}"
    class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:scale-110">
    <span class="text-2xl material-symbols-outlined">arrow_back</span>
</a>
</div>
<div class="container px-4 py-6 mx-auto">
    <div class="flex justify-center mb-6">
        <div class="overflow-x-auto rounded-full shadow-md scrollbar-hide">
            <div class="inline-flex gap-2 p-2 bg-blue-100 rounded-full flex-nowrap">
                @foreach ($semuaKategori->sortBy('id_index_kategori') as $kategoriItem)
                <button
                    onclick="window.location.href='{{ route('sobatHarga.kategori', ['kategori' => strtolower($kategoriItem->nama_kategori)]) }}'"
                    class="px-5 py-2 h-12 text-lg font-bold transition-all rounded-full {{ strtolower($kategoriItem->nama_kategori) === strtolower($judul) ? 'bg-[#083358] text-white shadow' : 'hover:bg-gray-100' }} whitespace-nowrap">
                    {{ ucwords($kategoriItem->nama_kategori) }}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <h1 class="text-2xl font-bold text-[#083358] mb-6">Harga {{ ucfirst($judul) }} per Hari Ini</h1>

    @foreach ($daftarHarga as $jenis => $pasars)
        <h2 class="mb-4 text-lg font-semibold text-center">{{ $jenis }}</h2>
        <div class="grid grid-cols-1 gap-6 mb-10 sm:grid-cols-2">
            @foreach ($pasars as $pasar => $data)
                <div class="relative p-4 bg-white border shadow-lg rounded-xl">
                    <div class="bg-[#083358] text-white text-center py-2 rounded-t-xl mb-4 text-lg font-semibold">
                        {{ $pasar }}
                    </div>
                    <div class="mt-4 mb-4 text-center">
                        <p class="text-sm text-gray-600">
                            Terakhir diperbarui: 
                            <span class="font-semibold text-black">
                                {{ \Carbon\Carbon::parse($data['tanggal_terakhir'])->translatedFormat('l, d M Y') }}
                            </span>
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-sm text-center text-gray-700">
                        <div>
                            <div class="font-semibold">Hari Ini</div>
                            <div class="text-base font-bold text-black">Rp. {{ number_format($data['hari_ini'], 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Kemarin</div>
                            <div class="text-base font-bold text-black">Rp. {{ number_format($data['kemarin'], 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div class="font-semibold">Selisih</div>
                            <div class="text-base font-bold text-black">                          
                                {{ $data['hari_ini'] - $data['kemarin'] >= 0 ? '+' : '-' }}
                                Rp. {{ number_format(abs($data['hari_ini'] - $data['kemarin']), 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="mt-2 text-center">
                        <div class="flex inline-flex items-center justify-center gap-2 px-3 py-2 mt-2 text-sm bg-gray-100 rounded-md shadow-sm">
                            <span class="material-symbols-outlined text-2xl
                                @if ($data['selisih'] > 0)
                                    text-green-600
                                @elseif ($data['selisih'] < 0)
                                    text-red-600
                                @else
                                    text-gray-500
                                @endif
                            ">
                                @if ($data['selisih'] > 0)
                                    arrow_upward
                                @elseif ($data['selisih'] < 0)
                                    arrow_downward
                                @else
                                    arrow_right_alt
                                @endif
                            </span>

                            <span>
                                Harga barang mengalami 
                                <span class="font-semibold">
                                    {{ $data['selisih'] > 0 ? 'kenaikan' : ($data['selisih'] < 0 ? 'penurunan' : 'tidak berubah') }}
                                </span>
                                {{ abs($data['selisih']) }}% dari harga kemarin
                            </span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <canvas id="chart-{{ $jenis }}-{{ $loop->index }}" height="150"></canvas>
                        <p class="mt-1 text-sm font-bold text-center text-black">Data Harga Penjualan Perhari</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
<script>
    @foreach ($daftarHarga as $jenis => $pasars)
        @foreach ($pasars as $pasar => $data)
            const ctx{{ $loop->parent->index }}{{ $loop->index }} = document.getElementById('chart-{{ $jenis }}-{{ $loop->index }}').getContext('2d');
            new Chart(ctx{{ $loop->parent->index }}{{ $loop->index }}, {
                type: 'line',
                data: {
                    labels: {!! json_encode($data['labels']) !!}, 
                    datasets: [{
                        label: '',
                        data: {!! json_encode($data['data']) !!},
                        backgroundColor: 'rgba(8, 51, 88, 0.05)',
                        borderColor: '#FFA500',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: '#FFA500'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return 'Rp' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + value.toLocaleString();
                                }
                            },
                        },
                        x: {
                            ticks: {
                                autoSkip: false
                            },
                        }
                    }
                }
            });
        @endforeach
    @endforeach
</script>
@endsection