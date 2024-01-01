@extends('layouts.admin')
@section('content')
@can('benefit_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.benefits.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.benefit.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Benefit', 'route' => 'admin.benefits.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.benefit.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Benefit">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.benefit_company') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.picture') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.start_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.team') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.variant') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefit.fields.end_date') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('benefit_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.benefits.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.benefits.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'name', name: 'name' },
{ data: 'category_name', name: 'category.name' },
{ data: 'benefit_company_name', name: 'benefit_company.name' },
{ data: 'status', name: 'status' },
{ data: 'picture', name: 'picture', sortable: false, searchable: false },
{ data: 'start_date', name: 'start_date' },
{ data: 'team_name', name: 'team.name' },
{ data: 'variant', name: 'variants.name' },
{ data: 'end_date', name: 'end_date' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Benefit').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection