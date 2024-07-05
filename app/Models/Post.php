<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Post extends Model
{
  
    use HasFactory;
    protected $fillable=[
        'title','description','created_user_id','updated_user_id','created_at','updated_at','likes'
    ];
    public function user(){
        return $this->belongsTo(User::class,'created_user_id');
    }
    //public function likes()
    //{
    //    return $this->hasMany(Like::class);
    //}
    //
    //public function isLikedByUser($user_id)
    //{
    //    return $this->likes()->where('user_id', $user_id)->exists();
    //}
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
}
