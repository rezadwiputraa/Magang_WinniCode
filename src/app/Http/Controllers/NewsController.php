<?php

namespace App\Http\Controllers;

use App\Models\BannerAdvertisement;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Comment;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        $comments = $news->comments()->latest()->paginate(5);
        $featureds = News::where('is_featured', true)->take(4)->get();
        $moreFromAuthor = News::where('author_id', $news->author_id)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();
        $advertisements = BannerAdvertisement::orderBy('created_at', 'desc')->take(1)->get();

        return view('pages.news.show', compact('news', 'featureds', 'advertisements', 'moreFromAuthor', 'comments'));
    }


    public function category($slug)
    {
        $category = NewsCategory::where('slug', $slug)->first();
        $advertisements = BannerAdvertisement::orderBy('created_at', 'desc')->take(2)->get();

        return view('pages.news.category', compact('category', 'advertisements'));
    }

    public function comment(Request $request, News $news)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:255'],
        ]);

        $badWords = ['bodoh', 'goblok', 'bangsat', 'anjing'];
        $comment = strtolower($request->comment);

        foreach ($badWords as $badWord) {
            if (str_contains($comment, $badWord)) {
                return redirect()->to(url()->previous() . '#comment-section')
                    ->withErrors(['comment' => 'Komentar mengandung kata yang tidak pantas.']);
            }
        }

        $news->comments()->create([
            'name' => $request->name,
            'review' => $request->comment,
        ]);

        return redirect()->to(url()->previous() . '#comment-section')
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function reply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'reply' => ['required', 'string', 'max:255'],
        ]);

        $badWords = ['bodoh', 'goblok', 'bangsat', 'anjing'];
        $replyLower = strtolower($validated['reply']);

        foreach ($badWords as $badWord) {
            if (str_contains($replyLower, $badWord)) {
                return back()->withErrors(['reply' => 'Balasan mengandung kata yang tidak pantas.'])
                    ->withInput()
                    ->withFragment('comment-section');
            }
        }

        $comment->replyComments()->create([
            'name' => $validated['name'],
            'review' => $validated['reply'],
        ]);

        return back()->with('success', 'Balasan berhasil ditambahkan.')
            ->withFragment('comment-section');
    }

    // Method BARU untuk menangani permintaan AJAX "Load More"
    public function loadMoreComments(Request $request, News $news)
    {
        // Ambil komentar untuk halaman selanjutnya
        $comments = $news->comments()->latest()->paginate(5);

        // Render HTML untuk komentar-komentar baru
        $html = view('partials._comments_loop', compact('comments'))->render();

        return response()->json([
            'html' => $html,
            'hasMorePages' => $comments->hasMorePages()
        ]);
    }


}
