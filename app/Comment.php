<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Comment extends Model
{
    public $timestamps = false;
    public $fillable = [];

    public function create($user_id,$text,$parent_post_id){
        $this->id = strtoupper(Uuid::generate(4)->string);
        $this->user_id = $user_id;
        $this->text = $text;
        $this->parent_post_id = $parent_post_id;
        $this->save();
    }
}
