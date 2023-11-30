<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'file_id',
        'latitude',
        'longitude',
        'author_id'
    ];

    public function file()
    {
       return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function liked()
    {
       return $this->belongsToMany(User::class, 'likes');
    }
    
    public function likedByUser($userId) : bool
    {
        return Like::where([
            'user_id' => $userId,
            'post_id' => $this -> id,
        ])->exists();
    }
}
