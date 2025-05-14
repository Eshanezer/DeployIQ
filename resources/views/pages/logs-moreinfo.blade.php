@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                @include('layouts.flash')
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card">
                                <span class="mask bg-danger opacity-10 border-radius-lg"></span>
                                <div class="card-body p-3 position-relative">
                                    <div class="row">
                                        <div class="col-8 text-start">
                                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                <i class="ni ni-circle-08 text-dark text-gradient text-lg opacity-10"
                                                    aria-hidden="true"></i>
                                            </div>
                                            <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                                {{ $file->name }}
                                            </h5>
                                            <span class="text-white text-sm">Error Log File Name</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
                            <div class="card">
                                <span class="mask bg-success opacity-10 border-radius-lg"></span>
                                <div class="card-body p-3 position-relative">
                                    <div class="row">
                                        <div class="col-8 text-start">
                                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                <i class="ni ni-active-40 text-dark text-gradient text-lg opacity-10"
                                                    aria-hidden="true"></i>
                                            </div>
                                            <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                                {{ $file->errorLogs->count() }}
                                            </h5>
                                            <span class="text-white text-sm">Result Count Received After Prediction</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                @foreach ($charts as $chart)
                    <div class="col-md-6 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-4">{{ $chart['name'] }}</h6>
                                <div class="p-1">
                                    <canvas id="chart{{ $chart['id'] }}"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @include('layouts.footer2')
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        var options = {
            tooltips: {
                enabled: false
            },
            responsive: true,
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return percentage;
                    },
                    color: '#fff',
                }
            }
        };

        @foreach ($charts as $chart)
            const ctx{{ $chart['id'] }} = document.getElementById('chart{{ $chart['id'] }}').getContext('2d');

            // Create the pie chart
            new Chart(ctx{{ $chart['id'] }}, {
                type: 'pie',
                data: {
                    labels: @json($chart['labels']),
                    datasets: [{
                        data: @json($chart['values']),
                        backgroundColor: @json($chart['colors']),
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: options,
            });
        @endforeach
    </script>
@endsection
