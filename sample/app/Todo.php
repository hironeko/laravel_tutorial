<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'title',
        'user_id'
    ];

    public function getAll($id)
    {
        return $this->where('user_id', $id)->get();
    }
}
