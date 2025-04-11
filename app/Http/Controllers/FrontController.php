<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //


    public function index(){

        $latest_articles = Article::orderBy('created_at', 'desc')->take(3)->get();
        $populer_articles = Article::orderBy('views', 'desc')->take(3)->get();
        return view('front.index', compact('latest_articles', 'populer_articles'));
    }

    public function articles(){
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('front.articles', compact('articles'));
    }

    public function contact(){
        return view('front.contact');
    }
}
