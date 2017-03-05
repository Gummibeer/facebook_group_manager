@extends('layouts.app')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">Mitglieder</h4>
        </div>
        <table class="table table-striped" id="members-table">
            <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Geschlecht</th>
                <th>Profilbild</th>
                <th>Admin</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#members-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: '{!! route('app.member.datatable') !!}',
            dom: '<"panel-body"<"row"<"col-md-12"f>>>rt<"panel-footer"<"row"<"col-md-6"i><"col-md-6"p>>>',
            columns: [
                { data: 'avatar', name: 'avatar' },
                { data: 'id', name: 'id' },
                { data: 'full_name', name: 'full_name' },
                { data: 'gender', name: 'gender' },
                { data: 'is_silhouette', name: 'is_silhouette' },
                { data: 'is_administrator', name: 'is_administrator' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            drawCallback: function() {
                $(".dataTables_wrapper table").css('margin', '0');
                $(".dataTables_filter label").css('display', 'block');
                $(".dataTables_filter input").addClass('form-control');
                $(".dataTables_paginate a").addClass('btn').addClass('btn-default');
                $(".dataTables_paginate > span > span").hide();
                $(".dataTables_paginate").addClass('pull-right');
            }
        });
    });
</script>
@endpush