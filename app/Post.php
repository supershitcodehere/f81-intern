<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Post extends Model
{
    public $timestamps = false;
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
}
