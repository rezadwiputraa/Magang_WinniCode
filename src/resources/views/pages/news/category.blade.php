@extends ('layouts.app')

@section('title', $category->title)

@section('content')
    <!-- Header -->
    <div class="w-full mb-16 bg-[#F6F6F6]">
        <h1 class="text-center font-bold text-2xl p-24">{{ $category->title }} </h1>
      </div>

    <!-- Berita -->
     <div class=" flex flex-col gap-5 px-4 lg:px-14">
        <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
            @foreach ($category->news as $news)
              <a href="{{ route('news.show', $news->slug) }} ">
                <div
                  class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out"
                  style="height: 100%">
                    <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">
                      {{ $news->category->title }}
                    </div>
                  <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="" class="w-full rounded-xl mb-3"
                    style="height: 200px; object-fit: cover" >
                  <p class="font-bold text-base mb-1">{{ $news->title }}</p>
                  <p class="text-slate-400">{{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }}</p>
                </div>
              </a>
            @endforeach
        </div>
     </div>

        <!-- Advertisement -->
    <section class="flex flex-col items-center gap-5 px-4 md:px-10 lg:px-14 mt-10">
        <div class="flex flex-col gap-3 items-center w-full max-w-sm">
            @foreach ($advertisements->skip(1) as $ads)
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
@endsection


