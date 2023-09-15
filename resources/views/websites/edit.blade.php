@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper">

        </div>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h2>Add Website</h2>

                    </div>

                    <div class="card-body">
                        <form class="form" action="{{ route('websites.update',$website->id) }}" method="POST" >
                            @csrf
                            @method('PUT')
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
                                <label for="title" class="form-label">Add URL</label>
                                <input type="text" name="url" class="form-control" value="{{ $website->url }}" required>
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">Product URL</label>
                                <input type="text" name="product_url" class="form-control" value="{{ $website->product_url }}" required>
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">Title CSS Selector</label>
                                <input type="text" name="title" class="form-control" value="{{ $website->title }}">
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">Description Selector</label>
                                <input type="text" name="description" class="form-control"  value="{{ $website->description }}">
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">Price CSS Selector</label>
                                <input type="text" name="price" class="form-control"   value="{{ $website->price }}">
                            </div>


                            <div class="form-group">
                                <label for="title" class="form-label">Image CSS Selector</label>
                                <input type="text" name="image" class="form-control"  value="{{ $website->image }}">
                            </div>





                            <div class="form-group justify-content-end">
                                <button type="submit" class="btn btn-primary btn-default">Add URL</button>
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
