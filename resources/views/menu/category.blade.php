@extends('layout')


@section('css')
@endsection

@section('content')
<div class='row'>
	<div class='col-md-12'>
		<div class='card reload-content'>
			<div class="card">
				<div class="card-header inline">
	                <h5 >Total Category&nbsp;<span class="text-white bg-success badge">{{ $_category->total() }}</span></h5>
	                <button class="btn btn-primary f-right btn-padding btn-modal" data-id="0" data-toggle="modal" data-url="{{route('category_new')}}" data-target="#modal-category" data-container=".custom-modal"><i class="ti-plus"></i> New</button>
	            </div>
				<div class='card-block camera_div_body table-responsive'>
					
						<table class="table table-hover">
							<thead>
								<tr>
									
									<th>Category Name</th>
									<th width="10%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($_category as $category)
								<tr>
									<td>{{$category->category_name}}</td>
									<td>
										<button class="btn btn-primary btn-modal btn-mini" data-url="{{route('category_view')}}" data-id="{{$category->category_id}}" data-target="#modal-category" data-toggle="modal" data-container=".custom-modal"><i class="ti-pencil"></i></button>
										<button class="btn-mini btn btn-danger btn-archived" data-url="{{route('category_archived')}}" data-id="{{$category->category_id}}" data-name="{{$category->category_name}}"><i class="ti-trash"></i></button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{!!$_category->appends(request()->query())->links()!!}
		                <br>Records Found : {{ $_category->total() }}. Showing {{ $_category->firstItem() }} to {{ $_category->lastItem() }} of total {{$_category->total()}} entries
		        </div>
			</div>
			
		</div>
	</div>
</div>

<div id="modal-category" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content custom-modal class-modal-body">
      
    </div>

  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/js/category.js?v=1.0.0"></script>
@endsection