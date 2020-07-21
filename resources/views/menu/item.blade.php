@extends('layout')


@section('css')
<link rel="stylesheet" type="text/css" href="/bower_components/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
<link rel="stylesheet" href="/plugin/Trumbowyg-master/dist/ui/trumbowyg.css" type="text/css" />
@endsection

@section('content')
<div class='row'>
	<div class='col-md-12'>
		<div class="card">
			<div class='card '>
				<div class="card-header inline">
	                <h5 >Total Item&nbsp;<span class="text-white bg-success badge">{{ $_item->total() }}</span></h5>
	                <button class="btn btn-primary f-right btn-padding btn-modal" data-id="0" data-toggle="modal" data-url="{{route('items_new')}}" data-target="#modal-item" data-container=".custom-modal"><i class="ti-plus"></i> New</button>
	               
	                <form class="col-sm-4 f-right" method="GET" action="">
	                	<div class="input-group input-group-button">
							<input type="search" class="form-control" name="search" placeholder="Search Item here" value="{{Request::input('search')}}">
			                <span class="input-group-addon" style="margin-top:0px">
			                    <button class="btn btn-danger" type="submit"><i class="ti-search"></i></button>
			                </span>
							
						</div>
	                </form>
	            </div>
				<div class='card-block camera_div_body table-responsive'>
					<div class="reload-content">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th >ID</th>
									<th >Photo</th>
									<th >Name</th>
									<th >Price</th>
									<th class="text-center">Available</th>
									<th class="text-center">Action</th>
									
									
								</tr>
							</thead>
							<tbody>
								@foreach($_item as $item)
								<tr>
									<td>{{$item->item_id}}</td>
									<td>
										<img src="{{$item->item_image}}" class="img-75 border-gray">
									</td>
									<td>
										{{$item->item_name}}
									</td>
									<td class="text-right">
										{{number_format($item->item_price, 2)}}
									</td>
									<td class="text-center">
										@if($item->item_active == 1)
										<a href="javascript:void(0)" class="status-toggle text-success" data-status="0" data-id="{{$item->item_id}}" data-url="{{route('item_active_toggle')}}"><i class="ion-checkmark"></i></a>
										@else
										<a href="javascript:void(0)" class="status-toggle text-danger" data-status="1" data-id="{{$item->item_id}}" data-url="{{route('item_active_toggle')}}"><i class="ion-close-round"></i></a>
										@endif
									</td>
									<td class="text-center">
										
										<button class="btn btn-primary btn-modal btn-mini" data-url="{{route('items_view')}}" data-id="{{$item->item_id}}" data-target="#modal-item" data-toggle="modal" data-container=".custom-modal"><i class="ti-pencil"></i></button>
										<button class="btn-mini btn btn-danger btn-archived" data-url="{{route('items_archived')}}" data-id="{{$item->item_id}}" data-name="{{$item->item_name}}"><i class="ti-trash"></i></button>
										
									</td>
								</tr>
								@endforeach
								@if($_item->total() <= 0)
								<tr>
									<td colspan="6" class="text-center"><i>No data found</i></td>
								</tr>
								@endif
							</tbody>
						</table>
						{!!$_item->appends(request()->query())->links()!!}
		                <br>Records Found : {{ $_item->total() }}. Showing {{ $_item->firstItem() }} to {{ $_item->lastItem() }} of total {{$_item->total()}} entries
					</div>
		        </div>
			</div>
			
			
		</div>
	</div>
</div>

<div id="modal-item" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content custom-modal class-modal-body">
      
    </div>

  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/bower_components/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="/plugin/Trumbowyg-master/dist/trumbowyg.js"></script>
<script type="text/javascript" src="/js/item.js?v=1.0.9"></script>
@endsection