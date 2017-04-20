<div id="activity-calendar"></div>

@push('scripts')
<script type="application/javascript">
    jQuery(window).on('load', function() {
        var $activityCalendar = jQuery('#activity-calendar');
        var eventColors = {
            danger: '#D9534F',
            warning: '#F0AD4E',
            success: '#1CAF9A',
            dark: '#1d2939'
        };
        function hasDateEvents(date) {
            var allEvents = [];
            allEvents = $activityCalendar.fullCalendar('clientEvents');
            var event = jQuery.grep(allEvents, function (v) {
                return +v.start === +date;
            });
            return event.length > 0;
        }
        $activityCalendar.fullCalendar({
            aspectRatio: 2.5,
            dayRender: function(date, $cell) {
                var start = moment($activityCalendar.fullCalendar('getView').start);
                var mDate = moment(date);
                if(!hasDateEvents(date) && mDate.isSame(start, 'month') && mDate.isBefore(moment())) {
                    jQuery.getJSON(BASE_URL+'/activity/'+mDate.format('YYYY-MM-DD'), function(data) {
                        var postColor = 'warning';
                        if(data.postsDay < data.postsAvg * 0.8) {
                            postColor = 'danger';
                        } else if(data.postsDay > data.postsAvg * 1.2) {
                            postColor = 'success';
                        }
                        if(data.postsDay == 0) {
                            postColor = 'dark';
                        }
                        var commentColor = 'warning';
                        if(data.commentsDay < data.commentsAvg * 0.8) {
                            commentColor = 'danger';
                        } else if(data.commentsDay > data.commentsAvg * 1.2) {
                            commentColor = 'success';
                        }
                        if(data.commentsDay == 0) {
                            commentColor = 'dark';
                        }
                        if(!hasDateEvents(date)) {
                            $activityCalendar.fullCalendar('addEventSource', {
                                events: [
                                    {
                                        title: 'posts ' + data.postsDay,
                                        start: mDate,
                                        allDay: true,
                                        color: eventColors[postColor]
                                    },
                                    {
                                        title: 'comments ' + data.commentsDay,
                                        start: mDate,
                                        allDay: true,
                                        color: eventColors[commentColor]
                                    }
                                ]
                            });
                        }
                    });
                }
            }
        });
    });
</script>
@endpush