<form class="form-horizontal form-submit-permission" method="POST" action="{{ route('permission_save') }}">
 {!! csrf_field() !!}
 <input type="hidden" name="id" value="0" class="permission-id">
  <div class="modal-header text-center">
      <h4 class="modal-title witdh-100">New User Permission</h4>
  </div>
  <div class="modal-body ">
    <div class="form-group">
        <div class="col-md-12">
          <label>PerimsName</label>
          <input type="text" name="userlevel" class="user-level form-control" required>
        </div>
    </div>
    <div class="fomr-group">
        <div class="col-md-12">
          <div class="jstree">
              
          </div>
        </div>
    </div>

  </div>
  <div class="modal-footer">
      <button class="btn btn-danger btn-submit btn-padding" type="submit">Submit</button>
      <button type="button" class="btn btn-default btn-padding" data-dismiss="modal">Close</button>
  </div>
</form>