<form id="ticketForm" class="ticketForm" method="post" action="#">
  {{csrf_field()}}
  <input type="hidden" name="ticket_type" value="1">
  <div class="form-group"></div>
<h4 class="font-green bold uppercase">Ticket Types<span>Please save all Event Types first.</span></h4>
<table class="table table-striped table-bordered table-hover dt-responsive" id="ticket-type-row-table" width="100%">
  <thead>
  <tr>
    <th>Ticket Name</th>
    <th>Ticket Type</th>
    <th>Event Type</th>
    <th>Default Price</th>
    <th>Default Limit</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody id="">
  @php
    $TT = $ticketType->toArray();
    $len = count($TT);
    if(!empty(session()->getOldInput())){
      $len = count(session()->getOldInput()['TTRow']);
    }
  @endphp
  @for($i = 1; $i<=($len == "0" ? 1 : $len); $i++)
    <tr id="TTRow-{{$i}}">
      <td class="hidden">
        <input type="hidden" name="TTRow[{{$i}}][id]" id="TTRow-{{$i}}-id" class="form-control" value="{{ old('TTRow.'.($i).'.id', @$TT[$i-1]['id'])  }}">
      </td>

      <td class="hidden">
        <input type="hidden" name="TTRow[{{$i}}][delete]" id="TTRow-{{$i}}-delete" class="form-control" value="0">
      </td>
      <td>
        <input type="text" name="TTRow[{{$i}}][name]" id="TTRow-{{$i}}-name" class="form-control" value="{{ old('TTRow.'.($i).'.name', @$TT[$i-1]['name']) }}">
      </td>
      <td>
        <select name="TTRow[{{$i}}][type]" id="TTRow-{{$i}}-type" class="form-control">
          <option value="" >Please Select</option>
          @foreach(["Single Event","Season Ticket"] as $rec)
            <option value="{{$rec}}" {{ old('TTRow.'.($i).'.type', @$TT[$i-1]['type']) == $rec ? 'selected' : '' }}>
              {{ $rec }}
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="TTRow[{{$i}}][event_type_id]" id="TTRow-{{$i}}-event_type_id" class="form-control">
          <option value="" >Please Select</option>
          @foreach($eventType as $rec)
            <option value="{{$rec->id}}" {{ old('TTRow.'.($i).'.$TT', @$TT[$i-1]['event_type_id']) == $rec->id ? 'selected' : '' }}>
              {{ $rec->name }}
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <input type="number" name="TTRow[{{$i}}][default_price]" id="TTRow-{{$i}}-default_price" class="form-control" value="{{ old('TTRow.'.($i).'.default_price', @$TT[$i-1]['default_price']) }}">
      </td>
      <td>
        <input type="number" name="TTRow[{{$i}}][default_limit]" id="TTRow-{{$i}}-default_limit" class="form-control" value="{{ old('TTRow.'.($i).'.default_limit', @$TT[$i-1]['default_limit']) }}">
      </td>

      <td>
        <a class="itemsremove remove" title="Remove" id="TTRow-{{$i}}-remove" onclick="removeRow(this.id, 'ticket-type-row-table', 'TTRow');">
          DELETE
        </a>
      </td>
    </tr>
  @endfor
  </tbody>
</table>

<a class="btn green btn-outline right" onclick="cloneRow('ticket-type-row-table', 'TTRow');" href="javascript:;">+ Add Ticket Type</a>
  <button type="button" class="btn blue btn-outline right save_btn ticket">Save</button>
</form>
@section('js')
  @parent
  <script>
    // Login Function
    $(document).ready(function () {
      $("body").on("click", ".save_btn.ticket", function (e) {
        if(confirm("Do you really want to save? If yes, Deleted item will not be undo.")) {
          $.easyAjax({
            url: "{{ route('globalSetting.store') }}",
            type: "POST",
            data: $("#ticketForm").serialize(),
            container: ".ticketForm",
            messagePosition: "inline",
          });
        }
      })
    })
  </script>

@stop
