@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form id="getWeatherForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="search">City or zip code</label>
                            <input type="text" name="search" value="{{old('search')}}" id="search"
                                   class="form-control @error('search') is-invalid @enderror">
                            <div class="alert alert-danger" style="display: none" id="searchErrorMsg"></div>
                            @error('search')
                            <div class="alert alert-danger" id="searchErrorMsg">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col align-self-center">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4" id="location">
                <form id="saveLocation">
                    @csrf
                    <div class="row">
                        <div class="col align-self-center">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4" id="saved_locations_label">
                <label>
                    Saved locations
                </label>
                <select name="saved_locations" id="saved_locations" class="form-control">
                    <option disabled selected>Select saved location</option>
                </select>
            </div>
        </div>
        <div class="row" id="weather_table">

        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        let savedLocations = [];

        function getValue(data, option) {
            let temp = option.value;
            let specifiedTemp = data[temp];
            $('.temp').text(specifiedTemp);
        }

        $(document).ready(function () {
            $("#location").hide();
            $("#saved_locations_label").hide();
            $("#weather_table").hide();
        });

        /**
         * get location for entered city name or zip code
         */
        $('#getWeatherForm').on('submit', function (e) {
            e.preventDefault();
            $('#searchErrorMsg').empty();
            $('#searchErrorMsg').hide();
            let form = $('#getWeatherForm');
            let formData = form.serialize();
            let url = '{{ route("getWeather") }}';
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: formData,
                success: function (response) {
                    $("#weather_table").show();
                    $("#location").show();
                    $("#weather_table").html(response.data);
                },
                error: function (response) {
                    $('#searchErrorMsg').text(Object.values(response.responseJSON.errors.search));
                    $('#searchErrorMsg').show();
                },
            });
        });


        /**
         * save location
         *
         */
        $('#saveLocation').on('submit', function (e) {
            e.preventDefault();
            let location = $("#search").val();
            if (!savedLocations.includes(location)) {
                savedLocations.push(location);
                $("#saved_locations").append(`
                <option value='` + location + `'>` + location + `</option>
            `);
            }
            $("#saved_locations_label").show();
        });

        /**
         * get weather for saved location
         *
         */
        $('#saved_locations').on('change', function (e) {
            e.preventDefault();
            let location = $(this).val();
            $("#search").val(location);
            $("#search").text(location);
            $('#getWeatherForm').submit();
        });


    </script>
@endpush
