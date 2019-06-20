<?php
namespace App\Http\Controllers;

use App\Comment;
use App\Exceptions\GuestApiException;
use App\Post;
use App\TestUser;
use App\Traits\CommentApi;
use App\Traits\GuestApi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class PostsController extends Controller
{

    use CommentApi;
    use GuestApi;

    public function index(){
        return response()->success(['posts'=>$this->getMergedPosts(Post::getLatestPosts())]);
    }



    public function create(){
        $body = request()->getGuestApiRequest();
        $this->validatePostParams($body);
        $aPost = new Post();
        $aPost->create($body['user_id'],$body['text']);

        return response()->success();
    }

}
