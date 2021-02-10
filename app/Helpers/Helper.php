<?php

namespace App\Helpers;
use EasyRdf\Graph;
use EasyRdf\Literal\Date;

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
            '<foaf:TotalRecovered>' . $data['TotalRecovered'] . '</foaf:TotalRecovered>' . PHP_EOL .
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

    public static function getEvolutionFromRdf($argData) {
        $globalRdfContent = file_get_contents(storage_path("app\public\RDF\database.rdf"), true);
        $graph = new Graph();
        $graph->parse($globalRdfContent);
        $data = [];
        $fromDate = new \DateTime($argData['date_from']);
        $toDate = new \DateTime($argData['date_to']);
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($fromDate, $interval, $toDate);
        $countriesFound = [];
        $casesFound = [];
        $combinedResults = [];
        $finalCases = [];
        $finalDates = [];

        $diff = $toDate->diff($fromDate)->format('%a');
        if($diff == "1") {
            $date = str_replace('-', '', $argData['date_to']);
            array_push($countriesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:CountryEvolutionName' . $date));
            array_push($casesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:SummaryCountryCases' . $date));
            array_push($finalDates,  $argData['date_to']);
        } else {
            $fromDate = new \DateTime($argData['date_from']);
            $toDate = new \DateTime($argData['date_to']);
            $toDate->add(\DateInterval::createFromDateString('1 day'));
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($fromDate, $interval, $toDate);
            foreach ($period as $dt) {
                array_push($finalDates,  $dt->format("Y-m-d"));
                $date = str_replace('-', '', $dt->format("Y-m-d"));
                if(!empty($graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:CountryEvolutionName' . $date))) {
                    array_push($countriesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:CountryEvolutionName' . $date));
                }
                if(!empty($graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:SummaryCountryCases' . $date))) {
                    array_push($casesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:SummaryCountryCases' . $date));
                }
            }
        }

        foreach ($countriesFound as $key => $countryFound) {
            foreach ($countryFound as $key2 => $cf) {
                $temp = [];
                $temp['country'] = $cf->getValue();
                $temp['cases_found'] = $casesFound[$key][$key2]->getValue();
                array_push($combinedResults, $temp);
            }
        }

        foreach ($combinedResults as $cr) {
            if($cr['country'] == $argData['country_name']) {
                array_push($finalCases, $cr['cases_found']);
            }
        }

        return ['cases' => $finalCases, 'dates' => $finalDates];
    }

    public static function saveEvolutionToRdf($data) {
        $currentRdfDatabase = file_get_contents(storage_path("app\public\RDF\database.rdf"), true);
        $newContent = str_replace('</rdf:RDF>', '', $currentRdfDatabase);
        $newContent .= '<foaf:CountriesEvolution rdf:about="http://localhost:8000/storage/RDF/database.rdf">' . PHP_EOL;
        foreach ($data as $evolution) {
            $date = str_replace('-', ' ', $evolution['Date']);
            $date = str_replace('T00:00:00Z', '', $date);
            $date = str_replace(' ', '', $date);
            $newContent .=
                '<foaf:CountryEvolutionName' .$date . '>' . $evolution['Country'] . '</foaf:CountryEvolutionName' . $date . '>' . PHP_EOL .
                '<foaf:SummaryCountryCases' . $date . '>' . $evolution['Cases'] . '</foaf:SummaryCountryCases' . $date . '>' . PHP_EOL;
        }
        $newContent.='</foaf:CountriesEvolution>' . PHP_EOL . '</rdf:RDF>';
        file_put_contents(storage_path("app\public\RDF\database.rdf"), $newContent);
        chmod(storage_path("app\public\RDF\database.rdf"), 0664);
    }

    public static function getOtherStatisticsChart($argData) {
        $globalRdfContent = file_get_contents(storage_path("app\public\RDF\database.rdf"), true);
        $graph = new Graph();
        $graph->parse($globalRdfContent);
        $data = [];
        $fromDate = new \DateTime($argData['date_from']);
        $toDate = new \DateTime($argData['date_to']);
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($fromDate, $interval, $toDate);
        $countriesFound = [];
        $recoveredCasesFound = [];
        $confirmedCasesFound = [];
        $deathsCasesFound = [];
        $combinedResults = [];
        $finalCases = [];
        $finalDates = [];

        $diff = $toDate->diff($fromDate)->format('%a');
        if($diff == "1") {
            $date = str_replace('-', '', $argData['date_to']);
            array_push($countriesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:CountryOtherStatisticsName' . $date));
            array_push($recoveredCasesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryRecovered' . $date));
            array_push($confirmedCasesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryConfirmed' . $date));
            array_push($deathsCasesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryDeaths' . $date));
            array_push($finalDates,  $argData['date_to']);
        } else {
            $fromDate = new \DateTime($argData['date_from']);
            $toDate = new \DateTime($argData['date_to']);
            $toDate->add(\DateInterval::createFromDateString('1 day'));
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($fromDate, $interval, $toDate);
            foreach ($period as $dt) {
                array_push($finalDates,  $dt->format("Y-m-d"));
                $date = str_replace('-', '', $dt->format("Y-m-d"));
                if(!empty($graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:CountryOtherStatisticsName' . $date))) {
                    array_push($countriesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:CountryOtherStatisticsName' . $date));
                }
                if(!empty($graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryRecovered' . $date))) {
                    array_push($recoveredCasesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryRecovered' . $date));
                }
                if(!empty($graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryConfirmed' . $date))) {
                    array_push($confirmedCasesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryConfirmed' . $date));
                }
                if(!empty($graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryDeaths' . $date))) {
                    array_push($deathsCasesFound, $graph->allLiterals('http://localhost:8000/storage/RDF/database.rdf','foaf:OtherStatisticsCountryDeaths' . $date));
                }
            }
        }

        foreach ($countriesFound as $key => $countryFound) {
            foreach ($countryFound as $key2 => $cf) {
                $temp = [];
                $temp['country'] = $cf->getValue();
                $temp['recoveredCases'] = $recoveredCasesFound[$key][$key2]->getValue();
                $temp['confirmedCases'] = $confirmedCasesFound[$key][$key2]->getValue();
                $temp['deathsCases'] = $deathsCasesFound[$key][$key2]->getValue();
                array_push($combinedResults, $temp);
            }
        }
        if(!empty($combinedResults) && $combinedResults[0]['country'] == $argData['country_name']) {
            return ['cases' => $combinedResults, 'dates' => $finalDates];
        } else {
            return ['cases' => [], 'dates' => $finalDates];
        }

    }

    public static function saveOtherStatisticsChart($data, $date_from, $date_to) {
        $currentRdfDatabase = file_get_contents(storage_path("app\public\RDF\database.rdf"), true);
        $newContent = str_replace('</rdf:RDF>', '', $currentRdfDatabase);
        $newContent .= '<foaf:CountriesOtherStatistics rdf:about="http://localhost:8000/storage/RDF/database.rdf">' . PHP_EOL;
        foreach ($data as $evolution) {
            $recordDate = str_replace('T00:00:00Z', '', $evolution['Date']);
            if($recordDate >= $date_from && $recordDate <= $date_to) {
                $date = str_replace('-', ' ', $evolution['Date']);
                $date = str_replace('T00:00:00Z', '', $date);
                $date = str_replace(' ', '', $date);
                $newContent .=
                    '<foaf:CountryOtherStatisticsName' .$date . '>' . $evolution['Country'] . '</foaf:CountryOtherStatisticsName' . $date . '>' . PHP_EOL .
                    '<foaf:OtherStatisticsCountryRecovered' . $date . '>' . $evolution['Recovered'] . '</foaf:OtherStatisticsCountryRecovered' . $date . '>' . PHP_EOL .
                    '<foaf:OtherStatisticsCountryConfirmed' . $date . '>' . $evolution['Confirmed'] . '</foaf:OtherStatisticsCountryConfirmed' . $date . '>' . PHP_EOL .
                    '<foaf:OtherStatisticsCountryDeaths' . $date . '>' . $evolution['Deaths'] . '</foaf:OtherStatisticsCountryDeaths' . $date . '>' . PHP_EOL;
            }
        }
        $newContent.='</foaf:CountriesOtherStatistics>' . PHP_EOL . '</rdf:RDF>';
        file_put_contents(storage_path("app\public\RDF\database.rdf"), $newContent);
        chmod(storage_path("app\public\RDF\database.rdf"), 0664);
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
