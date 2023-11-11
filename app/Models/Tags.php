<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $table = "tags";
    protected $fillable = ['name', 'description'];

    public $timestamps = false;

    // Relation belongsTomany with tasks
    public function tasks()
    {
        return $this->belongstomany(Task::class);
    }
}
