@can('variant_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.variants.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.variant.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.variant.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-benefitVariants">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.variant.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.variant.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.variant.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.variant.fields.credit_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.variant.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.variant.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.variant.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.variant.fields.benefit') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($variants as $key => $variant)
                        <tr data-entry-id="{{ $variant->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $variant->id ?? '' }}
                            </td>
                            <td>
                                {{ $variant->name ?? '' }}
                            </td>
                            <td>
                                {{ $variant->description ?? '' }}
                            </td>
                            <td>
                                {{ $variant->credit_amount ?? '' }}
                            </td>
                            <td>
                                {{ $variant->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $variant->end_date ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Variant::STATUS_SELECT[$variant->status] ?? '' }}
                            </td>
                            <td>
                                {{ $variant->benefit->title ?? '' }}
                            </td>
                            <td>
                                @can('variant_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.variants.show', $variant->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('variant_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.variants.edit', $variant->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('variant_delete')
                                    <form action="{{ route('admin.variants.destroy', $variant->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('variant_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.variants.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-benefitVariants:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection