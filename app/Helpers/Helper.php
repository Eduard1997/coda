<?php

namespace App\Helpers;
use EasyRdf\Graph;

class Helper
{
    public static function saveGlobalCasesToRdf($data) {

        $dbHeaderRdfContent = file_get_contents(storage_path("app\public\RDF\header.rdf"), true);
        $dbFooterRdfContent = file_get_contents(storage_path("app\public\RDF\\footer.rdf"), true);

        file_put_contents(storage_path("app\public\RDF\database.rdf"), $dbHeaderRdfContent);
        chmod(storage_path("app\public\RDF\database.rdf"), 0664);

        $dbContents = '<foaf:GlobalCases rdf:about="http://localhost:8000/storage/RDF/database.rdf">' . PHP_EOL .
            '<foaf:newConfirmed>' . $data['NewConfirmed'] . '</foaf:newConfirmed>' . PHP_EOL .
            '<foaf:TotalConfirmed>' . $data['TotalConfirmed'] . '</foaf:TotalConfirmed>' . PHP_EOL .
            '<foaf:NewDeaths>' . $data['NewDeaths'] . '</foaf:NewDeaths>' . PHP_EOL .
            '<foaf:TotalDeaths>' . $data['TotalDeaths'] . '</foaf:TotalDeaths>' . PHP_EOL .
            '<foaf:NewRecovered>' . $data['NewRecovered'] . '</foaf:NewRecovered>' . PHP_EOL .
            '<foaf:TotalRecovered>' . $data['NewConfirmed'] . '</foaf:TotalRecovered>' . PHP_EOL .
            '</foaf:GlobalCases>' . PHP_EOL;

        file_put_contents(storage_path("app\public\RDF\database.rdf"), $dbContents, FILE_APPEND);
        chmod(storage_path("app\public\RDF\database.rdf"), 0664);
        file_put_contents(storage_path("app\public\RDF\database.rdf"), $dbFooterRdfContent, FILE_APPEND);
        chmod(storage_path("app\public\RDF\database.rdf"), 0664);

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
        $currentRdfDatabase = file_get_contents(storage_path("app\public\RDF\database.rdf"), true);
        $newContent = str_replace('</rdf:RDF>', '', $currentRdfDatabase);
        $newContent .= '<foaf:CountriesSummary rdf:about="http://localhost:8000/storage/RDF/database.rdf">' . PHP_EOL .
            '<foaf:SummaryCountry>' . $country['Country'] . '</foaf:SummaryCountry>' . PHP_EOL .
            '<foaf:SummaryCountryCode>' . $country['CountryCode'] . '</foaf:SummaryCountryCode>' . PHP_EOL .
            '<foaf:SummarySlug>' . $country['Slug'] . '</foaf:SummarySlug>' . PHP_EOL .
            '<foaf:SummaryNewConfirmed>' . $country['NewConfirmed'] . '</foaf:SummaryNewConfirmed>' . PHP_EOL .
            '<foaf:SummaryTotalConfirmed>' . $country['TotalConfirmed'] . '</foaf:SummaryTotalConfirmed>' . PHP_EOL .
            '<foaf:SummaryNewDeaths>' . $country['NewDeaths'] . '</foaf:SummaryNewDeaths>' . PHP_EOL .
            '<foaf:SummaryTotalDeaths>' . $country['TotalDeaths'] . '</foaf:SummaryTotalDeaths>' . PHP_EOL .
            '<foaf:SummaryNewRecovered>' . $country['NewRecovered'] . '</foaf:SummaryNewRecovered>' . PHP_EOL .
            '<foaf:SummaryTotalRecovered>' . $country['TotalRecovered'] . '</foaf:SummaryTotalRecovered>' . PHP_EOL .
            '</foaf:CountriesSummary>' . PHP_EOL .
            '</rdf:RDF>';

        file_put_contents(storage_path("app\public\RDF\database.rdf"), $newContent);
        chmod(storage_path("app\public\RDF\database.rdf"), 0664);
    }

    public static function getCountrySummaryRdf() {
        $globalRdfContent = file_get_contents(storage_path("app\public\RDF\database.rdf"), true);
        $graph = new Graph();
        $graph->parse($globalRdfContent);

        $data = [];
        $countries = $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf', 'foaf:SummaryCountry');
        $countryTotalConfirmed = $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf', 'foaf:SummaryTotalConfirmed');
        $countryTotalRecovered = $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf', 'foaf:SummaryTotalRecovered');
        $countryTotalDeaths = $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf', 'foaf:SummaryTotalDeaths');

        $firstCountry = [];
        $firstCountry['Country'] = $countries[0]->getValue();
        $firstCountry['TotalConfirmed'] = $countryTotalConfirmed[0]->getValue();
        $firstCountry['TotalRecovered'] = $countryTotalRecovered[0]->getValue();
        $firstCountry['TotalDeaths'] = $countryTotalDeaths[0]->getValue();
        array_push($data, $firstCountry);

        $firstCountry = [];
        $firstCountry['Country'] = $countries[1]->getValue();
        $firstCountry['TotalConfirmed'] = $countryTotalConfirmed[1]->getValue();
        $firstCountry['TotalRecovered'] = $countryTotalRecovered[1]->getValue();
        $firstCountry['TotalDeaths'] = $countryTotalDeaths[1]->getValue();
        array_push($data, $firstCountry);

        $firstCountry = [];
        $firstCountry['Country'] = $countries[2]->getValue();
        $firstCountry['TotalConfirmed'] = $countryTotalConfirmed[2]->getValue();
        $firstCountry['TotalRecovered'] = $countryTotalRecovered[2]->getValue();
        $firstCountry['TotalDeaths'] = $countryTotalDeaths[2]->getValue();
        array_push($data, $firstCountry);

        $firstCountry = [];
        $firstCountry['Country'] = $countries[3]->getValue();
        $firstCountry['TotalConfirmed'] = $countryTotalConfirmed[3]->getValue();
        $firstCountry['TotalRecovered'] = $countryTotalRecovered[3]->getValue();
        $firstCountry['TotalDeaths'] = $countryTotalDeaths[3]->getValue();
        array_push($data, $firstCountry);

        return $data;
    }

    public static function curl($url) {
        $agent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
        $result = curl_exec($ch);
        return $result;
    }
}
