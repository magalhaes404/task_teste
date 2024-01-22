<?php
namespace App\Services;

use App\Models\Task;

class TaskService
{
    public static function create($request)
    {
        $task = new Task();
        $task->user_id = $request->user()->id;
        $task->title = $request->title;
        $task->descript = $request->descript;
        $task->save();
        return $task;
    }

    public static function findById($user,$id)
    {
        return Task::where('user_id',$user->id)
        ->where('id',$id)
        ->first();
    }

    public static function update($id,$request)
    {
        $user = $request->user();
        $task = TaskService::findById($user,$id);

        $task->title = $request->title;
        $task->descript = $request->descript;

        $task->save();

        return $task;
    }

    public static function delete($user,$id)
    {
        $task = TaskService::findById($user,$id);

        $task->delete();

        return $task;
    }
}
?>
