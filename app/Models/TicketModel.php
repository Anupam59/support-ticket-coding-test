<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketModel extends Model
{
    use HasFactory;
    public $table ='ticket';
    public $primaryKey ='ticket_id';
    public $incrementing =true;
    public $keyType ='int';
    public $timestamps =false;
}
