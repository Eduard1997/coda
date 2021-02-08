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

}
