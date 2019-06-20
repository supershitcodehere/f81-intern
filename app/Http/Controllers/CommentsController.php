<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Exceptions\GuestApiException;
use App\Post;
use App\TestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    public function index($post_id){
        //DB::statement(DB::raw('SET @parent_post_id = null'));

        //DB::unprepared('SET @parent_post_id = null;');
        $query = DB::table('comments')
            ->select([
               'comments.id',
               'comments.user_id',
               'comments.text',
                DB::raw("(SELECT COUNT(1) FROM comments WHERE comments.parent_post_id = '{$post_id}') AS comment_count"),
                'comments.parent_post_id',
                'comments.posted_at'
            ])
            ->where('parent_post_id','=',$post_id)
            ->orderBy('comments.posted_at','desc')

        ;

        /*
        $query =
            DB::raw(
                "
(SELECT
 comments.id,
 comments.user_id,
 comments.text,
 (SELECT COUNT(comments.parent_post_id) FROM comments) AS comment_count,
 @parent_post_id := comments.parent_post_id as parent_post_id,
 comments.posted_at
 FROM comments WHERE parent_post_id = '{$post_id}' ORDER BY comments.posted_at DESC)
ORDER BY posted_at DESC

"
            );
        */
        return response()->success(['comments'=>$query->get()]);
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
