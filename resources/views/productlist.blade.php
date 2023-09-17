@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="breadcrumb-wrapper">

        </div>
        <div class="row">
            @if (count($products))

            {{ $products->links() }}
             
                @foreach ($products as $item)
                    <div class="col-lg-8 col-xl-6">
                        <div class="card card-default p-4">
                            <a href="javascript:0" class="media text-secondary" data-toggle="modal"
                                data-target="#modal-contact">
                                <img width="80px" src="{{ url('')}}/{{ $item->image }}" class="mr-3 img-fluid rounded" alt="Avatar Image">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-2 text-dark">{{ $item->name }}</h5>
                                    <ul class="list-unstyled">
                                        <li class="d-flex mb-1">
                                            <i class="mdi mdi-map mr-1"></i>
                                            <span>{{ $item->price }}</span>
                                        </li>
                                        <li class="d-flex mb-1">
                                            
                                            <p>{{ substr($item->description, 0, 150)  }}...</p>
                                        </li>
                                        
                                    </ul>

                                </div>
                            </a>

                        </div>
                    </div>
                @endforeach

    
    @else
        <h1>Products not found</h1>
        <br>
        @endif
        </div>

        {{--  <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h2>Product List </h2>
                    </div>

                    <div class="card-body">

                        @if (count($products))
                            <table id="basic-data-table" class="table nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $item)
                                        <tr>
                                            <th scope="row"><a href="#"
                                                    class="fw-semibold">#{{ $item->id }}</a>
                                            </th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            <h1>Products  not found</h1>
                            <br>
                           
                        @endif



                    </div>
                </div> --}}
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
