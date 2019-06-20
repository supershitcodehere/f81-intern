<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Exceptions\GuestApiException;
use App\Post;
use App\TestUser;
use App\Traits\CommentApi;
use App\Traits\GuestApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    use CommentApi;
    use GuestApi;

    public function index($post_id){

        return response()->success(['comments'=>$this->getMergedPosts(Comment::getComments($post_id))]);
    }

    public function create($post_id){
        $body = request()->getGuestApiRequest();
        $this->validatePostParams($body);
        if(!Post::isPostExists($post_id)){
            throw new GuestApiException("存在しないpost_idです",400);
        }
        $aComment = new Comment();
        $aComment->create($body['user_id'],$body['text'],$post_id);

        return response()->success();

    }
}
