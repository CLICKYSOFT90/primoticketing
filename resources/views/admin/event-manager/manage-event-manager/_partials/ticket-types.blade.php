<h4 class="font-green bold uppercase">Ticket Types</h4>
<table class="table table-striped table-bordered table-hover dt-responsive" id="ticket-type-row-table" width="100%">
  <thead>
  <tr>

    <th>Ticket Name</th>
    <th>Default Price</th>
    <th>Default Limit</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody id="">
  @php
    $TT = $tickets->toArray();
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
        <select name="TTRow[{{$i}}][ticket_type_id]" id="TTRow-{{$i}}-ticket_type_id" class="form-control ticket_type_dropdown">
          @if(count($ticketType) > 0)
            <option value="">Select</option>
            @foreach($ticketType as $tic)
              @if($tic->id == @$TT[$i-1]['ticket_type_id']))
                @php
                $default_limit =  @$TT[$i-1]['ticket_default_limit'];
                $default_price =  @$TT[$i-1]['ticket_default_price'];
                $selected = "selected";
                @endphp
              @else
                @php
                  $default_limit =  $tic->default_limit;
                  $default_price =  $tic->default_price;
                  $selected = "";
                @endphp
              @endif
              <option value="{{$tic->id}}" {{$selected}} data-limit="{{$default_limit}}" data-price="{{$default_price}}" >
                {{$tic->name}}
              </option>
            @endforeach
          @else
            <option value="">Please first select Event Category</option>
          @endif
        </select>
      </td>
      <td>
        <input type="number" name="TTRow[{{$i}}][ticket_default_price]" id="TTRow-{{$i}}-ticket_default_price" class="form-control default_price" value="{{ old('TTRow.'.($i).'.ticket_default_price', @$TT[$i-1]['ticket_default_price']) }}">
      </td>
      <td>
        <input type="number" name="TTRow[{{$i}}][ticket_default_limit]" id="TTRow-{{$i}}-ticket_default_limit" class="form-control default_limit" value="{{ old('TTRow.'.($i).'.ticket_default_limit', @$TT[$i-1]['ticket_default_limit']) }}">
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
@section('js')
  @parent
  <script>

  </script>

@stop
