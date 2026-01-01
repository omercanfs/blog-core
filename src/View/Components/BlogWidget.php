<?php

namespace Omercanfs\BlogCore\View\Components; // Namespace değişti!

use Illuminate\View\Component;
use Illuminate\View\View;
use Omercanfs\BlogCore\Models\Post; // Kendi içindeki modeli çağırıyor

class BlogWidget extends Component
{
    public $posts;
    public $title;

    public function __construct($limit = 3, $exceptId = null, $title = "Köyden Notlar & Blog")
    {
        $this->title = $title;

        $query = Post::with('category')->latest();

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        $this->posts = $query->take($limit)->get();
    }

    public function render(): View
    {
        // View yolu artık paket ismini kullanıyor
        return view('blog-core::components.blog-widget');
    }
}