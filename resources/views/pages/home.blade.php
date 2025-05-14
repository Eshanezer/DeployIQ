@extends('layouts.app')

@section('content')
    <style>
        .bg-danger-light {
            background-color: #FCE4EC;
        }
    </style>

    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @if (doPermitted('//histories'))
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="card">
                                    <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                                    <div class="card-body p-3 position-relative">
                                        <div class="row">
                                            <div class="col-8 text-start">
                                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                    <i class="ni ni-circle-08 text-dark text-gradient text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                                    {{ $logReportCount }}
                                                </h5>
                                                <span class="text-white text-sm">Recorded Log Report Count</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
                                <div class="card">
                                    <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                                    <div class="card-body p-3 position-relative">
                                        <div class="row">
                                            <div class="col-8 text-start">
                                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                    <i class="ni ni-active-40 text-dark text-gradient text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                                    {{ $submittedReportCount }}
                                                </h5>
                                                <span class="text-white text-sm">Submitted Log Report Count</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="card">
                                    <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                                    <div class="card-body p-3 position-relative">
                                        <div class="row">
                                            <div class="col-8 text-start">
                                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                    <i class="ni ni-cart text-dark text-gradient text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                                    {{ $approvedReportCount }}
                                                </h5>
                                                <span class="text-white text-sm">Approved Log Report Count</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
                                <div class="card">
                                    <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                                    <div class="card-body p-3 position-relative">
                                        <div class="row">
                                            <div class="col-8 text-start">
                                                <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                                    <i class="ni ni-like-2 text-dark text-gradient text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                                    {{ $predictedReportCount }}
                                                </h5>
                                                <span class="text-white text-sm">Predicted Log Report Count</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($charts))
                <div class="row my-4">
                    <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                    <div class="col-lg-6 col-7">
                                        <h6>Latest Error Log Statistics</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="row">
                                    @foreach ($charts as $chart)
                                        <div class="col-md-4 mt-2">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <div class="p-1">
                                                        <canvas id="chart{{ $chart['id'] }}"></canvas>
                                                        <small class="mt-4">{{ $chart['name'] }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row my-4">
                    <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                    <div class="col-lg-6 col-7">
                                        <h6>Latest Recorded Error Logs</h6>
                                        <p class="text-sm mb-0">
                                            <i class="fa fa-check text-info" aria-hidden="true"></i>
                                            <span class="font-weight-bold ms-1">{{ $predictedReportCountForThisMonth }}
                                                predicted</span> this month
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    File Name</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Error Log</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Predicted CSV</th>
                                                <th
                                                    class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (array_slice($data, -5) as $log)
                                                @php
                                                    $exist = $logsData->where('name', $log)->first();
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1 pl-3">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $log }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-xs font-weight-bold">
                                                            @if ($exist && $exist->path)
                                                                <a target="_blank"
                                                                    class="btn btn-link text-info text-gradient px-3 mb-0"
                                                                    @if ($exist && $exist->path) href="{{ $exist->path }}" @endif>Download</a>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        @if ($exist && $exist->status == 'predicted')
                                                            <a target="_blank"
                                                                class="btn btn-link text-info text-gradient px-3 mb-0"
                                                                @if ($exist && $exist->status == 'predicted') href="{{ $exist->predicted_path }}" @endif>Download</a>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        @if ($exist)
                                                            @if ($exist->status == 'submitted')
                                                                <span class="badge badge-sm bg-gradient-info">Submitted for
                                                                    AI</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-sm bg-gradient-success">Predicted</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
