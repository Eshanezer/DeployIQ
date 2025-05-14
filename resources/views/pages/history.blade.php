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
                                <form action="{{ route('admin.histories.index') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="start"><small class="text-dark">Start
                                                    Date{!! required_mark() !!}</small></label>
                                            <input value="{{ request()->start ?? '' }}" type="datetime-local" name="start"
                                                id="start" class="form-control" placeholder="Start Date">
                                            @error('start')
                                                <span class="text-danger"><small
                                                        class="text-xs">{{ $message }}</small></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end"><small class="text-dark">End
                                                    Date{!! required_mark() !!}</small></label>
                                            <input value="{{ request()->end ?? '' }}" type="datetime-local" name="end"
                                                id="end" class="form-control" placeholder="End Date">
                                            @error('end')
                                                <span class="text-danger"><small
                                                        class="text-xs">{{ $message }}</small></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <center>
                                                <button type="reset"
                                                    class="btn btn-outline-danger pull-right mr-5">Clear</button>
                                                <button type="submit"
                                                    class="btn btn-primary pull-right ml-5">Filter</button>
                                            </center>
                                        </div>
                                    </div>
                                </form>
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
                                                    File Name</th>
                                                <th
                                                    class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Predicted At</th>
                                                <th
                                                    class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $record)
                                                <tr>
                                                    <td class="text-xs text-secondary mb-0">{{ $record->name }}</td>
                                                    <td class="text-xs text-secondary mb-0">{{ $record->created_at }}</td>
                                                    <td class="text-xs text-secondary mb-0 text-end">
                                                        <a href="{{  route('admin.histories.results', ['id' => $record->id]) }}" class="btn btn-sm btn-danger show-results">Show Result</a>
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
