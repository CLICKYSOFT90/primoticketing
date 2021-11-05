<h4 class="font-green bold uppercase">Event List</h4>
<table class="table table-striped table-bordered table-hover dt-responsive" id="event-child-row-table" width="100%">
  <thead>
  <tr>
    <th>Event Icon</th>
    <th>Event Name</th>
    <th>Event Start</th>
    <th>Event End</th>
    <th>Status</th>
    <th>Address</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody id="">
  @php
    $CE = $childEvent->toArray();
    $len = count($CE);
    if(!empty(session()->getOldInput())){
      $len = count(session()->getOldInput()['CERow']);
    }
  @endphp
  @for($i = 1; $i<=($len == "0" ? 1 : $len); $i++)
    <tr id="CERow-{{$i}}">
      <td class="hidden">
        <input type="hidden" name="CERow[{{$i}}][id]" id="CERow-{{$i}}-id" class="form-control" value="{{ old('CERow.'.($i).'.id', @$CE[$i-1]['id'])  }}">
      </td>

      <td class="hidden">
        <input type="hidden" name="CERow[{{$i}}][delete]" id="CERow-{{$i}}-delete" class="form-control" value="0">
      </td>
      <td>
        @if(old('CERow.'.($i).'.event_icon', @$CE[$i-1]['event_icon']))
          <div>fffsss</div>
         @endif
        <input type="file" name="CERow[{{$i}}][event_icon]" id="CERow-{{$i}}-event_icon" class="form-control" >
      </td>
      <td>
        <input type="text" name="CERow[{{$i}}][name]" id="CERow-{{$i}}-name" class="form-control" value="{{ old('CERow.'.($i).'.name', @$CE[$i-1]['name']) }}">
      </td>
      <td>
        <input type="text" name="CERow[{{$i}}][event_start]" id="CERow-{{$i}}-event_start" class="form-control datepicker" value="{{ old('CERow.'.($i).'.event_start', @$CE[$i-1]['event_start']) }}">
      </td>
      <td>
        <input type="text" name="CERow[{{$i}}][event_end]" id="CERow-{{$i}}-event_end" class="form-control datepicker" value="{{ old('CERow.'.($i).'.event_end', @$CE[$i-1]['event_end']) }}">
      </td>
      <td>
        <select name="CERow[{{$i}}][active]" id="CERow-{{$i}}-active" class="form-control">
          <option value="" >Please Select</option>
          @foreach([1=>"Active",0=>"Disabled"] as $key=>$rec)
            <option data-select="{{ @$CE[$i-1]['active']}}" value="{{$key}}" {{ !empty($CE[$i-1]['name']) && ($CE[$i-1]['active'] == $key) ? 'selected' : '' }}>
              {{ $rec }}
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <textarea name="CERow[{{$i}}][address]" id="CERow-{{$i}}-address" class="form-control">{{old('CERow.'.($i).'.address', @$CE[$i-1]['address'])}}</textarea>
      </td>
      <td>
        <a class="itemsremove remove" title="Remove" id="CERow-{{$i}}-remove" onclick="removeRow(this.id, 'event-child-row-table', 'CERow');">
          DELETE
        </a>
      </td>
    </tr>
  @endfor
  </tbody>
</table>

<a class="btn green btn-outline right add_event" onclick="cloneRow('event-child-row-table', 'CERow');" href="javascript:;">+  Add Event</a>
@section('js')
  @parent
@stop
