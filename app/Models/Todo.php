<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $guarded=[];//'id', 'created_at', 'updated_at'
    // protected $fillable = ['title', 'is_completed'];

    protected $table ='todos';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}



