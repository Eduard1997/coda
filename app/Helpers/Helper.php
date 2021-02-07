<?php

namespace App\Helpers;
use EasyRdf\Graph;

class Helper
{
    public static function saveGlobalCasesToRdf($data) {

        $dbHeaderRdfContent = file_get_contents(storage_path("app\public\RDF\header.rdf"), true);
        $dbFooterRdfContent = file_get_contents(storage_path("app\public\RDF\\footer.rdf"), true);

        file_put_contents(storage_path("app\public\RDF\database.rdf"), $dbHeaderRdfContent);

        $dbContents = '<foaf:GlobalCases rdf:about="http://localhost:8000/storage/RDF/database.rdf">' . PHP_EOL .
            '<foaf:newConfirmed>' . $data['NewConfirmed'] . '</foaf:newConfirmed>' . PHP_EOL .
            '<foaf:TotalConfirmed>' . $data['TotalConfirmed'] . '</foaf:TotalConfirmed>' . PHP_EOL .
            '<foaf:NewDeaths>' . $data['NewDeaths'] . '</foaf:NewDeaths>' . PHP_EOL .
            '<foaf:TotalDeaths>' . $data['TotalDeaths'] . '</foaf:TotalDeaths>' . PHP_EOL .
            '<foaf:NewRecovered>' . $data['NewRecovered'] . '</foaf:NewRecovered>' . PHP_EOL .
            '<foaf:TotalRecovered>' . $data['NewConfirmed'] . '</foaf:TotalRecovered>' . PHP_EOL .
            '</foaf:GlobalCases>' . PHP_EOL;

        file_put_contents(storage_path("app\public\RDF\database.rdf"), $dbContents, FILE_APPEND);
        file_put_contents(storage_path("app\public\RDF\database.rdf"), $dbFooterRdfContent, FILE_APPEND);

    }

    public static function getGlobalCasesRdf() {
        $globalRdfContent = file_get_contents(storage_path("app\public\RDF\database.rdf"), true);
        $graph = new Graph();
        $graph->parse($globalRdfContent);

        $data = [];
        $data['new_confirmed'] = intval($graph->get('http://localhost:8000/storage/RDF/database.rdf','foaf:newConfirmed')->getValue());
        $data['total_confirmed'] = intval($graph->get('http://localhost:8000/storage/RDF/database.rdf','foaf:TotalConfirmed')->getValue());
        $data['total_deaths'] = intval($graph->get('http://localhost:8000/storage/RDF/database.rdf','foaf:TotalDeaths')->getValue());
        $data['total_recovered'] = intval($graph->get('http://localhost:8000/storage/RDF/database.rdf','foaf:TotalRecovered')->getValue());

        return $data;
    }

    public static function saveCountrySummaryRdf($country) {

    }

    public static function getCountrySummaryRdf() {

    }
}
