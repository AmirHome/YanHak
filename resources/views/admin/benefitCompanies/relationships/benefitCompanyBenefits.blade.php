@can('benefit_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.benefits.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.benefit.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.benefit.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-benefitCompanyBenefits">
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
                <tbody>
                    @foreach($benefits as $key => $benefit)
                        <tr data-entry-id="{{ $benefit->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $benefit->name ?? '' }}
                            </td>
                            <td>
                                {{ $benefit->category->name ?? '' }}
                            </td>
                            <td>
                                {{ $benefit->benefit_company->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Benefit::STATUS_RADIO[$benefit->status] ?? '' }}
                            </td>
                            <td>
                                @if($benefit->picture)
                                    <a href="{{ $benefit->picture->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $benefit->picture->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $benefit->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $benefit->team->name ?? '' }}
                            </td>
                            <td>
                                @foreach($benefit->variants as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $benefit->end_date ?? '' }}
                            </td>
                            <td>
                                @can('benefit_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.benefits.show', $benefit->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('benefit_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.benefits.edit', $benefit->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('benefit_delete')
                                    <form action="{{ route('admin.benefits.destroy', $benefit->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('benefit_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.benefits.massDestroy') }}",
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
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-benefitCompanyBenefits:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection