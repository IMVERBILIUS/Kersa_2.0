<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{


    protected $fillable = [
        'title', 'description', 'thumbnail', 'status', 'views', 'user_id','author',
    ];


    public function subheadings()
{
    return $this->hasMany(Subheading::class, 'article_id', 'id');
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

}
