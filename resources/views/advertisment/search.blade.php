@extends('layout.app')
@section('title','Search')
@section('content')
<div class="row mt-5">
    <div class="col-md-12 text-end">
        <a href="{{ route('advertisment.add') }}" class="btn btn-info">Add Advertisment</a>
    </div>
    <div class="col-md-12 mt-5">
        <form method="POST" action="{{ route('advertisment.search') }}" id="search-advertisment">
            @csrf
            <div class="card">
                <div class="card-header text-center">Search Advertisment</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Search Address</label>
                        <input type="text" class="form-control" placeholder="Search here" name="search" id="search">
                    </div>
                    <input type="text" class="form-control d-none" name="lat" id="lat">
                    <input type="text" class="form-control d-none" name="lng" id="lng">
                    <div class="form-group">
                        <label>Radius</label>
                        <input type="text" class="form-control" placeholder="Radius" name="radius" id="radius">
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-danger clear-search">Clear</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12 text-center table-view">
    </div>
</div>
@endsection
@push('custom-styles')
<style>
    .error-help-block {
        color: red;
    }
</style>
@endpush
@push('custom-scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Advertisment\SearchRequest',"#search-advertisment") !!}
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{env('GOOGLE_MAP_API_KEY')}}&libraries=places"></script>
<script type="text/javascript" src="{{ asset('assets/js/advertisment/search.js') }}"></script>
@endpush