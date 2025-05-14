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
                    @include('layouts.flash')
                    <div class="col-md-12 mb-5">
                        <div class="card">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0 w-100" id="usersTable">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Disease</th>
                                                <th
                                                    class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Recorded At</th>
                                                <th
                                                    class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $record)
                                                <tr>
                                                    <td class="text-xs text-secondary mb-0">{{ $record->disease }}</td>
                                                    <td class="text-xs text-secondary mb-0">{{ $record->created_at }}</td>
                                                    <td class="text-xs text-secondary mb-0 text-end">
                                                        <button data-image="{{ $record->image }}"
                                                            @if ($record->solutionData) data-id="{{ $record->solutionData->id }}" @endif
                                                            class="btn btn-sm btn-danger show-results">Show Result</button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-danger text-xs text-center">No Records
                                                        Found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="mt-4">
                                        {{ $data->links() }}
                                    </div>
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
