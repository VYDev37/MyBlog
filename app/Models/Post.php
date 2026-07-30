<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'image',
        'user_id',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function readTime($wpm_estimation = 100) // words read per minute estimation
    {
        $wordC = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordC / $wpm_estimation);
        return max(1, $minutes);
    }

    public function imageUrl()
    {
        return Str::startsWith($this->image, 'http') ? $this->image : Storage::url($this->image);
    }
}
