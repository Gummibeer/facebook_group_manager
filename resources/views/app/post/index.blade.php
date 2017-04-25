@extends('layouts.app')

@section('content')
    <div>
        <div class="row" id="posts" data-url="{{ route('api.post.index') }}" data-label-comments="{{ trans('labels.comments') }}">
            <div class="col-xs-12 col-md-4 grid-item"></div>
        </div>
    </div>

    <script id="template-post" type="text/x-handlebars-template">
        <?php include(resource_path('views/app/post/handlebars/post.hbs')); ?>
    </script>
    <script id="template-comment" type="text/x-handlebars-template">
        <?php include(resource_path('views/app/post/handlebars/comment.hbs')); ?>
    </script>
@endsection

@push('scripts')
<script src="//twemoji.maxcdn.com/2/twemoji.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.min.js"></script>
<script src="//unpkg.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
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

    String.prototype.nl2br = function() {
        return this.replace(/\n/g, "<br />");
    };

    jQuery(window).on('load', function () {
        function parseTwemoji($elem) {
            var text = $elem.html();
            var emoticons = {
                ':D': '\uD83D\uDE04',
                ':*': '\uD83D\uDE18',
                '<3': '\u2764',
                '&lt;3': '\u2764',
                ';)': '\uD83D\uDE09',
                ':)': '\uD83D\uDE0A',
                ':-)': '\uD83D\uDE0A',
                ':P': '\uD83D\uDE1B'
            };
            $.each(emoticons, function(key, value) {
                key = key.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
                text = text.replace(new RegExp(key, 'g'), value);
            });
            var parsed = twemoji.parse(text, {
                folder: 'svg',
                ext: '.svg'
            });
            if (parsed.trim() == '') {
                $elem.html(text);
            } else {
                $elem.html(parsed);
            }
        }

        function parseTime($elem) {
            var $times = $elem.find('time').not('.parsed');
            $times.each(function () {
                var $this = jQuery(this);
                var datetime = moment.utc($this.attr('datetime'));
                $this.text(datetime.local().fromNowOrCalendar(false, 'L LT'));
                $this.addClass('parsed');
            });
        }

        function parseSentiment($elem) {
            var $sentiment = $elem.find('.sentiment');
            var sentiment = $sentiment.data('sentiment');
            var $icon = $('<i class="icon fa"></i>');
            if(sentiment > 0) {
                $sentiment.addClass('text-success');
                $icon.addClass('fa-chevron-up');
            } else if(sentiment < 0) {
                $sentiment.addClass('text-danger');
                $icon.addClass('fa-chevron-down');
            } else {
                $icon.addClass('fa-circle-o');
            }
            $sentiment.append($icon).append(" "+sentiment);
        }

        function parseHashtag($elem)
        {
            var text = $elem.html();
            var parsed = text.replace(/#([a-z\d-]+)/ig, function replacer(match, p1, offset, string) {
                return "<a href='https://www.facebook.com/hashtag/"+p1.toLowerCase()+"' target='_blank'>#"+p1+"</a>";
            });
            $elem.html(parsed);
        }

        var $postContainer = $('#posts');
        var postUrl = $postContainer.data('url');
        var postCursor = '';
        var postTemplate = Handlebars.compile($('#template-post').html());
        var isLoadingPosts = false;

        var commentTemplate = Handlebars.compile($('#template-comment').html());

        function loadPosts() {
            if(!isLoadingPosts && postCursor !== false) {
                isLoadingPosts = true;
                AjaxLoader.up();
                $.getJSON(postUrl + '?c=' + postCursor, function (data) {
                    if(data.next != undefined) {
                        postCursor = data.next.cursor;
                        $.each(data.posts, function () {
                            var post = this;
                            post['label_comments'] = $postContainer.data('label-comments');
                            post['message'] = post['message'].nl2br();
                            var $post = $(postTemplate(post));
                            var $content = $post.find('.message');
                            parseTime($post);
                            parseSentiment($post);
                            parseTwemoji($content);
                            parseHashtag($content);
                            $post
                                    .appendTo($postContainer)
                                    .imagesLoaded(function (instance) {
                                        $postContainer.masonry('appended', instance.elements);
                                    });
                        });
                    } else {
                        postCursor = false;
                    }
                    AjaxLoader.down();
                    isLoadingPosts = false;
                });
            }
        }

        function loadPostMasonry() {
            $postContainer.masonry({
                itemSelector: '.grid-item',
                transitionDuration: 0
            });
        }

        loadPosts();
        loadPostMasonry();

        $(window).on('scroll', function() {
            var $window = $(window);
            var buffer = $window.height();
            var breakpoint = $(document).height() - $window.height() - buffer;
            if ($window.scrollTop() >= breakpoint) {
                loadPosts();
            }
        });

        jQuery('body')
                .on('show.bs.collapse', '.post-comments', function () {
                    var $this = jQuery(this);
                    var $commentList = $this.find('.media-list');
                    if (!$this.data('loaded') && $this.data('count') > 0) {
                        AjaxLoader.up();
                        $.getJSON(BASE_URL + '/api/post/comments/' + $this.data('post-id'), function (comments) {
                            $.each(comments, function() {
                                var comment = this;
                                if(comment['message'] != '') {
                                    comment['message'] = comment['message'].nl2br();
                                    var $comment = $(commentTemplate(comment));
                                    var $subcomments = $comment.find('.subcomments');
                                    if(comment['comments'].length > 0) {
                                        $.each(comment['comments'], function() {
                                            var subcomment = this;
                                            if(subcomment['message'] != '') {
                                                subcomment['message'] = subcomment['message'].nl2br();
                                                var $subcomment = $(commentTemplate(subcomment));
                                                $subcomments.append($subcomment);
                                            }
                                        });
                                    }
                                    parseTime($comment);
                                    parseTwemoji($comment);
                                    parseHashtag($comment);
                                    $commentList.append($comment);
                                }
                            });

                            $this.data('loaded', true);
                            $this.imagesLoaded(function () {
                                loadPostMasonry();
                            });
                            AjaxLoader.down();
                        });
                    }
                })
                .on('shown.bs.collapse hidden.bs.collapse', function () {
                    loadPostMasonry();
                });
    });
</script>
@endpush