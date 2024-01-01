@extends('layouts.admin')
@section('content')
@can('benefit_variant_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.benefit-variants.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.benefitVariant.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.benefitVariant.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-BenefitVariant">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.credit_amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.start_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.end_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.satus') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.picture') }}
                    </th>
                    <th>
                        {{ trans('cruds.benefitVariant.fields.benefit') }}
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
@can('benefit_variant_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.benefit-variants.massDestroy') }}",
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
    ajax: "{{ route('admin.benefit-variants.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'description', name: 'description' },
{ data: 'credit_amount', name: 'credit_amount' },
{ data: 'start_date', name: 'start_date' },
{ data: 'end_date', name: 'end_date' },
{ data: 'satus', name: 'satus' },
{ data: 'picture', name: 'picture', sortable: false, searchable: false },
{ data: 'benefit_name', name: 'benefit.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-BenefitVariant').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection