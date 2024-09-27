<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;
    public $table ='comment';
    public $primaryKey ='comment_id';
    public $incrementing =true;
    public $keyType ='int';
    public $timestamps =false;
}
