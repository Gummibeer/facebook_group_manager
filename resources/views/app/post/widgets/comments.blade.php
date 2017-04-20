<div class="media-list">
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
                        <time class="text-muted pull-right" datetime="{{ $comment->created_at }}">{{ $comment->created_at }}</time>
                    </header>
                    <section class="twemoji-support">
                        {!! nl2br($comment->message) !!}
                        @if(!empty($comment->picture))
                            <img class="img-responsive" src="{{ $comment->picture }}" />
                        @endif
                    </section>

                    @foreach($comment->comments as $subcomment)
                    <div class="media nomargin">
                        <div class="media-left pull-left">
                            <img class="media-object" src="{{ (new \App\Libs\Facebook())->getAvatar($subcomment->from_id) }}" width="48" height="48" />
                        </div>
                        <div class="media-body">
                            <header>
                                <a href="https://facebook.com/{{ $subcomment->from_id }}" target="_blank">
                                    <strong>{{ $subcomment->from_name }}</strong>
                                </a>
                                <time class="text-muted pull-right" datetime="{{ $subcomment->created_at }}">{{ $subcomment->created_at }}</time>
                            </header>
                            <section class="twemoji-support">
                                {!! nl2br($subcomment->message) !!}
                                @if(!empty($subcomment->picture))
                                    <img class="img-responsive" src="{{ $subcomment->picture }}" />
                                @endif
                            </section>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
    @empty
        <div class="alert alert-warning nomargin padding5">
            {{ trans('alerts.no_comments') }}
        </div>
    @endforelse
</div>