@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.histories.results', ['id' => $id]) }}" method="GET">
                                <div class="row">
                                    @foreach ($columns as $key => $column)
                                        <div class="col-md-4">
                                            <label for="start"><small
                                                    class="text-dark">{{ $column['name'] }}</small></label>
                                            <select class="form-control" name="{{ $key }}"
                                                id="{{ $key }}">
                                                <option value="">None</option>
                                                @foreach ($column['levels'] as $level)
                                                    <option value="{{ $level }}"
                                                        {{ request()[$key] == $level ? 'selected' : '' }}>
                                                        {{ $level }}</option>
                                                @endforeach
                                            </select>
                                            @error('start')
                                                <span class="text-danger"><small
                                                        class="text-xs">{{ $message }}</small></span>
                                            @enderror
                                        </div>
                                    @endforeach
                                    <div class="col-md-12 mt-3">
                                        <center>
                                            <button type="reset"
                                                class="btn btn-outline-danger pull-right mr-5">Clear</button>
                                            <button type="submit" class="btn btn-primary pull-right ml-5">Filter</button>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
                                                Information</th>
                                            @foreach ($columns as $key => $column)
                                                <th
                                                    class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    {{ $column['name'] }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @forelse ($data as $record)
                                            <tr>
                                                <td class="text-xs text-secondary mb-0">{{ $index }}</td>
                                                <td class="text-xs text-secondary mb-0"><b
                                                        class="text-danger">{{ $record->level }} :
                                                    </b>{{ $record->message }}</br></br><b class="text-info">Stacktrace :
                                                    </b>{{ $record->event_template }}</br></br><b
                                                        class="text-success">Suggestion :
                                                    </b>{{ $record->suggestion }}
                                                    <br />
                                                    <br />
                                                    <span class="btn badge badge-sm bg-gradient-info fetchai"
                                                        data-question="{{ $record->message }}">Fetch AI Suggestion</span>
                                                </td>
                                                @foreach ($columns as $key => $column)
                                                    <td class="text-xs text-secondary mb-0">{{ $record[$key] }}</td>
                                                @endforeach
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
            <div class="row justify-content-end">
                <div class="mt-4">
                    {{ $data->links() }}
                </div>
            </div>
            @include('layouts.footer2')
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.fetchai').click(function() {

                let conversation = [];

                const userMessage = $(this).data('question');

                if (userMessage === '') return;

                conversation.push({
                    role: 'user',
                    content: userMessage
                });

                $.ajax({
                    url: 'https://api.openai.com/v1/chat/completions',
                    type: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer {{ env('OPENAI_API_KEY') }}`
                    },
                    data: JSON.stringify({
                        model: 'gpt-3.5-turbo',
                        messages: conversation,
                        max_tokens: 150
                    }),
                    success: function(data) {
                        const reply = data.choices[0].message.content;
                        showInfoMessage(reply);
                    },
                    error: function(error) {
                        showWarning(error);
                    }
                });
            });
        });
    </script>
@endsection
