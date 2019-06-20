<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class Comment extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    public $fillable = [];

    public function create($user_id,$text,$parent_post_id){
        $this->id = strtoupper(Uuid::generate(4)->string);
        $this->user_id = $user_id;
        $this->text = $text;
        $this->parent_post_id = $parent_post_id;
        $this->save();
    }

    public static function getCommentsCounts($post_ids = []) : Collection{
        return  Comment::query()
            ->select([
                'comments.parent_post_id',
                DB::raw('count(1) as comment_count'),
            ])
            ->whereIn('comments.parent_post_id',$post_ids)
            ->groupBy('comments.parent_post_id')
            ->get()
            ->keyBy('parent_post_id');
    }

    public static function getComments(string $post_id) : Collection{
        $query = DB::table('comments')
            ->select([
                'comments.id',
                'comments.user_id',
                'comments.text',
                'comments.parent_post_id',
                'comments.posted_at'
            ])
            ->where('parent_post_id','=',$post_id)
            ->orderBy('comments.posted_at','desc')
        ;
        return $query->get();
    }
}
