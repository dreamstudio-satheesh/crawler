@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper">

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h2>websites</h2>

                        <a href="{{ url('websites/create') }}" class="btn btn-outline-primary">
                            <i class=" mdi mdi-plus"></i> Create
                        </a>
                    </div>

                    <div class="card-body">
                        <table id="basic-data-table" class="table nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($websites as $website)
                                    <tr>
                                        <th scope="row"><a href="#" class="fw-semibold">#{{ $website->id }}</a>
                                        </th>
                                        <td>{{ $website->url }}</td>
                                        <td>

                                            <div class="btn-group mr-2 mb-3">
                                                <a class="mb-1 btn btn-sm btn-primary"
                                                    href="{{ url('product_links') }}/{{ $website->id }}">Product Links</a>
                                            </div>
                                            <div class="btn-group mr-2 mb-3">
                                                <a class="mb-1 btn btn-sm btn-primary"
                                                    href="{{ url('product_list') }}/{{ $website->id }}">Products</a>
                                            </div>
                                            <div class="btn-group mb-3">
                                                <form action="{{ route('websites.destroy', $website->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="mb-1 btn btn-sm btn-danger">Remove</button>
                                                </form>
                                            </div>
                    </div>
                    </td>

                    </tr>
                    @endforeach

                    </tbody>
                    </table>

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
