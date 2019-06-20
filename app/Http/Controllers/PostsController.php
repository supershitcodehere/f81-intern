<?php
namespace App\Http\Controllers;

use App\Comment;
use App\Exceptions\GuestApiException;
use App\Post;
use App\TestUser;
use App\Traits\CommentApi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class PostsController extends Controller
{

    use CommentApi;

    public function index(){
        return response()->success(['posts'=>$this->getMergedPosts(Post::getLatestPosts())]);
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
