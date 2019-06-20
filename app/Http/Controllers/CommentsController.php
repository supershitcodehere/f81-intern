<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Exceptions\GuestApiException;
use App\Post;
use App\TestUser;
use App\Traits\CommentApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    use CommentApi;

    public function index($post_id){

        return response()->success(['comments'=>$this->getMergedPosts(Comment::getComments($post_id))]);
    }

    public function create($post_id){
        $body = request()->getGuestApiRequest();
        $aComment = new Comment();
        $textCount = mb_strlen($body['text']);
        if(!TestUser::isUserExists($body['user_id'])){
            throw new GuestApiException("存在しないuser_idです",400);
        }
        if(!Post::isPostExists($post_id)){
            throw new GuestApiException("存在しないpost_idです",400);
        }
        if($textCount <= 0 || $textCount > 100){
            throw new GuestApiException("textは1文字以上100文字以下にしてください",400);
        }
        $aComment->create($body['user_id'],$body['text'],$post_id);

        return response()->success();

    }
}
