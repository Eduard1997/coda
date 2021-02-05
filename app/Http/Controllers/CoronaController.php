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
    
    public function savetoRdf() {
        $file = fopen(storage_path("app\public\RDF\\database.rdf"), "r");
        $contents = fread($file, filesize(storage_path("app\public\RDF\\database.rdf")));
        fclose($file);
        $graph = new Graph();
        $graph->parse($contents);
        dd($graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:name'));
        dd($graph->get('http://localhost:8000/storage/RDF/database.rdf','foaf:test'));

    }


}
