@extends('layout.app')
@section('title','Add')
@section('content')
<div class="row mt-5">
    <div class="col-md-12 text-end">
        <a href="{{ route('advertisment.search') }}" class="btn btn-info">Search Advertisment</a>
    </div>
    <div class="col-md-12 mt-5">
        <form method="POST" action="{{ route('advertisment.save') }}" id="save-advertisment">
            @csrf
            <div class="card">
                <div class="card-header text-center">Add Advertisment</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name" id="name">
                    </div>

                    <div id="map"></div>
                    <input type="text" class="form-control d-none" name="lat" id="lat">
                    <input type="text" class="form-control d-none" name="lng" id="lng">
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-danger clear-search">Clear</button>
                </div>
            </div>
        </form>
    </div>


</div>
@endsection
@push('custom-styles')
<style>
    .error-help-block {
        color: red;
    }

    #map {
        height: 400px;
        margin-top: 20px;
    }
</style>
@endpush
@push('custom-scripts')
<script>
    var redirectURL = "{{ route('advertisment') }}";
</script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Advertisment\StoreRequest',"#save-advertisment") !!}

<script type="text/javascript" src="{{ asset('assets/js/advertisment/store.js') }}"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap"></script>
@endpush