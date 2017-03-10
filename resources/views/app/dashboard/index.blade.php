@extends('layouts.app')

@section('content')
    <div class="row grid">
        <div class="col-md-3 grid-item">
            @include('app.dashboard.widgets.members_count')
        </div>
        <div class="col-md-3 grid-item">
            @include('app.dashboard.widgets.members_without_avatar')
        </div>
        <div class="col-md-3 grid-item">
            @include('app.dashboard.widgets.members_by_gender')
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(function() {
        new Chart($('#members-by-gender-chart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($membersByGender)) !!},
                datasets: [
                    {
                        data: {!! json_encode(array_values($membersByGender)) !!},
                        backgroundColor: [
                            "#FFCE56",
                            "#FF6384",
                            "#36A2EB"
                        ],
                        hoverBackgroundColor: [
                            "#FFCE56",
                            "#FF6384",
                            "#36A2EB"
                        ]
                    }]
            }
        });

        $('.grid').masonry({
            itemSelector: '.grid-item'
        });
    });
</script>
@endpush