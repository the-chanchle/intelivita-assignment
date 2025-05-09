<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'performed_at', 'points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
