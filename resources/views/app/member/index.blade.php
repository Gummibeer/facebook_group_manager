@extends('layouts.app')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">{{ trans('labels.members') }}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="filter_id">{{ trans('labels.id') }}</label>
                        <input type="text" class="form-control" id="filter_id" data-column="id" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="filter_full_name">{{ trans('labels.full_name') }}</label>
                        <input type="text" class="form-control" id="filter_full_name" data-column="full_name" />
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="filter_is_silhouette">{{ trans('labels.is_silhouette') }}</label>
                        <select class="form-control" id="filter_is_silhouette" data-column="is_silhouette">
                            <option value=""></option>
                            <option value="1">{{ trans('labels.yes') }}</option>
                            <option value="0">{{ trans('labels.no') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="filter_is_administrator">{{ trans('labels.is_admin') }}</label>
                        <select class="form-control" id="filter_is_administrator" data-column="is_administrator">
                            <option value=""></option>
                            <option value="1">{{ trans('labels.yes') }}</option>
                            <option value="0">{{ trans('labels.no') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="filter_is_approved">{{ trans('labels.is_approved') }}</label>
                        <select class="form-control" id="filter_is_approved" data-column="is_approved">
                            <option value=""></option>
                            <option value="1">{{ trans('labels.yes') }}</option>
                            <option value="0">{{ trans('labels.no') }}</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="filter_gender">{{ trans('labels.gender') }}</label>
                        <select class="form-control" id="filter_gender" data-column="gender">
                            <option value=""></option>
                            @foreach(app(\App\Libs\Gender::class)->getLabels() as $id => $name)
                            <option value="{{ $id }}">{{ trans('labels.'.$name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="filter_gender_by_name">{{ trans('labels.gender_by_name') }}</label>
                        <select class="form-control" id="filter_gender_by_name" data-column="gender_by_name">
                            <option value=""></option>
                            @foreach(app(\App\Libs\Gender::class)->getLabels() as $id => $name)
                            <option value="{{ $id }}">{{ trans('labels.'.$name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="filter_gender_by_picture">{{ trans('labels.gender_by_picture') }}</label>
                        <select class="form-control" id="filter_gender_by_picture" data-column="gender_by_picture">
                            <option value=""></option>
                            @foreach(app(\App\Libs\Gender::class)->getLabels() as $id => $name)
                            <option value="{{ $id }}">{{ trans('labels.'.$name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="filter_age">{{ trans('labels.age') }}</label>
                        <input type="text" class="form-control" id="filter_age" data-column="age" />
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="filter_age_by_picture">{{ trans('labels.age_by_picture') }}</label>
                        <input type="text" class="form-control" id="filter_age_by_picture" data-column="age_by_picture" />
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover" id="members-table">
            <thead>
            <tr>
                <th width="96px"></th>
                <th>{{ trans('labels.id') }}</th>
                <th>{{ trans('labels.full_name') }}</th>
                <th>{{ trans('labels.gender') }}</th>
                <th>{{ trans('labels.gender_by_name') }}</th>
                <th>{{ trans('labels.gender_by_picture') }}</th>
                <th>{{ trans('labels.age') }}</th>
                <th>{{ trans('labels.age_by_picture') }}</th>
                <th>{{ trans('labels.is_silhouette') }}</th>
                <th>{{ trans('labels.is_admin') }}</th>
                <th>{{ trans('labels.is_approved') }}</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(function() {
        $('#members-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: '{!! route('app.member.datatable') !!}',
            dom: 'r<"table-responsive"t><"panel-footer"<"row"<"col-md-6"i><"col-md-6"p>>>',
            columns: [
                { data: 'avatar', name: 'avatar', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'full_name', name: 'full_name' },
                { data: 'gender', name: 'gender' },
                { data: 'gender_by_name', name: 'gender_by_name' },
                { data: 'gender_by_picture', name: 'gender_by_picture' },
                { data: 'age', name: 'age' },
                { data: 'age_by_picture', name: 'age_by_picture' },
                { data: 'is_silhouette', name: 'is_silhouette' },
                { data: 'is_administrator', name: 'is_administrator' },
                { data: 'is_approved', name: 'is_approved' },
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