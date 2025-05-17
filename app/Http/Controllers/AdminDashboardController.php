<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Visit;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        // Ambil semua artikel dan galeri (opsional)
        $articles = Article::all();
        $galleries = Gallery::all();

        // Statistik kunjungan umum
        $today = Visit::whereDate('visited_at', Carbon::today())->count();
        $week = Visit::whereBetween('visited_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $month = Visit::whereMonth('visited_at', Carbon::now()->month)->count();
        $year = Visit::whereYear('visited_at', Carbon::now()->year)->count();

        // Statistik kunjungan per halaman
        $homeVisit = Visit::where('url', 'https://kersa.id/')->count();
        $articleVisit = Visit::where('url', 'https://kersa.id/articles')->count();
        $galleryVisit = Visit::where('url', 'https://kersa.id/galleries')->count();

        // Siapkan data untuk Chart.js
        $visitData = [
            'Homepage' => $homeVisit,
            'Articles' => $articleVisit,
            'Galleries' => $galleryVisit,
        ];

        // Kirim semua data ke blade
        return view('dashboard.admin', compact(
            'articles', 'galleries',
            'today', 'week', 'month', 'year',
            'homeVisit', 'articleVisit', 'galleryVisit'
        ))->with('visitData', $visitData); // Data visitData dikirimkan ke view
    }

}
