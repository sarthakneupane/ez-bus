@extends('admin.layouts.master')

@section('title', 'Seat Formats')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Seat Formats</div>
                <a href="{{ route('admin.seat_formats.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Seat Format
                </a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Left Columns</th>
                                <th>Right Columns</th>
                                <th>Rows</th>
                                <th>View Layout</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formats as $index => $format)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $format->column_left }}</td>
                                    <td>{{ $format->column_right }}</td>
                                    <td>{{ $format->rows }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-seats" data-id="{{ $format->id }}">
                                            View Seats
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="seatLayoutModal" tabindex="-1" aria-labelledby="seatLayoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seat Layout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="seat-layout-body">
                    <p class="text-muted">Loading seat layout...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = new bootstrap.Modal(document.getElementById('seatLayoutModal'));
        const seatBody = document.getElementById('seat-layout-body');

        document.querySelectorAll('.view-seats').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                seatBody.innerHTML = '<p class="text-muted">Loading seat layout...</p>';
                modal.show();

                fetch(`/admin/seat_formats/${id}/layout`)
                    .then(response => response.text())
                    .then(html => {
                        seatBody.innerHTML = html;
                    })
                    .catch(() => {
                        seatBody.innerHTML = '<p class="text-danger">Failed to load layout.</p>';
                    });
            });
        });
    });
</script>
@endpush
