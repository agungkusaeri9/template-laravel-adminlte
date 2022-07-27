<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(PostCategory::class,'post_category_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function image()
    {
        return asset('storage/'. $this->image);
    }
}
