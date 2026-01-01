<?php

namespace Omercanfs\BlogCore\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'blog_posts';

    protected $fillable = [
        'category_id', // Yeni
        'title',
        'slug',
        'image',       // Yeni
        'content',
        'view_count',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    // Resim yoksa varsayılan resmi döndüren fonksiyon
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        // Varsayılan resim (public klasörüne default-blog.jpg koymalısın)
        return asset('default-blog.jpg'); 
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}