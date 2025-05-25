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
                                                    class="btn btn-outline-danger pull-right mr-5">Clear
                                            </button>
                                            <button type="submit" class="btn btn-primary pull-right ml-5">Filter
                                            </button>
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
                                            #
                                        </th>
                                        <th
                                            class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Information
                                        </th>
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
                                            <!-- Row index -->
                                            <td class="align-middle text-center text-muted small fw-semibold">
                                                {{ $index }}
                                            </td>

                                            <!-- Main content: Level, Message, Stacktrace, Suggestion, AI Button -->
                                            <td class="align-middle">
                                                <div class="mb-2">
                                                  <span class="badge
                                                    {{ $record->level === 'ERROR' ? 'bg-danger'
                                                      : ($record->level === 'WARN' ? 'bg-warning text-dark'
                                                      : 'bg-info') }}">
                                                    {{ $record->level }}
                                                  </span>
                                                    <span class="fw-bold ms-2">{{ $record->message }}</span>
                                                </div>

                                                <div class="mb-2">
                                                    <strong class="text-info small">Stacktrace:</strong>
                                                    <pre
                                                        class="bg-light p-2 rounded small text-muted mt-1 mb-0">{{ $record->event_template }}</pre>
                                                </div>

                                                <div class="mb-2">
                                                    <strong class="text-success small">Suggestion:</strong>
                                                    <span class="text-secondary small">{{ $record->suggestion }}</span>
                                                </div>

                                                <div>
                                                    <button
                                                        class="btn btn-sm btn-outline-info mt-2 fetchai"
                                                        data-question="{{ $record->message . ':' . $record->event_template }}">
                                                        <i class="fas fa-robot me-1"></i> Fetch AI Suggestion
                                                    </button>
                                                </div>
                                            </td>

                                            <!-- Other table columns (e.g. Severity, Impact, Tags, etc.) -->
                                            @foreach ($columns as $key => $column)
                                                <td class="align-middle text-center small text-muted">
                                                    {{ $record[$key] }}
                                                </td>
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
            // ✅ HTML Escaper (safe fallback to avoid using lodash)
            function escapeHtml(text) {
                return text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;");
            }

            $('.fetchai').click(async function () {
                const userMessage = $(this).data('question');
                if (!userMessage || userMessage.trim() === '') return;

                const prompt = `
                        I’m encountering the following error:

                        \`\`\`
                        ${userMessage}
                        \`\`\`

                        Please provide:
                        1. **Diagnosis** – Why this error happens.
                        2. **How to Investigate** – What to check or inspect.
                        3. **Possible Fixes** – Suggested solutions or code changes.
                        4. **Best Practices** – How to avoid this in the future.
                        `;

                // ✅ Show loading modal
                Swal.fire({
                    title: 'Analyzing error...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                try {
                    const response = await $.ajax({
                        url: 'https://api.openai.com/v1/chat/completions',
                        type: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer {{ env('OPENAI_API_KEY') }}` // set this server-side in a script tag
                        },
                        data: JSON.stringify({
                            model: 'gpt-3.5-turbo',
                            messages: [{ role: 'user', content: prompt }],
                            max_tokens: 400,
                            temperature: 0.4
                        })
                    });

                    const reply = response.choices[0].message.content;

                    // ✅ Show final result modal with Prism highlighting
                    Swal.fire({
                        title: '<i class="fas fa-robot me-2"></i> AI-Powered Suggestion',
                        html: `
                                <div class="text-start" style="max-height:60vh; overflow-y:auto; font-family: Menlo, monospace; font-size: 0.85rem;">
                                  <section class="mb-4">
                                    <h6><strong>🩺 Diagnosis</strong></h6>
                                    <p>${escapeHtml(reply.match(/1\.\s\*\*Diagnosis\*\*:(.*?)2\.\s\*\*/s)?.[1] || 'Not found.')}</p>
                                  </section>
                                  <section class="mb-4">
                                    <h6><strong>🔍 How to Investigate</strong></h6>
                                    <pre class="bg-light p-2 rounded">${escapeHtml(reply.match(/2\.\s\*\*How to Investigate\*\*:(.*?)3\.\s\*\*/s)?.[1] || 'Not found.')}</pre>
                                  </section>
                                  <section class="mb-4">
                                    <h6><strong>🛠 Possible Fixes</strong></h6>
                                    <pre class="bg-light p-2 rounded">${escapeHtml(reply.match(/3\.\s\*\*Possible Fixes\*\*:(.*?)4\.\s\*\*/s)?.[1] || 'Not found.')}</pre>
                                  </section>
                                  <section>
                                    <h6><strong>✅ Best Practices</strong></h6>
                                    <pre class="bg-light p-2 rounded">${escapeHtml(reply.match(/4\.\s\*\*Best Practices\*\*:(.*)/s)?.[1] || 'Not found.')}</pre>
                                  </section>
                                </div>
                              `,
                        width: 900,
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-copy"></i> Copy Full Text',
                        cancelButtonText: 'Close',
                        didOpen: () => {
                            // Optional: You could highlight syntax here if you're using Prism.js
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            navigator.clipboard.writeText(reply);
                            Swal.fire({
                                icon: 'success',
                                title: 'Copied!',
                                timer: 1000,
                                showConfirmButton: false
                            });
                        }
                    });

                } catch (err) {
                    console.error('OpenAI Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'AI Request Failed',
                        text: err.responseJSON?.error?.message || err.statusText || 'Unexpected error.'
                    });
                }
            });
        });
    </script>
@endsection
