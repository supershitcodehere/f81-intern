<?php
namespace App\Traits;

use App\Comment;
use Illuminate\Support\Collection;

trait CommentApi{
    protected function getMergedPosts(Collection $posts) : Collection{
        $commentsCounts = [];

        if(isset($posts)){
            $post_ids = [];
            foreach($posts as $post){
                $id = $post->parent_post_id ?? $post->id;
                $post_ids[$id] = $id;
            }
            $commentsCounts = Comment::getCommentsCounts($post_ids);
        }
        return $this->mergeCommentCount($posts,$commentsCounts);
    }

    protected function mergeCommentCount(Collection $posts,Collection $comments) : Collection{
        foreach($posts as $key=>$post){
            $id = $post->parent_post_id ?? $post->id;
            if(isset($comments[$id])){
                $post->comment_count = $comments[$id]->comment_count;
            }else{
                $post->comment_count = 0;
            }
        }
        return $posts;
    }
}
