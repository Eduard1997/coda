<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Countries;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    protected Request $request;

    /**
     * StatisticsController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index() {
        $countries = Countries::select('name', 'slug')->get();
        return view('dashboard.statistics.index')->with(['countries' => $countries]);
    }

    public function getGlobalCasesChart() {
        $globalCases = Helper::getGlobalCasesRdf();
        return response()->json(['global_cases' => $globalCases]);
    }

    public function getEvolutionConfirmedCases() {
        $dataFront = $this->request->all();
        $datesEqual = false;
        if($dataFront['date_from'] == $dataFront['date_to']) {
            $datesEqual = true;
            $dataFront['date_from'] = date('Y-m-d', strtotime('-1 day', strtotime($dataFront['date_from'])));
        }

        $dataFront['country_name'] = Countries::where('slug', $dataFront['country'])->value('name');
        $dataFromRdf = Helper::getEvolutionFromRdf($dataFront);
        if(count($dataFromRdf["cases"]) != count(($dataFromRdf["dates"]))) {
            $url = 'https://api.covid19api.com/country/' . $dataFront['country'] . '/status/confirmed?from=' . $dataFront['date_from'].'T00:00:00Z&to=' . $dataFront['date_to'] . 'T00:00:00Z';
            $data = json_decode(Helper::curl($url), true);
            //$data = json_decode('[{"Country": "Switzerland","CountryCode": "CH","Lat": "46.82","Lon": "8.23","Cases": 0,"Status": "confirmed","Date": "2020-01-22T00:00:00Z"},{"Country": "Switzerland","CountryCode": "CH","Lat": "46.82","Lon": "8.23","Cases": 0,"Status": "confirmed","Date": "2020-01-23T00:00:00Z"}]', true);
            Helper::saveEvolutionToRdf($data);
            $datesArr = [];
            $values = [];
            foreach ($data as $dates) {
                if($datesEqual) {
                    if(date('Y-m-d', strtotime($dates['Date'])) == $dataFront['date_to']) {
                        array_push($datesArr, date('Y-m-d', strtotime($dates['Date'])));
                        array_push($values, $dates['Cases']);
                    }
                } else {
                    array_push($datesArr, date('Y-m-d', strtotime($dates['Date'])));
                    array_push($values, $dates['Cases']);
                }
            }
        } else {
            $datesArr = !empty($dataFromRdf['cases']) ? $dataFromRdf['dates'] : [];
            $values = $dataFromRdf['cases'];
        }

        return response()->json(['dates' => $datesArr, 'values' => $values]);
    }

}
