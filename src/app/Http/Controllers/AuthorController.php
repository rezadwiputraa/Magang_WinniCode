<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\BannerAdvertisement;
use App\Models\News;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show($username)
    {
        $author = Author::where('username', $username)->first();
        $news = News::where('author_id', $author->id)->get();
        $advertisements = BannerAdvertisement::orderBy('created_at', 'desc')->take(1)->get();

        return view('pages.author.show', compact('author', 'news', 'advertisements'));
    }
}
