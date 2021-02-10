@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <i class="fa fa-align-justify"></i> {{ __('Statistics') }}
                                </div>
                                <div class="col-md-2 statistics-filters">
                                    <select data-toggle="tooltip" data-placement="top" title="Select Country"
                                            class="statistics-country-select form-control"
                                            name="statistics_country_select" onchange="getEvolutionConfirmedCases();getOtherStatisticsCases();">
                                        @foreach($countries as $country)
                                            <option value="{{$country->slug}}" @if($country->slug == 'romania') selected="selected" @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>Global Cases Today</span>
                                                </div>
                                                <div class="text-right statistics-filters">
                                                        <span data-toggle="tooltip" data-placement="top" title="Download CSV" class="download-csv-global-cases mr-2">
                                                            <i class="cil-cloud-download" style="font-size: 22px; cursor: pointer; color: #3399ff;"></i>
                                                        </span>
                                                    <span data-toggle="tooltip" data-placement="top" title="Download JSON" class="download-json-global-cases">
                                                            <i class="cil-data-transfer-down" style="font-size: 22px; cursor: pointer; color: #3399ff;"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="globalPieChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span>Evolution of Confirmed Cases</span>
                                                </div>
                                                <div class="col-md-3 statistics-filters">
                                                    <input data-toggle="tooltip" data-placement="top" title="Select From Date"
                                                           type="date" class="form-control" name="from_date_confirmed_evolution_country" value="<?php echo date('Y-m-d'); ?>" onchange="getEvolutionConfirmedCases()"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <input data-toggle="tooltip" data-placement="top" title="Select To Date" type="date"
                                                           class="form-control" name="to_date_confirmed_evolution_country" value="<?php echo date('Y-m-d'); ?>" onchange="getEvolutionConfirmedCases()"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="countryConfirmedEvolution"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span>Other statistics</span>
                                                </div>
                                                <div class="col-md-3 statistics-filters">
                                                    <input data-toggle="tooltip" data-placement="top" title="Select From Date"
                                                           type="date" class="form-control" name="from_date_confirmed_other_statistics_country" value="<?php echo date('Y-m-d'); ?>" onchange="getOtherStatisticsCases();"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <input data-toggle="tooltip" data-placement="top" title="Select To Date" type="date"
                                                           class="form-control" name="to_date_confirmed_other_statistics_country" value="<?php echo date('Y-m-d'); ?>" onchange="getOtherStatisticsCases();"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="otherStatisticsCanvas"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script>

        $(document).on('click', '.download-csv-global-cases', function() {
            window.location.href = '/download/download-csv-global-cases';
        });
        $(document).on('click', '.download-json-global-cases', function() {
            window.location.href = '/download/download-json-global-cases';
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })

        $(document).ready(function () {
            $.get('/statistics/get-global-cases-chart').then(function (response) {
                var ctx = document.getElementById('globalPieChart');
                var globalChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['New Confirmed', 'Total Confirmed', 'Total Deaths', 'Total Recovered'],
                        datasets: [{
                            //label: '# of Cases',
                            data: [response.global_cases.new_confirmed, response.global_cases.total_confirmed, response.global_cases.total_deaths, response.global_cases.total_recovered],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                            ],
                            borderWidth: 2
                        }]
                    },
                    /*options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }*/
                });
            })

            getEvolutionConfirmedCases()
            getOtherStatisticsCases();
        });

        function getEvolutionConfirmedCases() {
            var selectedCountry = $("select[name=statistics_country_select] option:selected" ).val();
            var evolutionDateFrom = $('input[name=from_date_confirmed_evolution_country]').val();
            var evolutionDateTo = $('input[name=to_date_confirmed_evolution_country]').val();

            $.get('/statistics/get-country-evolution?country=' + selectedCountry + '&date_from=' + evolutionDateFrom + '&date_to=' + evolutionDateTo).then(function(response) {
                var ctx = document.getElementById('countryConfirmedEvolution');
                var countryConfirmedEvolution = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response.dates,
                        datasets: [{
                            label: '# of Cases',
                            data: response.values,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            });
        }
        function getOtherStatisticsCases() {
            var selectedCountry = $("select[name=statistics_country_select] option:selected" ).val();
            var evolutionDateFrom = $('input[name=from_date_confirmed_other_statistics_country]').val();
            var evolutionDateTo = $('input[name=to_date_confirmed_other_statistics_country]').val();
            $.get('/statistics/get-other-statistics-chart?country=' + selectedCountry + '&date_from=' + evolutionDateFrom + '&date_to=' + evolutionDateTo).then(function (response) {
                console.log(response);
                var ctx = document.getElementById('otherStatisticsCanvas');
                var otherStatisticsCanvas = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Total recovered', 'Total confirmed', 'Total deaths'],
                        datasets: [{
                            //label: '# of Cases',
                            data: [typeof response.values.recoveredCases !== 'undefined' ? response.values.recoveredCases : response.values[0].recoveredCases, typeof response.values.confirmedCases !== 'undefined' ? response.values.confirmedCases : response.values[0].confirmedCases, typeof response.values.deathsCases !== 'undefined' ? response.values.deathsCases : response.values[0].deathsCases],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                            ],
                            borderWidth: 2
                        }]
                    },
                });
            })
        }
    </script>
@endsection
