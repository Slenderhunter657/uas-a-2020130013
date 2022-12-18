@extends('layouts.master')
@section('title', 'Main Page')
@push('css_after')
    <style>
        td {
            max-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush
@section('content')

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    {{-- Menu Count --}}

    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Number of Menus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center">{{ $menuCount }}</th>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center">
                        <h4>
                            Wondering what's on the menu?
                        </h4>
                        <a class="btn btn-primary" href="{{ route('menus.index') }}" role="button">Menu List</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Horizontal Table Separator --}}

        <div class="col-md-2 mb-3">
        </div>

        {{-- Order Count --}}

        <div class="col-md-5 mb-3">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Number of Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center">{{ $orderCount }}</th>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center">
                        <h4>
                            Wondering what's in there?
                        </h4>
                        <a class="btn btn-primary" href="{{ route('order.index') }}" role="button">Order List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
