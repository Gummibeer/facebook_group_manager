<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">{{ trans('labels.members_by_gender') }}</h4>
    </div>
    <div class="panel-body">
        <canvas id="members-by-gender-chart"></canvas>
    </div>
</div>

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