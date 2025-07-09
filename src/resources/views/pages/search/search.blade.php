@extends('layouts.app')

@section('title', 'Hasil Pencarian Berita')

@section('content')
{{-- Bagian Header dan Form Pencarian --}}
<section class="relative w-full py-16 md:py-24 bg-[#F6F6F6] overflow-hidden"> {{-- Menggunakan <section> lebih semantik, penyesuaian padding vertikal --}}
    <div class="container mx-auto px-4 text-center relative z-10"> {{-- Menambahkan px-4 untuk padding responsif --}}
        @if (!empty($query))
            <h1 class="text-3xl lg:text-4xl font-extrabold mb-4 animate__animated animate__fadeInDown text-gray-800"> {{-- Menambahkan warna teks yang jelas --}}
                Hasil Pencarian untuk: "<span class="text-blue-600">{{ $query }}</span>" {{-- Mengubah warna highlight menjadi biru --}}
            </h1>
            <p class="text-lg opacity-90 mb-6 animate__animated animate__fadeInUp text-gray-700">
                Menemukan <span class="font-bold">{{ $news->count() }}</span> berita yang relevan.
            </p>
        @else
            <h1 class="text-3xl lg:text-4xl font-bold mb-4 animate__animated animate__fadeInDown text-gray-800">
                Temukan berita terbaru, menarik, dan informatif
            </h1>
            <h1 class="text-3xl lg:text-4xl font-bold mb-4 animate__animated animate__fadeInDown text-gray-800">
                hanya dengan satu pencarian.
            </h1>
        @endif

        <div class="container mx-auto text-center relative z-10">
            <div class="relative">
              <form id="searchForm" action="{{ route('news.search') }}" method="GET">
                <input
                    type="search"
                    name="q"
                    placeholder="Cari berita..."
                    class="border border-slate-300 rounded-full px-4 py-00 pl-8 w-full text-sm font-normal lg:w-8 focus:outline-none focus:ring-primary focus:border-primary"
                    id="searchInput"
                    aria-label="Search"
                    value="{{ request('q') }}"
                />
                <button
                    type="submit"
                    class=""
                    aria-label="Submit Search">
                </button>
              </form>
            </div>
        </div>
    </div>
</section>

    {{-- Bagian Konten Hasil Pencarian --}}
    <div class="container mx-auto px-4 py-10 lg:py-14">

        {{-- Section "Berita Terbaru" atau "Mungkin Anda Suka" saat belum ada query --}}
        @if (empty($query) && $news->isEmpty())
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-4 mb-8 rounded-lg" role="alert">
                <p class="font-bold">Selamat Datang di Halaman Pencarian!</p>
                <p>Silakan masukkan kata kunci di kolom di atas untuk menemukan berita yang Anda cari.</p>
                <p class="mt-2 text-sm opacity-80">
                    Anda juga bisa melihat beberapa berita populer di bawah ini sebagai inspirasi.
                </p>
            </div>
        @elseif (!empty($query) && $news->isEmpty())
            {{-- Pesan ini hanya akan muncul jika pencarian dilakukan tapi tidak ada hasil --}}
            <div class="text-center text-slate-500 py-10 bg-gray-50 rounded-lg shadow-sm p-6">
                <p class="text-xl font-semibold mb-4 text-gray-700">Oops! Tidak ada berita yang ditemukan.</p>
                <p class="text-md text-gray-600">Untuk kata kunci "<span class="font-bold">{{ $query }}</span>", kami tidak menemukan hasil yang cocok.</p>
                <p class="mt-3 text-gray-600">Coba periksa ejaan atau gunakan kata kunci yang lebih umum. <br>Misalnya: "sepak bola", "teknologi", "politik".</p>
                <img src="https://via.placeholder.com/200x150?text=No+Results" alt="No results found" class="mx-auto mt-6 opacity-70">
            </div>
        @else
            {{-- Tampilkan hasil pencarian jika ada --}}
                <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4 px-4">
                    @foreach ($news as $item)
                        <a href="{{ route('news.show', $item->slug) }}" class="block h-full">
                            <div
                                class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out"
                                style="height: 100%">

                                @if ($item->category)
                                    <div
                                        class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute z-10">
                                        {{ $item->category->title }}
                                    </div>
                                @endif

                                @if ($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                                        class="w-full rounded-xl mb-3" style="height: 200px; object-fit: cover">
                                @endif

                                <div class="flex flex-col flex-grow">
                                     <p class="font-bold text-base mb-1">{{ $item->title }}</p>
                                     <p class="text-slate-400 text-xs mt-auto">
                                        {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM Y') }}
                                        @if ($item->author)
                                            <span class="ml-2">by {{ $item->author->name }}</span>
                                        @endif
                                     </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
