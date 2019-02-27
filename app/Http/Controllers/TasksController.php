<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    public function gettasks(Request $request) {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    public function createtask(Request $request) {
        $task = Task::create([
            'title' => $request->title
        ]);
        if ($task) {
            return response()->json($task, 200);
        }
        return response()->json('Failed', 204);
    }

    public function gettask(Request $request) {
        $task = Task::find($request->id);
        if ($task) {
            return response()->json($task, 200);
        }
        return response()->json('Failed', 404);
    }

    public function deletetask(Request $request) {
        $task = Task::find($request->id);
        if ($task) {
            $task->delete();
            return response()->json('Deleted', 200);
        }
        return response()->json('Failed', 404);
    }

    public function updatetask(Request $request) {
        $task = Task::find($request->id);
        if ($task) {
            $task->title = $request->title;
            $task->save();
            return response()->json('Updated!', 200);
        }
        return response()->json('Failed', 404);
    }

}
