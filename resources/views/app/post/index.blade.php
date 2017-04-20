@extends('layouts.app')

@section('content')
    {!! $posts->render() !!}
    <div class="row grid" id="posts">
        @foreach($posts as $post)
        <div class="col-xs-12 col-md-4 grid-item">
            <article class="panel panel-default post">
                <header class="padding5">
                    <a href="https://facebook.com/{{ $post->from_id }}" target="_blank">
                        <strong>{{ $post->from_name }}</strong>
                    </a>
                    <a href="https://facebook.com/{{ $post->id }}" target="_blank">
                        <time class="text-muted pull-right" datetime="{{ $post->created_at }}">{{ $post->created_at }}</time>
                    </a>
                </header>
                <section class="twemoji-support padding5">
                    {!! nl2br($post->message) !!}
                </section>
                @if(!empty($post->picture))
                    <img class="img-responsive" src="{{ $post->picture }}" />
                @endif
                <footer class="padding5">
                    <ul class="list-inline nomargin nopadding">
                        <li data-toggle="collapse" href="#post-comments-{{ $post->id }}">
                            <i class="icon fa fa-comments-o"></i>
                            {{ $post->comments()->count() }}
                            {{ trans('labels.comments') }}
                        </li>
                    </ul>
                </footer>
                <div id="post-comments-{{ $post->id }}" class="post-comments collapse padding5" data-loaded="false" data-post-id="{{ $post->id }}">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                    </div>
                </div>
            </article>
        </div>
        @endforeach
    </div>
    {!! $posts->render() !!}
@endsection

@push('scripts')
<script src="//twemoji.maxcdn.com/2/twemoji.min.js?2.2.3"></script>
<script type="application/javascript">
    moment.locale(navigator.language);

    moment.fn.fromNowOrCalendar = function (absolute, format) {
        if (Math.abs(moment().diff(this)) > 1000 * 60 * 60 * 3) {
            return this.calendar(null, {
                sameElse: format
            });
        }
        return this.fromNow(absolute);
    };

    function parseTwemoji($elem) {
        var text = $elem.html();
        var parsed = twemoji.parse(text, {
            folder: 'svg',
            ext: '.svg'
        });
        if(parsed.trim() == '') {
            $elem.html(text);
        } else {
            $elem.html(parsed);
        }
    }

    function parseTime($elem)
    {
        var $times = $elem.find('time').not('.parsed');
        $times.each(function() {
            var $this = jQuery(this);
            var datetime = moment.utc($this.attr('datetime'));
            $this.text(datetime.local().fromNowOrCalendar(false, 'L LT'));
            $this.addClass('parsed');
        });
    }

    jQuery(window).on('load', function() {
        parseTime(jQuery('#posts'));
        jQuery('.twemoji-support').each(function() {
            var $this = jQuery(this);
            parseTwemoji($this);
        });

        jQuery('.post-comments').on('show.bs.collapse', function() {
            var $this = jQuery(this);
            if(!$this.data('loaded')) {
                $this.load(BASE_URL+'/post/comments/'+$this.data('post-id'), function() {
                    parseTime($this);
                    parseTwemoji($this);
                    $this.data('loaded', true);
                    layoutMasonry();
                });
            }
        });

        jQuery('.post-comments').on('shown.bs.collapse hidden.bs.collapse', function() {
            layoutMasonry();
        });
    });
</script>
@endpush