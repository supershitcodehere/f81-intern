<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class Post extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    public $fillable = [];

    public static function isPostExists(string $id) : bool {
        return Post::query()->where('id','=',$id)->exists();
    }

    public function create($user_id,$text){
        $this->id = strtoupper(Uuid::generate(4)->string);
        $this->user_id = $user_id;
        $this->text = $text;
        $this->save();
    }

    public static function getLatestPosts(){
        $posts = Post::query()
            ->select([
                'posts.id',
                'posts.user_id',
                'posts.text',
                DB::raw('NULL as parent_post_id'),
                'posts.posted_at',
            ])->limit(1000)->orderBy('posts.posted_at','desc')
            ->union(
                Comment::query()->select([
                    'comments.id',
                    'comments.user_id',
                    'comments.text',
                    'comments.parent_post_id as parent_post_id',
                    'comments.posted_at',
                ])->limit(1000)->orderBy('comments.posted_at','desc')
            )
            ->get();
        return $posts;
    }
}
