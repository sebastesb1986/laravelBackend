<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";
    protected $fillable = ['name', 'description', 'created_at', 'expirated_at', 'user_id'];

    public $timestamps = false;

     // Relation hasMany with User
     public function users()
     {
         return $this->belongsTo(User::class, 'user_id', 'id');
     }
     
    // Relation belongsTomany with tags
    public function tags()
    {
        return $this->belongstomany(Tags::class);
    }
}
