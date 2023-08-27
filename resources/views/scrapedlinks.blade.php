@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper">

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h2>Product links </h2>
                    </div>

                    <div class="card-body">

                        @if (count($scrapedlinks))
                            <table id="basic-data-table" class="table nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scrapedlinks as $scrapedlinks)
                                        <tr>
                                            <th scope="row"><a href="#"
                                                    class="fw-semibold">#{{ $scrapedlinks->id }}</a>
                                            </th>
                                            <td>{{ $scrapedlinks->url }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            <h1>Product links not found</h1>
                            <br>
                            <div class="d-flex justify-content-end mt-5">
                                <a href="{{ url('scrape_products')}}/{{ Request::segment(2) }}" class="btn btn-outline-primary mb-2 btn-pill"> Run Command</a>
                            </div>
                        @endif



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
