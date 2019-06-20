<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestUser extends Model
{
    protected $fillable = [];

    public static function isUserExists(string $id) : bool {
        return TestUser::query()->where('id','=',$id)->exists();
    }
}
