<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Crypt;

class FrontController extends Controller
{
    // Homepage
    public function index()
    {
        // Ambil 6 artikel terbaru
        $latest_articles = Article::orderBy('created_at', 'desc')->take(6)->get();

        // Ambil 6 artikel populer
        $populer_articles = Article::orderBy('views', 'desc')->take(6)->get();

        // Tentukan ukuran chunk berdasarkan ukuran layar (mobile vs desktop)
        $chunk_size = (request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone/', request()->header('User-Agent'))) ? 1 : 3;

        return view('front.index', compact('latest_articles', 'populer_articles', 'chunk_size'));
    }

    public function articles(Request $request)
    {
        // Ambil artikel populer untuk ditampilkan di sisi halaman
        $populer_articles = Article::orderBy('views', 'desc')->take(3)->get();

        // Ambil filter dari request (default: 'latest')
        $filter = $request->input('filter', 'latest');

        // Terapkan logika filter
        switch ($filter) {
            case 'popular':
                $articles = Article::orderBy('views', 'desc')->paginate(6);
                break;
            case 'author':
                $articles = Article::orderBy('author', 'asc')->paginate(6);
                break;
            case 'latest':
            default:
                $articles = Article::orderBy('created_at', 'desc')->paginate(6);
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
}
