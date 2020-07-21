@extends('layout')


@section('css')
<link rel="stylesheet" type="text/css" href="/bower_components/jstree/css/style.min.css">
<link rel="stylesheet" type="text/css" href="/bower_components/jstree/css/treeview.css">
@endsection

@section('content')
<div class='row'>
	<div class='col-md-12'>
		<div class="card">
			<div class='card '>
				<div class="card-header inline">
	                <h5 >Total Permissions&nbsp;<span class="text-white bg-success badge">{{ $Permission->total() }}</span></h5>
	                
	                <button class="btn btn-danger f-right btn-padding btn-modal" data-id="0" data-toggle="modal" data-url="{{route('permission_new')}}" data-target="#modal-permission" data-container=".custom-modal"><i class="ti-plus"></i> New</button>
	            </div>
				<div class='card-block camera_div_body table-responsive'>
					<div class="reload-content">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th >Permission</th>
									<th># of access</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($Permission as $perm)
								<tr class="btn-modal" data-url="{{route('permission_view')}}" data-id="{{$perm->permission_id}}" data-target="#modal-permission" data-toggle="modal" data-container=".custom-modal">
									<td>{{$perm->permission_name}}</td>
									<td>{{$perm->PermissionLinks->count()}}</td>
									<td class="text-center">
										<button class="btn btn-warning btn-mini"><i class="ti-pencil"></i></button>
										<button class="btn btn-danger btn-mini btn-archived" data-url="{{route('permission_archived')}}" data-id="{{$perm->permission_id}}" data-name="{{$perm->permission_name}}"><i class="ti-trash"></i></button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{!!$Permission->appends(request()->query())->links()!!}
		                <br>Records Found : {{ $Permission->total() }}. Showing {{ $Permission->firstItem() }} to {{ $Permission->lastItem() }} of total {{$Permission->total()}} entries
					</div>
		        </div>
			</div>
			
			
		</div>
	</div>
</div>

<div id="modal-permission" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content custom-modal class-modal-body">
      
    </div>

  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/bower_components/jstree/js/jstree.min.js"></script>
<script type="text/javascript" src="/js/permission.js?v=1.0.4"></script>
@endsection