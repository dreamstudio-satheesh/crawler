@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper">

        </div>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h2>Tender Document</h2>

                    </div>

                    <div class="card-body">
                        <form class="form" action="{{ route('tenders.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="mb-3">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">Estimate Amoount</label>
                                <input type="text" name="estimate_amount" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">Tender Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">Closing Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="document" class="form-label">Upload Documents</label>
                                <input type="file" name="document" class="form-control"
                                    accept="application/msword, application/vnd.ms-excel,
                                        text/plain, application/pdf">
                            </div>





                            <div class="form-group justify-content-end">
                                <button type="submit" class="btn btn-primary btn-default">Upload Document</button>
                            </div>


                        </form>
                        <br><br><br>

                    </div>
                </div>
            </div>
        @endsection

        @push('css')
            <link href="assets/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">
        @endpush

        @push('scripts')
            <script src="assets/plugins/data-tables/jquery.datatables.min.js"></script>
            <script src="assets/plugins/data-tables/datatables.bootstrap4.min.js"></script>
            <script>
                jQuery(document).ready(function() {
                    jQuery('#basic-data-table').DataTable({
                        "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
                    });
                });
            </script>
        @endpush
