@extends('layouts.app')

@section( 'title', 'Winniverse | Baca Berita Online ')

@section('content')
    <!-- swiper -->
    <div class="swiper mySwiper mt-9">
        <div class="swiper-wrapper">
          @foreach ($banners as $banner)
          <div class="swiper-slide">
            <a href="{{ route('news.show', $banner->news->slug) }}" class="block">
              <div
                class="relative flex flex-col gap-1 justify-end p-3 h-72 rounded-xl bg-cover bg-center overflow-hidden"
                style="background-image: url('{{ asset('storage/' . $banner->news->thumbnail) }}')">
                <div class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[rgba(0,0,0,0.4)] to-[rgba(0,0,0,0)] rounded-b-xl"></div>
                <div class="relative z-10 mb-3" style="padding-left: 10px;">
                  <div class="bg-primary text-white text-xs rounded-lg w-fit px-3 py-1 font-normal mt-3">
                    {{ $banner->news->category->title }}
                  </div>
                  <p class="text-3xl font-semibold text-white mt-1">{{ $banner->news->title }}</p>
                  <div class="flex items-center gap-1 mt-1">
                    <img src="{{ asset('storage/' . $banner->news->author->avatar) }}" alt=""
                        class="w-5 h-5 rounded-full">
                    <p class="text-white text-xs">{{ $banner->news->author->name }}</p>
                  </div>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div>

        <!-- Tambahkan elemen navigasi dan pagination di sini -->
        <div class="swiper-pagination"></div>
    </div>


      <!-- Berita Unggulan -->
    <div class="flex flex-col px-14 mt-10 ">
        <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
          <div class="font-bold text-2xl text-center md:text-left">
            <p>Berita Unggulan</p>
            <p>Untuk Kamu</p>
          </div>
          <a href="{{ route('news.search') }}"
            class="bg-primary px-5 py-2 rounded-full text-white font-semibold mt-4 md:mt-0 h-fit">
            Lihat Semua
          </a>
        </div>
        <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
            @foreach ($featureds as $featured)
                <a href="{{ route('news.show', $featured->slug) }}">
                    <div
                        class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out"
                        style="height: 100%">
                        <div
                            class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">
                            {{ $featured->category->title }}
                        </div>
                        <img src="{{ asset('storage/' . $featured->thumbnail) }}" alt=""
                            class="w-full rounded-xl mb-3" style="height: 150px; object-fit: cover">
                         <p class="font-bold text-base mb-1">{{ $featured->title }}</p>
                         <p class="text-slate-400">{{ \Carbon\Carbon::parse($featured->created_at)->format('d M Y') }} </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Berita Terbaru -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 ">
        <div class="flex flex-col md:flex-row w-full mb-6">
          <div class="font-bold text-2xl text-center md:text-left">
            <p>Berita Terbaru</p>
            <p>Untuk Kamu</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-5">
          <!-- Berita Utama -->
          <div class="relative col-span-7 lg:row-span-3 border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer">
                <a href="{{ route('news.show', $news[0]->slug) }}">
                    <div class="bg-primary text-white rounded-full w-fit px-4 py-1 font-normal ml-5 mt-5 absolute">
                        {{ $news[0]->category->title }}
                    </div>
                <img src="{{ asset('storage/' . $news[0]->thumbnail) }}" alt="berita1" class="rounded-2xl">
                    <p class="font-bold text-xl mt-3">
                        {{ $news[0]->title }}
                    </p>
                    <p class="text-slate-400 text-base mt-1">
                        {!! \Str::limit($news[0]->content, 200) !!}
                    </p>
                    <p class="text-slate-400 text-sm mt-1">
                        {{ \Carbon\Carbon::parse($news[0]->created_at)->format('d M Y') }}
                    </p>
                </a>
            </div>
          <!-- Berita 1 -->
            @foreach ( $news->skip(1) as $latest )
                <a href="{{ route('news.show', $latest->slug) }}"
                    class="relative col-span-5 flex flex-col h-fit md:flex-row gap-3 border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer"
                    style="height: 100%">
                    <div class="bg-primary text-white rounded-full w-fit px-4 py-1 font-normal ml-2 mt-2 absolute text-sm">
                        {{ $latest->category->title }}
                    </div>
                    <img src="{{ asset('storage/' . $latest->thumbnail) }}" alt="berita2" class="rounded-xl md:max-h-48"
                        style="width: 200px; object-fit: cover">
                    <div class="mt-2 md:mt-0">
                        <p class="font-semibold text-lg">{{ $latest->title }}</p>
                        <p class="text-slate-400 text-base mt-1">{!! \Str::limit($latest->content, 150) !!}</p>
                        <p class="text-slate-400 text-base mt-1">{{ \Carbon\Carbon::parse($news[0]->created_at)->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>


        <!-- Advertisement -->
        <section class="flex flex-col items-center gap-5 px-4 md:px-10 lg:px-14 ">
            <div class="flex flex-col gap-3 items-center w-full max-w-sm">
                @foreach ($advertisements as $ads)
                <a href="{{ $ads->url }}">
                    <div class="w-[300px] h-[80px] border border-[#EEF0F7] rounded-3xl overflow-hidden">
                        <img src="{{ asset('storage/' . $ads->thumbnail) }}" class="object-cover w-full h-full" alt="ads" />
                    </div>
                </a>
                <p class="font-medium text-sm leading-[21px] text-[#A3A6AE] flex items-center gap-1">
                    Our Advertisement
                    <a href="{{ $ads->url }}" class="w-[18px] h-[18px]">
                        <img src="{{ asset('assets/icons/message-question.svg') }}" alt="icon" />
                    </a>
                </p>
                @endforeach
            </div>
        </section>

    </div>
      <!-- Author -->
      <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="mb-10 text-center md:mb-12 md:text-left">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
              Kenali Author<br class="hidden sm:block"> Terbaik Dari Kami
            </h2>
            <p class="mt-4 text-lg text-gray-600">
              Profil para penulis yang berdedikasi menyajikan berita berkualitas.
            </p>
          </div>

          <div class="grid grid-cols-2 gap-x-6 gap-y-10 sm:grid-cols-3 md:gap-x-8 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($authors as $author)
            <a href="{{ route('author.show', $author->username) }}" class="group block text-center">
              <div class="flex flex-col items-center">
                <div class="relative h-28 w-28 sm:h-32 sm:w-32">
                  <img
                    src="{{ asset('storage/' . $author->avatar) }}"
                    alt="Avatar {{ $author->name }}"
                    class="h-full w-full rounded-full object-cover shadow-md transition-transform duration-300 group-hover:scale-105"
                  />
                </div>

                <div class="mt-4">
                  <p class="text-lg font-semibold text-gray-900 transition-colors group-hover:text-primary">
                    {{ $author->name }}
                  </p>
                  <p class="mt-1 text-sm text-gray-500">
                    {{ $author->news->count() }} Berita
                  </p>
                </div>
              </div>
            </a>
            @endforeach
          </div>
        </div>
      </section>
    </div>

      <!-- Pilihan Author -->
    <div class="flex flex-col px-14 mt-10 mb-10">
        <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
          <div class="font-bold text-2xl text-center md:text-left">
            <p>Pilihan Author</p>
            <p>Untuk Kamu</p>
          </div>
        </div>
        <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
            @foreach ($news as $choice)
                <a href="{{ route('news.show', $choice->slug) }}">
                    <div
                        class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out"
                        style="height: 100%">
                    <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">
                        {{ $choice->category->title }}
                    </div>
                     <img src="{{ asset('storage/' . $choice->thumbnail) }}" alt="" class="w-full rounded-xl mb-3"
                         style="height: 200px; object-fit: cover">
                         <p class="font-bold text-base mb-1">{{ $choice->title }}</p>
                         <p class="text-slate-400">{{ \Carbon\Carbon::parse($choice->created_at)->format('d M Y') }} </p>
                    </div>
                </a>
            @endforeach
        </div>
      </div>
@endsection
