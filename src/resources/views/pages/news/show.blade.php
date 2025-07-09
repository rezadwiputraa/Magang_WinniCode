@extends('layouts.app')

@section('title', $news->title)

@section('content')
 <!-- Detail Berita -->
 <div class="flex flex-col px-4 lg:px-14 mt-3">

    <div class="font-bold text-xl lg:text-2xl mb-6 text-center lg:text-left max-w-[300px]">
        <div class="font-normal text-slate-500 mb-3 text-xs">
            <p></p>{{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }}</p>
          </div>
      <p>{{ $news->title }}</p>
        <div>
            <p class="text-slate-400 text-base mt-5">
            </p>
        </div>
        <div class="flex items-center justify-center gap-[70px]">
            <!-- Author (lebih kecil & simetris) -->
            <a id="Author" href="{{ route('author.show', $news->author->username) }}" class="w-fit h-fit">
                <div class="flex items-center gap-3">
                <!-- Foto Author Diperkecil -->
                <div class="w-8 h-8 rounded-full overflow-hidden">
                    <img src="{{ asset('storage/' . $news->author->avatar) }}" class="object-cover w-full h-full" alt="avatar">
                </div>

                <!-- Nama dan Bio -->
                <div class="flex flex-col text-left">
                    <p class="font-bold text-xl text-black leading-tight">{{ $news->author->name }}</p>
                </div>
                </div>
            </a>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row w-full gap-10">
      <!-- Berita Utama -->
        <div class="lg:w-8/12">
            <img
                src="{{ asset('storage/' . $news->thumbnail) }}"
                alt="berita1"
                class="w-full max-h-[300px] rounded-xl object-cover"
            />
            <div class="mt-5 prose lg:prose-lg max-w-none">
                {!! $news->content !!}
            </div>
        </div>
      <!-- Berita Terbaru -->
      <div class="lg:w-4/12 flex flex-col gap-10">
        <div class="sticky top-24 z-40">
            <div class="w-full max-w-sm flex flex-col gap-6">
                <p class="font-bold text-xl whitespace-nowrap">
                  Berita Terbaru Lainnya
                </p>
                  <div class="h-px w-full bg-gray-300"></div>
                </div>
          <!-- Berita Card -->
          <div class="gap-5 flex flex-col">
                @foreach ($moreFromAuthor as $item )
                <a href="{{ route('news.show', $item->slug) }}">
                    <div
                      class="flex gap-3 border border-slate-300 hover:border-primary p-3 rounded-xl"
                    >
                      <div
                        class="bg-primary text-white rounded-full w-fit px-5 py-1 ml-2 mt-2 font-normal text-xs absolute"
                      >
                        {{ $item->category->title }}
                      </div>
                      <div class="flex gap-3 flex-col lg:flex-row">
                        <img
                          src="{{ asset('storage/' .$item->thumbnail) }}"
                          alt=""
                          class="max-h-36 rounded-xl object-cover"
                          style="width: 200px"
                        />
                        <div class="">
                          <p class="font-bold text-sm lg:text-base">
                            {{ $item->title }}
                          </p>
                          <p class="text-slate-400 text-xs">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </a>
                @endforeach
          </div>
        </div>
      </div>
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


    {{-- ================================================= --}}
    {{--         ARTICLE COMMENTS SECTION                --}}
    {{-- ================================================= --}}
    <section class="article-comments" id="commentsSection">
        <div class="comments-container mx-auto my-3">

            {{-- Trigger to Show the "Leave a Comment" Form --}}
            <div class="text-center mb-4" id="addCommentTriggerContainer">
                <button class="btn btn-primary-themed" type="button" data-bs-toggle="collapse" data-bs-target="#commentFormContainer" aria-expanded="false" aria-controls="commentFormContainer">
                    <i class="bi bi-pencil-square me-2"></i>Leave a Comment
                </button>
            </div>

            {{-- Collapsible Main Comment Form --}}
            <div class="collapse" id="commentFormContainer">
                <div class="comment-form-wrapper mb-5">
                    <h4 class="comment-form-title text-center mb-3">Write Your Comment</h4>

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Main Comment Submission Form --}}
                    <form action="{{ route('news.comment', $news->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="news_id" value="{{ $news->id }}">
                        <div class="mb-3">
                            <label for="commenterName" class="form-label">Your Name</label>
                            <input type="text" class="form-control form-control-futuristic" id="commenterName" name="name" placeholder="e.g., John Doe" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="commentText" class="form-label">Your Comment</label>
                            <textarea class="form-control form-control-futuristic" id="commentText" name="comment" rows="4" placeholder="Write your comment here..." required>{{ old('comment') }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary-themed me-2" data-bs-toggle="collapse" data-bs-target="#commentFormContainer">Cancel</button>
                            <button type="submit" class="btn btn-primary-themed">
                                <i class="bi bi-chat-left-text-fill me-2"></i>Submit Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Comments List Header --}}
            <h3 class="comments-list-title mb-4">Comments ({{ $comments->total() }})</h3>

            {{-- WADAH untuk daftar komentar --}}
            <div class="comments-list">
                {{-- Panggil partial untuk menampilkan komentar awal --}}
                @include('partials._comments_loop', ['comments' => $comments])
            </div>

            {{-- Tombol "Load More" --}}
            @if ($comments->hasMorePages())
                <div class="text-center mt-4" id="load-more-container">
                    <button id="load-more-comments" class="btn btn-primary-themed" data-page="2" data-article-id="{{ $news->id }}">
                        Load More Comments
                    </button>
                </div>
            @else
                {{-- Pesan jika tidak ada komentar sama sekali --}}
                @if($comments->isEmpty())
                    <div class="text-center p-4">
                        <p>No comments yet. Be the first to share your thoughts!</p>
                    </div>
                @endif
            @endif
        </div>
    </section>

          <!-- Berita Unggulan -->
        <div class="flex flex-col px-14 mt-10  ">
            <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
              <div class="font-bold text-2xl text-center md:text-left">
                <p>Berita Unggulan</p>
                <p>Untuk Kamu</p>
              </div>
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
@endsection


