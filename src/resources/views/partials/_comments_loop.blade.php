@forelse ($comments as $comment)
    <div class="comment-item" id="comment-{{ $comment->id }}">
        <div class="comment-content">
            {{-- Comment Header --}}
            <div class="comment-header">
                <span class="commenter-name">{{ $comment->name }}</span>
                <span class="comment-timestamp">{{ $comment->created_at->diffForHumans() }}</span>
            </div>

            {{-- Comment Text --}}
            <p class="comment-text">{{ $comment->review}}</p>

            {{-- Comment Actions (Reply, View Replies) --}}
            <div class="comment-actions mt-2 d-flex align-items-center">
                <button class="btn btn-link btn-sm reply-button" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm-{{ $comment->id }}" aria-expanded="false" aria-controls="replyForm-{{ $comment->id }}">
                    <i class="bi bi-reply-fill"></i> Reply
                </button>

                @if ($comment->replyComments->isNotEmpty())
                    <span class="mx-1 text-muted">·</span>
                    <button class="btn btn-link btn-sm toggle-replies-btn" type="button" data-bs-toggle="collapse" data-bs-target="#replies-for-comment-{{ $comment->id }}" aria-expanded="false" aria-controls="replies-for-comment-{{ $comment->id }}">
                        <i class="bi bi-chevron-down me-1"></i>
                        <span class="btn-text">View Replies ({{ $comment->replyComments->count() }})</span>
                    </button>
                @endif
            </div>

            {{-- Collapsible Reply Form --}}
            <div class="reply-form-container collapse mt-3" id="replyForm-{{ $comment->id }}">
                <form class="reply-form" action="{{ route('comments.reply', $comment->id) }}" method="POST">
                    @csrf
                    <h5 class="reply-form-title mb-2">Write a reply to {{ $comment->name }}</h5>
                    <div class="mb-2">
                        <input type="text" class="form-control form-control-sm form-control-futuristic" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control form-control-sm form-control-futuristic" name="reply" rows="3" placeholder="Your Reply..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary-themed btn-sm">Submit Reply</button>
                        <button type="button" class="btn btn-secondary-themed btn-sm ms-2" data-bs-toggle="collapse" data-bs-target="#replyForm-{{ $comment->id }}">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Collapsible List of Replies --}}
        <div class="replies-list ps-4 mt-3 collapse" id="replies-for-comment-{{ $comment->id }}">
            @foreach ($comment->replyComments->sortBy('created_at') as $reply)
                <div class="comment-item is-reply" id="reply-{{ $reply->id }}">
                    <div class="comment-content">
                        <div class="comment-header">
                            <span class="commenter-name">{{ $reply->name }}</span>
                            <span class="comment-timestamp">{{ $reply->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="comment-text">{{ $reply->review }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@empty
    {{-- Biarkan kosong, karena pesan ditangani di view utama --}}
@endforelse
