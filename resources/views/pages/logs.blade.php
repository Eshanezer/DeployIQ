@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                @include('layouts.flash')
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 w-100" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                #</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                File Name</th>
                                            <th
                                                class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @forelse ($data as $record)
                                            <tr>
                                                <td class="text-xs text-secondary mb-0">{{ $index }}</td>
                                                <td class="text-xs text-secondary mb-0">{{ $record }}</td>
                                                <td class="text-xs text-secondary mb-0 text-end">
                                                    @php
                                                        $exist = $logsData->where('name', $record)->first();
                                                    @endphp
                                                    @if ($exist)
                                                        @if ($exist->status == 'submitted')
                                                            <span class="badge badge-sm bg-gradient-info">Submitted for
                                                                AI</span>
                                                        @else
                                                            <a href="{{ route('admin.logs.more-info', ['filename' => $record]) }}"
                                                                class="btn btn-sm btn-success">More Information</a>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('admin.logs.predict', ['filename' => $record]) }}"
                                                            class="btn btn-sm btn-warning">Submit For Prediction</a>
                                                    @endif

                                                </td>
                                            </tr>

                                            @php
                                                $index++;
                                            @endphp
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-danger text-xs text-center">No Records Found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer2')
        </div>
    </main>
@endsection
