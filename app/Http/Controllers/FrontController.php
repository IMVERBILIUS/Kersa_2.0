<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;

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
<<<<<<< HEAD
        $populer_articles = Article::orderBy('views', 'desc')->take(3)->get();
        $articles = Article::orderBy('created_at', 'desc')->paginate(12); // Changed from get() to paginate(20)
        return view('front.articles', compact('articles', 'populer_articles'));
    }
=======
        // Get the filter from the request
        $filter = $request->input('filter', 'latest'); // Default to 'latest' if no filter is provided

        // Apply the filter logic
        switch ($filter) {
            case 'latest':
                // Default sorting by created_at for latest articles
                $articles = Article::orderBy('created_at', 'desc')->paginate(6);
                break;
            case 'popular':
                // Example: sorting by views for popular articles (assumes 'views' column exists)
                $articles = Article::orderBy('views', 'desc')->paginate(6);
                break;
            case 'author':
                // Example: sorting by author name (assumes 'author' column exists)
                $articles = Article::orderBy('author', 'asc')->paginate(6);
                break;
            default:
                // Default sorting by created_at for latest articles
                $articles = Article::orderBy('created_at', 'desc')->paginate(6);
                break;
        }

        // Return the view with the articles and the selected filter
        return view('front.articles', compact('articles', 'filter'));
    }



>>>>>>> 9715db2ac282c7b1fd55ad2422c1b2b6ace485e7
    // Halaman kontak
    public function contact()
    {
        return view('front.contact');
    }

    // Menampilkan detail artikel berdasarkan ID
    public function show($id)
    {
        $article = Article::findOrFail($id);

        // Tambahkan jumlah view setiap kali dibuka (opsional)
        $article->increment('views');

        return view('front.article_show', compact('article'));
    }

<<<<<<< HEAD
   
=======
>>>>>>> 9715db2ac282c7b1fd55ad2422c1b2b6ace485e7
}
