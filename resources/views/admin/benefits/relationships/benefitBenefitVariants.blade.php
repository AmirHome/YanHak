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
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-benefitBenefitVariants">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.picture') }}
                        </th>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.benefitVariant.fields.benefit') }}
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
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($benefitVariants as $key => $benefitVariant)
                        <tr data-entry-id="{{ $benefitVariant->id }}">
                            <td>

                            </td>
                            <td>
                                @if($benefitVariant->picture)
                                    <a href="{{ $benefitVariant->picture->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $benefitVariant->picture->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $benefitVariant->name ?? '' }}
                            </td>
                            <td>
                                {{ $benefitVariant->benefit->name ?? '' }}
                            </td>
                            <td>
                                {{ $benefitVariant->description ?? '' }}
                            </td>
                            <td>
                                {{ $benefitVariant->credit_amount ?? '' }}
                            </td>
                            <td>
                                {{ $benefitVariant->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $benefitVariant->end_date ?? '' }}
                            </td>
                            <td>
                                @can('benefit_variant_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.benefit-variants.show', $benefitVariant->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('benefit_variant_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.benefit-variants.edit', $benefitVariant->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('benefit_variant_delete')
                                    <form action="{{ route('admin.benefit-variants.destroy', $benefitVariant->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('benefit_variant_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.benefit-variants.massDestroy') }}",
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
    order: [[ 2, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-benefitBenefitVariants:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection