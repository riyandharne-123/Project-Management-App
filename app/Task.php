<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name', 'description','color','user_id','project_id','status','start','end','order'
    ];
}
