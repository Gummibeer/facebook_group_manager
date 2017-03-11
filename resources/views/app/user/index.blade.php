@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">{{ trans('labels.users') }}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="filter_facebook_id">{{ trans('labels.facebook_id') }}</label>
                        <input type="text" class="form-control" id="filter_facebook_id" data-column="facebook_id" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filter_name">{{ trans('labels.full_name') }}</label>
                        <input type="text" class="form-control" id="filter_name" data-column="name" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filter_email">{{ trans('labels.email') }}</label>
                        <input type="text" class="form-control" id="filter_email" data-column="email" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="filter_is_admin">{{ trans('labels.is_admin') }}</label>
                        <select class="form-control" id="filter_is_admin" data-column="is_admin">
                            <option value=""></option>
                            <option value="1">{{ trans('labels.yes') }}</option>
                            <option value="0">{{ trans('labels.no') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="members-table">
                <thead>
                <tr>
                    <th>{{ trans('labels.facebook_id') }}</th>
                    <th>{{ trans('labels.full_name') }}</th>
                    <th>{{ trans('labels.email') }}</th>
                    <th>{{ trans('labels.is_admin') }}</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(function() {
        $('#members-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: '{!! route('app.user.datatable') !!}',
            dom: 'rt<"panel-footer"<"row"<"col-md-6"i><"col-md-6"p>>>',
            columns: [
                { data: 'facebook_id', name: 'facebook_id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'is_admin', name: 'is_admin' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            drawCallback: function() {
                $(".dataTables_wrapper table").css('margin', '0');
                $(".dataTables_filter label").css('display', 'block');
                $(".dataTables_filter input").addClass('form-control');
                $(".dataTables_paginate a").addClass('btn').addClass('btn-default');
                $(".dataTables_paginate > span > span").hide();
                $(".dataTables_paginate").addClass('pull-right');
            },
            initComplete: function(settings, json) {
                var table = this.api();
                $.each(settings.aoColumns, function() {
                    var column = this;
                    if(column.bSearchable) {
                        var $input = $(':input[data-column="'+column.name+'"]');
                        if($input.length == 1) {
                            $input.on('change', function() {
                                table.column(column.idx).search($(this).val(), true, false).draw();
                            });
                        }
                    }
                });
            }
        });
    });
</script>
@endpush