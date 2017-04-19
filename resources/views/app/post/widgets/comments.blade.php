<div>
    @forelse($comments as $comment)
        @if(!empty(trim($comment->message)))
            <div class="media nomargin">
                <div class="media-left pull-left">
                    <img class="media-object" src="{{ (new \App\Libs\Facebook())->getAvatar($comment->from_id) }}" width="48" height="48" />
                </div>
                <div class="media-body">
                    <header>
                        <a href="https://facebook.com/{{ $comment->from_id }}" target="_blank">
                            <strong>{{ $comment->from_name }}</strong>
                        </a>
                        <span class="text-muted pull-right">{{ $comment->created_at }}</span>
                    </header>
                    <section class="twemoji-support">
                        {!! nl2br($comment->message) !!}
                    </section>
                </div>
            </div>
        @endif
    @empty
        <div class="alert alert-warning nomargin padding5">
            {{ trans('alerts.no_comments') }}
        </div>
    @endforelse
</div>