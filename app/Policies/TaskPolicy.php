<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // Controla que un usuario no edite o elimne tareas que no le correspondan
    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id;

    }

}
