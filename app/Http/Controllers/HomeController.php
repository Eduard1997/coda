<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use EasyRdf\Graph;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use PHPUnit\TextUI\Help;

class HomeController extends Controller
{
    protected Request $request;

    /**
     * HomeController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function renderHomePage() {
        $rdfDatabaseData = file_get_contents(storage_path("app\public\RDF\database.rdf"), true);
        $countrySummary = [];

        if(strlen($rdfDatabaseData) == 0) {
            $url = "https://api.covid19api.com/summary";
            $summaryResults = json_decode(Helper::curl($url), true);

            Helper::saveGlobalCasesToRdf($summaryResults['Global']);

            foreach ($summaryResults['Countries'] as $result) {
                if(Countries::get()->count() == 0){
                    Countries::insert([
                        'name' => $result['Country'],
                        'slug' => $result['Slug'],
                        'country_code' => $result['CountryCode']
                    ]);
                }

                if($result['Country'] == 'Romania' || $result['Country'] == 'Italy' || $result['Country'] == 'Germany' || $result['Country'] == 'Austria') {
                    Helper::saveCountrySummaryRdf($result);
                    array_push($countrySummary, $result);
                }
            }

            $data = [];
            $data['new_confirmed'] = $summaryResults['Global']['NewConfirmed'];
            $data['total_confirmed'] = $summaryResults['Global']['TotalConfirmed'];
            $data['total_deaths'] = $summaryResults['Global']['TotalDeaths'];
            $data['total_recovered'] = $summaryResults['Global']['TotalRecovered'];

        } else {
            $data = Helper::getGlobalCasesRdf();
            $countrySummary = Helper::getCountrySummaryRdf();
        }

        return view('dashboard.homepage')->with(['summaryData' => $data, 'countrySummary' => $countrySummary]);
    }

    public function downloadDashboardCsv() {
        $countrySummary = Helper::getCountrySummaryRdf();
        $fileName = 'CountriesSummary.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('Country', 'Total Confirmed', 'Total Recovered', 'Total Deaths');

        $callback = function() use($countrySummary, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($countrySummary as $countrySum) {
                $row['Country']  = $countrySum['Country'];
                $row['Total Confirmed']    = $countrySum['TotalConfirmed'];
                $row['Total Recovered']    = $countrySum['TotalRecovered'];
                $row['Total Deaths']  = $countrySum['TotalDeaths'];

                fputcsv($file, array($row['Country'], $row['Total Confirmed'], $row['Total Recovered'], $row['Total Deaths']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadDashboardJSON() {
        $countrySummary = Helper::getCountrySummaryRdf();
        $content = json_encode($countrySummary);
        $fileName = 'CountriesSummary.json';
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($content)
        ];

        return response()->make($content, 200, $headers);
    }

}
