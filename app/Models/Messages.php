<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';
    use HasFactory;

    public function fromUser() {
        return $this->hasOne('App\Models\User', 'id', 'from_id');
    }

    public function toUser() {
        return $this->hasOne('App\Models\User', 'id', 'to_id');
    }
}
