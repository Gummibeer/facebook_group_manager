<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">{{ trans('labels.members_by_approved') }}</h4>
    </div>
    <div class="panel-body">
        <canvas id="members-by-approved-chart"></canvas>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $(function() {
        new Chart($('#members-by-approved-chart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($membersByApproved)) !!},
                datasets: [
                    {
                        data: {!! json_encode(array_values($membersByApproved)) !!},
                        backgroundColor: [
                            "#D9534F",
                            "#1CAF9A"
                        ],
                        hoverBackgroundColor: [
                            "#D9534F",
                            "#1CAF9A"
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