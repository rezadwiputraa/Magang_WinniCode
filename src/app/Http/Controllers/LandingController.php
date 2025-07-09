<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Banner;
use App\Models\BannerAdvertisement;
use App\Models\News;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $featureds = News::where('is_featured', true)->get();
        $news = News::orderBy('created_at', 'desc')->get()->take(4);
        $authors = Author::all()->take(3);
        $advertisements = BannerAdvertisement::orderBy('created_at', 'desc')->get()->take(1);

        return view('pages.landing', compact('banners', 'featureds', 'news', 'authors', 'advertisements'));
    }

    public function search(Request $request)
    {
        // Mengambil input pencarian dengan nama 'q'
        $query = $request->input('q');

        // Inisialisasi query builder untuk model News
        $newsQuery = News::query();

        // Hanya lakukan pencarian jika ada query
        if (!empty($query)) {
            // Lakukan pencarian berdasarkan 'title' (atau tambahkan kolom lain seperti 'content')
            $newsQuery->where('title', 'LIKE', "%{$query}%");
            // Contoh jika ingin mencari juga di konten:
            // ->orWhere('content', 'LIKE', "%{$query}%");
        }

        // Urutkan berdasarkan tanggal publikasi terbaru
        // Gunakan paginate() untuk hasil yang bisa dipecah halaman
        $news = $newsQuery->latest('created_at')->paginate(8); // Mengambil 12 berita per halaman

        // Mengembalikan view 'search.blade.php'
        // dengan data berita ($news) dan query ($query)
        return view('pages.search.search', compact('news', 'query'));
    }

}
