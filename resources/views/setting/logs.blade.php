@extends('layout')


@section('css')
@endsection

@section('content')
<div class='row'>
	<div class='col-md-12'>
		<div class="card">
			<div class='card '>
				<div class="card-header inline">
	                <h5 >Total Logs&nbsp;<span class="text-white bg-success badge">{{ $_logs->total() }}</span></h5>
	               
	            </div>
				<div class='card-block camera_div_body table-responsive'>
					<div class="reload-content">
						<table class="table table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th width="50%">Logs</th>
									<th >User</th>
									<th >Type</th>
									<th >Date</th>
									
								</tr>
							</thead>
							<tbody>
								@foreach($_logs as $logs)
								<tr>
									<td>
										{!!$logs->logs_description!!}
									</td>
									<td>{{$logs->name}}</td>
									<td>{{$logs->logs_type}}</td>
									<td>{{date_norm($logs->created_at, 'M d, Y h:i a')}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{!!$_logs->appends(request()->query())->links()!!}
		                <br>Records Found : {{ $_logs->total() }}. Showing {{ $_logs->firstItem() }} to {{ $_logs->lastItem() }} of total {{$_logs->total()}} entries
					</div>
		        </div>
			</div>
			
			
		</div>
	</div>
</div>

@endsection

@section('js')
@endsection