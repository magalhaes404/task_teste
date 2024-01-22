<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('user_id',$request->user()->id)
        ->paginate(10);
        return response()->json($tasks,250);
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'title'            =>  'required|min:10',
            'descript'         =>  'min:30|max:150',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 406);
        } else {
            $task = TaskService::create($request);
            return response()->json(['message' => 'Salvo com sucesso'],250);
        }
    }

    public function show(Request $request,int $id)
    {
        $user = $request->user();
        $task = TaskService::findById($user,$id);
        return response()->json($task,250);
    }

    public function update(Request $request, int $id)
    {
        $validator = validator($request->all(), [
            'title'            =>  'required|min:10',
            'descript'         =>  'min:30|max:150',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 406);
        } else {
            $user = $request->user();
            $task = TaskService::update($id, $request);
            return response()->json(['message' => 'Atualizado com sucesso'],250);
        }
    }

    public function destroy(Request $request,int $id)
    {
        $user = $request->user();
        $task = TaskService::delete($user,$id);
        return response()->json(['message' => 'Deletado com sucesso'],250);
    }
}
