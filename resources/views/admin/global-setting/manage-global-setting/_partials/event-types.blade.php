<form id="eventForm" class="eventForm" method="post">
  {{csrf_field()}}
  <input type="hidden" name="event_type" value="1">
<h4 class="font-green bold uppercase">Event Types</h4>
  <div id="error" class="form-group"></div>
<table class="table table-striped table-bordered table-hover dt-responsive" id="event-type-row-table" width="100%">
  <thead>
  <tr>
    <th>Event Name</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody id="eventTypeBody">
    @php
    $ET = $eventType->toArray();
    $len = count($ET);
    if(!empty(session()->getOldInput())){
      $len = count(session()->getOldInput()['ETRow']);
    }
    @endphp
    @for($i = 1; $i<=($len == "0" ? 1 : $len); $i++)
    <tr id="ETRow-{{$i}}">
      <td class="hidden">
        <input type="hidden" name="ETRow[{{$i}}][id]" id="ETRow-{{$i}}-id" class="form-control" value="{{ old('ETRow.'.($i).'.id', @$ET[$i-1]['id'])  }}">
      </td>

      <td class="hidden">
        <input type="hidden" name="ETRow[{{$i}}][delete]" id="ETRow-{{$i}}-delete" class="form-control" value="0">
      </td>

      <td>
        <input type="text" name="ETRow[{{$i}}][name]" id="ETRow-{{$i}}-name" class="form-control" value="{{ old('ETRow.'.($i).'.name', @$ET[$i-1]['name']) }}">
      </td>
      <td>
        <a class="itemsremove remove" title="Remove" id="ETRow-{{$i}}-remove" onclick="removeRow(this.id, 'event-type-row-table', 'ETRow');">
          DELETE
        </a>
      </td>
    </tr>
    @endfor
  </tbody>
</table>

<a class="btn green btn-outline right" onclick="cloneRow('event-type-row-table', 'ETRow');" href="javascript:;">+ Add Event Type</a>
  <button type="button" class="btn blue btn-outline right save_btn event">Save</button>
</form>
@section('js')
@parent
<script>
  // Login Function
  $(document).ready(function () {
    $("body").on("click", ".save_btn.event", function (e) {
      if(confirm("Do you really want to save? Deleted item will not be undo.")) {
        $.easyAjax({
          url: "{{ route('globalSetting.store') }}",
          type: "POST",
          data: $("#eventForm").serialize(),
          container: ".eventForm",
          messagePosition: "inline",
        });
      }
    })
  })

</script>


@stop
