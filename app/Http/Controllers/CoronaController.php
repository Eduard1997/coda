<?php

namespace App\Http\Controllers;

use EasyRdf\GraphStore;
use EasyRdf\Http\Exception;
use Illuminate\Http\Request;
use EasyRdf\Graph;
use Illuminate\Support\Facades\Storage;

class CoronaController extends Controller
{
    protected Request $request;

    /**
     * CoronaController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


}
