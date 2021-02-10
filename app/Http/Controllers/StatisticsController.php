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

    public function getOtherStatisticsChart() {
        $dataFront = $this->request->all();
        $datesEqual = false;
        if($dataFront['date_from'] == $dataFront['date_to']) {
            $datesEqual = true;
            $dataFront['date_from'] = date('Y-m-d', strtotime('-1 day', strtotime($dataFront['date_from'])));
        }

        $dataFront['country_name'] = Countries::where('slug', $dataFront['country'])->value('name');
        $dataFromRdf = Helper::getOtherStatisticsChart($dataFront);
        if(empty($dataFromRdf['cases'])) {
            $url = 'https://api.covid19api.com/total/country/' . $dataFront['country'];
            $data = json_decode(Helper::curl($url), true);
            Helper::saveOtherStatisticsChart($data, $dataFront['date_from'], $dataFront['date_to']);
            $datesArr = [];
            $values = [];
            foreach ($data as $dates) {
                $recordDate = str_replace('T00:00:00Z', '', $dates['Date']);
                if($recordDate >= $dataFront['date_from'] && $recordDate <= $dataFront['date_to']) {
                    array_push($datesArr, $recordDate);
                    $temp['recoveredCases'] = $dates['Recovered'];
                    $temp['confirmedCases'] = $dates['Confirmed'];
                    $temp['deathsCases'] = $dates['Deaths'];
                    array_push($values, $temp);
                }
            }
        } else {
            $datesArr = !empty($dataFromRdf['cases']) ? $dataFromRdf['dates'] : [];
            $values = $dataFromRdf['cases'][0];
        }

        return response()->json(['dates' => $datesArr, 'values' => $values]);
    }

    public function downloadCsvGlobalCases() {
        $globalCases = Helper::getGlobalCasesRdf();
        $fileName = 'GlobalCases.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('New Confirmed', 'Total Confirmed', 'Total Deaths', 'Total Recovered');

        $callback = function() use($globalCases, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $row['New Confirmed']    = $globalCases['new_confirmed'];
            $row['Total Confirmed']    = $globalCases['total_confirmed'];
            $row['Total Deaths']  = $globalCases['total_deaths'];
            $row['Total Recovered']  = $globalCases['total_recovered'];

            fputcsv($file, array($row['New Confirmed'], $row['Total Confirmed'], $row['Total Deaths'], $row['Total Recovered']));

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function downloadJsonGlobalCases() {
        $globalCases = Helper::getGlobalCasesRdf();$globalCases = Helper::getGlobalCasesRdf();
        $content = json_encode($globalCases);
        $fileName = 'GlobalCases.json';
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($content)
        ];

        return response()->make($content, 200, $headers);
    }

}
