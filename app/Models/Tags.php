<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $table = "tags";
    protected $fillable = ['name', 'description', 'user_id'];

    public $timestamps = false;

    // Relation hasMany with User
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relation belongsTomany with tasks
    public function tasks()
    {
        return $this->belongstomany(Task::class);
    }
}
