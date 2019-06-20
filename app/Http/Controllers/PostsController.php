<?php
namespace App\Http\Controllers;

use App\Comment;
use App\Exceptions\GuestApiException;
use App\Post;
use App\TestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class PostsController extends Controller
{

    public function index(){
        $commentsCounts = [];

        $posts = Post::getLatestPosts();
        if(isset($posts)){
            $post_ids = [];
            foreach($posts as $post){
                if(!isset($post->parent_post_id)){
                    continue;
                }
                $post_ids[$post->parent_post_id] = $post->parent_post_id;
            }
            $commentsCounts = Comment::getCommentsCounts($post_ids);
        }

        return response()->success(['posts'=>$this->mergeCommentCount($posts,$commentsCounts)]);

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

    public function create(){
        $body = request()->getGuestApiRequest();
        $aPost = new Post();
        $textCount = mb_strlen($body['text']);
        if(!TestUser::isUserExists($body['user_id'])){
            throw new GuestApiException("ユーザが見つかりません",400);
        }
        if($textCount <= 0 || $textCount > 100){
            throw new GuestApiException("textは1文字以上100文字以下にしてください",400);
        }
        $aPost->create($body['user_id'],$body['text']);

        return response()->success();
    }

}
