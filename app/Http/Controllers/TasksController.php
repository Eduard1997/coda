<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    protected Request $request;

    /**
     * TasksController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index() {
        $tasks = Tasks::where('user_id', \Auth::user()->id)->with('user')->get()->toArray();
        if(strpos(\Auth::user()->menuroles, 'admin')) {
            $tasks = Tasks::with('user')->get()->toArray();
        }
        return view('dashboard.tasks.tasks')->with(['tasks' => $tasks]);
    }

    public function editTask($id) {
        $task = Tasks::find($id);
        return view('dashboard.tasks.editTask')->with(['task' => $task]);
    }

    public function updateTask($id) {
        $data = $this->request->all();
        $task = Tasks::find($id);
        $task->title = $data['task-title'];
        $task->text = $data['task-text'];
        $task->priority = $data['task-priority'];
        $task->deadline = !empty($data['task-deadline']) ? \DateTime::createFromFormat('d/m/Y', $data['task-deadline']) : null;
        $task->save();
        return redirect()->route('tasks.index');
    }

    public function deleteTask($id) {
        Tasks::where('id', $id)->delete();
        return redirect()->route('tasks.index');
    }

    public function createTask() {
        return view('dashboard.tasks.createTask');
    }

    public function postCreateTask() {
        $data = $this->request->all();
        $task = new Tasks();
        $task->user_id = \Auth::user()->id;
        $task->title = $data['task-title'];
        $task->text = $data['task-text'];
        $task->priority = $data['task-priority'];
        $task->deadline = !empty($data['task-deadline']) ? \DateTime::createFromFormat('d/m/Y', $data['task-deadline']) : null;
        $task->save();
        return redirect()->route('tasks.index');
    }
}
