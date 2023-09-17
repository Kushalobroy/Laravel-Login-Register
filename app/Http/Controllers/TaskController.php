<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        $validatedData = $request->validate([
            'task' => 'required|string',
            'user_id' => 'required|integer',
        ]);
        $task = new Task();
        $task->task = $validatedData['task'];
        $task->user_id = $validatedData['user_id'];
        $task->save();
        $response = [
            'task' => $task,
            'status' => '1',
            'message' => 'successfully created a task.',
        ];

        return response()->json($response, 200);
    }
    public function changeTaskStatus(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'required|integer',
            'status' => 'required|string',
        ]);
        $task = Task::find($validatedData['task_id']);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }
        $task->status = $validatedData['status'];
        $task->save();
        $response = [
            'task' => $task,
            'status' => '1',
            'message' => 'Marked task as done.',
        ];
        return response()->json($response);
    }
}
