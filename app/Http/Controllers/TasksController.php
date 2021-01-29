<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
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
        return view('dashboard.tasks.tasks')->with(['tasks' => $tasks]);
    }
}
