<div class="panel">
    <div class="panel-heading">
        <h4 class="panel-title">{{ trans('labels.members_hometowns') }}</h4>
    </div>
    <div id="hometown-map" style="width:100%;height:750px;" data-coordinates="{{ \App\Models\Member::byActive()->withHometown()->get()->pluck('coordinates')->toJson() }}"></div>
</div>

@push('scripts')
<script src="{{ asset('js/markerclusterer.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}"></script>
<script type="application/javascript">
    $(window).on('load', function() {
        var $map = $('#hometown-map');
        function initMap() {
            var coords = $map.data('coordinates');
            var map = new google.maps.Map(document.getElementById('hometown-map'), {
                zoom: 4,
                maxZoom: 14,
                center: {
                    lat: 0,
                    lng: 0
                }
            });
            var bounds = new google.maps.LatLngBounds();
            var markers = coords.map(function(location, i) {
                bounds.extend(location);
                return new google.maps.Marker({
                    position: location
                });
            });
            var markerCluster = new MarkerClusterer(map, markers, {
                imagePath: '{{ asset('images/markercluster/m') }}'
            });
            map.fitBounds(bounds);
        }
        initMap();
    });
</script>
@endpush