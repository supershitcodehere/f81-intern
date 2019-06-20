<?php
namespace App\Http\Controllers;

use App\Exceptions\GuestApiException;
use App\Post;
use App\TestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class PostsController extends Controller
{

    public function index(){
        DB::statement('SET @parent_post_id = null;');
        $query =
            DB::raw(
                '

(SELECT
 posts.id,
 posts.user_id,
 posts.text,
 (SELECT COUNT(comments.id) FROM comments WHERE comments.parent_post_id = posts.id) AS comment_count,

 @parent_post_id as parent_post_id,
 posts.posted_at 
 FROM posts ORDER BY posts.posted_at DESC)
UNION ALL
(SELECT 
 comments.id,
 comments.user_id,
 comments.text,
 (SELECT COUNT(comments.parent_post_id) FROM comments) AS comment_count,
 @parent_post_id := comments.parent_post_id as parent_post_id,
 comments.posted_at
 FROM comments ORDER BY comments.posted_at DESC)
ORDER BY posted_at DESC

'
            );
        return response()->success(['posts'=>DB::select($query)]);

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
