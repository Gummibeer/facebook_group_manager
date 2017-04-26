@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('app.profile.update', $member->getKey()) }}">
        {{ csrf_field() }}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('labels.profile') }}</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ trans('labels.full_name') }}</label>
                        <input type="text" class="form-control" value="{{ $member->full_name }}" readonly />
                    </div>
                    <div class="col-md-2">
                        <label>{{ trans('labels.facebook_id') }}</label>
                        <input type="text" class="form-control" value="{{ $member->id }}" readonly />
                    </div>
                    <div class="col-md-1">
                        <label for="select_gender">{{ trans('labels.gender') }}</label>
                        <select class="form-control" id="select_gender" name="gender">
                            @foreach(app(\App\Libs\Gender::class)->getLabels() as $id => $name)
                                <option value="{{ $id }}" @if($member->getAttributes()['gender'] == $id) selected @endif>{{ trans('labels.'.$name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for="select_age">{{ trans('labels.age') }}</label>
                        <input type="number" class="form-control" id="select_age" name="age" value="{{ $member->getAttributes()['age'] }}" />
                    </div>
                    <div class="col-md-3">
                        <label for="select_hometown">{{ trans('labels.hometown') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="select_hometown" name="hometown" value="{{ $member->hometown_address }}" />
                            <span class="input-group-addon">
                                <i class="icon fa fa-home"></i>
                            </span>
                            <div id="geocomplete_details">
                                <input data-geo="lat" name="hometown_lat" type="hidden" value="{{ $member->hometown_lat }}">
                                <input data-geo="lng" name="hometown_lng" type="hidden" value="{{ $member->hometown_lng }}">
                                <input data-geo="formatted_address" name="hometown_address" type="hidden" value="{{ $member->hometown_address }}">
                                <input data-geo="place_id" name="hometown_place_id" type="hidden" value="{{ $member->hometown_place_id }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group pull-right">
                    <a href="{{ route('app.dashboard.index') }}" class="btn btn-default">
                        {{ trans('labels.close') }}
                    </a>
                    <button type="submit" class="btn btn-warning">
                        {{ trans('labels.save') }}
                    </button>
                </div>
            </div>
            <div id="map" style="width:100%;height:400px;" data-coordinates="{{ json_encode($member->coordinates) }}"></div>
        </div>
    </form>
@endsection

@push('scripts')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>
<script type="application/javascript">
    $(window).on('load', function() {
        $("#select_hometown")
            .geocomplete({
                types: ['(regions)'],
                details: "#geocomplete_details",
                detailsAttribute: "data-geo"
            })
            .on('geocode:result', function() {
                var $input = $(this);
                var $group = $input.parents('.input-group').first();
                var $icon = $group.find('.icon');
                $group.removeClass('has-error').addClass('has-success');
                $icon.removeClass('fa-home').removeClass('fa-ban').addClass('fa-check');
            })
            .on('change', function() {
                var $input = $(this);
                var $group = $input.parents('.input-group').first();
                var $icon = $group.find('.icon');
                var $details = $group.find('#geocomplete_details');
                var $address = $details.find('[name=formatted_address]');
                if($input.val() != $address.val()) {
                    $details.find('input').each(function() {
                        $(this).val('');
                    });
                    $group.removeClass('has-success').addClass('has-error');
                    $icon.removeClass('fa-home').removeClass('fa-check').addClass('fa-ban');
                }
                if($input.val() == '') {
                    $details.find('input').each(function() {
                        $(this).val('');
                    });
                    $group.removeClass('has-success').removeClass('has-error');
                    $icon.addClass('fa-home').removeClass('fa-check').removeClass('fa-ban');
                }
            });

        var $map = $('#map');
        function initMap() {
            var coords = $map.data('coordinates');
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: coords
            });
            if(coords.lat != 0 && coords.lng != 0) {
                new google.maps.Marker({
                    position: coords,
                    map: map
                });
            }
        }
        initMap();
    });
</script>
@endpush