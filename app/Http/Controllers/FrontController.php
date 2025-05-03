<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Crypt;

class FrontController extends Controller
{
    // Homepage
    public function index()
    {
        // Ambil 6 artikel terbaru
        $latest_articles = Article::where('status', 'published')->orderBy('created_at', 'desc')->take(6)->get();

        // Ambil 6 artikel populer
        $populer_articles = Article::where('status', 'published')->orderBy('views', 'desc')->take(6)->get();

        // Tentukan ukuran chunk berdasarkan ukuran layar (mobile vs desktop)
        $chunk_size = (request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone/', request()->header('User-Agent'))) ? 1 : 3;

        $galleries = Gallery::all();

        return view('front.index', compact('latest_articles', "galleries",'populer_articles', 'chunk_size'));
    }

    public function articles(Request $request)
    {
        // Ambil artikel populer untuk ditampilkan di sisi halaman
        $populer_articles = Article::orderBy('views', 'desc')->take(3)->get();

        // Ambil filter dari request (default: 'latest')
        $filter = $request->input('filter', 'latest');


        $articles = Article::where('status', 'published');

        // Terapkan logika filter
        switch ($filter) {
            case 'popular':
                $articles = $articles->orderBy('views', 'desc')->paginate(6);
                break;
            case 'author':
                $articles = $articles->orderBy('author', 'asc')->paginate(6);
                break;
            case 'latest':
            default:
                $articles = $articles->orderBy('created_at', 'desc')->paginate(6);
                break;
        }

        return view('front.articles', compact('articles', 'populer_articles', 'filter'));
    }

    // Halaman kontak
    public function contact()
    {
        return view('front.contact');
    }

    // Menampilkan detail artikel berdasarkan ID
    public function show($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404); // kalau gagal dekripsi, tampilkan 404
        }

        $article = Article::findOrFail($decryptedId);

        // Tambahkan jumlah view setiap kali dibuka
        $article->increment('views');

        return view('front.article_show', compact('article'));
    }
    public function gallery_show($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404); // kalau gagal dekripsi, tampilkan 404
        }

        $gallery = Gallery::findOrFail($decryptedId);

        return view('front.gallery_show', compact('gallery'));
    }

    public function galleries(Request $request)
{
    $query = Gallery::where('status', 'published');

    // Optional: Sorting (jika nanti mau ditambahkan)
    if ($request->has('sort_by')) {
        switch ($request->input('sort_by')) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
        }
    }

    $galleries = $query->paginate(6); // <= PENTING: paginate 6 item

    return view('front.galleries', compact('galleries'));
}

}
