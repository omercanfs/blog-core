<?php

namespace Omercanfs\BlogCore\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'blog_categories';
    protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }


    public function activePosts()
    {
        return $this->hasMany(Post::class, 'category_id')->where('status', 1);
    }
}