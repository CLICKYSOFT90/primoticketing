<form id="walkUpForm" class="walkUpForm" method="post">
  {{csrf_field()}}
  <input type="hidden" name="walkup_type" value="1">
<h4 class="font-green bold uppercase">Special Walk-up Types <span>Visible on the scanner app and used for special walk-ups</span></h4>
  <div class="form-group"></div>
<table class="table table-striped table-bordered table-hover dt-responsive" id="walkup-type-row-table" width="100%">
  <thead>
  <tr>
    <th>Walk-up Name</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody id="">
    @php
    $WT = $walkUpType->toArray();
    $len = count($WT);
    if(!empty(session()->getOldInput())){
      $len = count(session()->getOldInput()['WTRow']);
    }
    @endphp
    @for($i = 1; $i<=($len == "0" ? 1 : $len); $i++)
    <tr id="WTRow-{{$i}}">
      <td class="hidden">
        <input type="hidden" name="WTRow[{{$i}}][id]" id="WTRow-{{$i}}-id" class="form-control" value="{{ old('WTRow.'.($i).'.id', @$WT[$i-1]['id'])  }}">
      </td>

      <td class="hidden">
        <input type="hidden" name="WTRow[{{$i}}][delete]" id="WTRow-{{$i}}-delete" class="form-control" value="0">
      </td>

      <td>
        <input type="text" name="WTRow[{{$i}}][name]" id="WTRow-{{$i}}-name" class="form-control" value="{{ old('WTRow.'.($i).'.name', @$WT[$i-1]['name']) }}">
      </td>
      <td>
        <a class="itemsremove remove" title="Remove" id="WTRow-{{$i}}-remove" onclick="removeRow(this.id, 'walkup-type-row-table', 'WTRow');">
          DELETE
        </a>
      </td>
    </tr>
    @endfor
  </tbody>
</table>

<a class="btn green btn-outline right" onclick="cloneRow('walkup-type-row-table', 'WTRow');" href="javascript:;">+ Add Walk-Up Type</a>
  <button type="button" class="btn blue btn-outline right save_btn walkup">Save</button>
</form>
@section('js')
@parent
<script>
  // Login Function
  $(document).ready(function () {
    $("body").on("click", ".save_btn.walkup", function (e) {
      if(confirm("Do you really want to save? If yes, Deleted item will not be undo.")) {
        $.easyAjax({
          url: "{{ route('globalSetting.store') }}",
          type: "POST",
          data: $("#walkUpForm").serialize(),
          container: ".walkUpForm",
          messagePosition: "inline",
        });
      }
    })
  })
</script>
@stop
