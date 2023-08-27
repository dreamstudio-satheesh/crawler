@extends('layouts.admin')

@section('content')

            <div class="content">
                <div class="breadcrumb-wrapper">
                    <h1>Badges</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <span class="mdi mdi-home"></span>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                components
                            </li>
                            <li class="breadcrumb-item" aria-current="page">badge</li>
                        </ol>
                    </nav>
                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="card card-default">
                            <div class="card-header justify-content-between card-header-border-bottom">
                                <h2>Badges </h2>
                            </div>
                            <div class="card-body">
                                <p class="mb-5">Badges scale to match the size of the immediate parent element by using
                                    relative font sizing and <code>em</code> units. Read bootstrap documentaion for <a
                                        href="https://getbootstrap.com/docs/4.4/components/badge/" target="_blank"> more
                                        details.</a></p>
                                <h1 class="mb-2 text-dark">Heading

                                </h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-default">
                            <div class="card-header card-header-border-bottom">
                                <h2>Contextual Variations </h2>
                            </div>
                            <div class="card-body">
                                <p class="mb-5">Add any of the below mentioned modifier classes to change the appearance
                                    of a badge. Read bootstrap documentaion for <a
                                        href="https://getbootstrap.com/docs/4.4/components/badge/" target="_blank"> more
                                        details.</a></p>
                                <span class="mb-2 mr-2 badge badge-primary">Primary</span>

                                <span class="mb-2 mr-2 badge badge-dark">Dark</span>
                            </div>
                        </div>

                    </div>
                </div>
@endsection
