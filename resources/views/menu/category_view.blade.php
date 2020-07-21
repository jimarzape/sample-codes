<form class="form-submit" method="POST" action="{{route('category_update')}}">
	<input type="hidden" name="_token" value="{{csrf_token()}}" class="_token">
	<input type="hidden" name="category_id" value="{{$category->category_id}}">
	<div class="modal-header">
		<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		<h4 class="modal-title">Category</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<label>Category Name</label>
				<input type="text" value="{{$category->category_name}}" class="form-control" name="category_name" required>
			</div>
		</div>
		
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" type="submit">Submit</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</form>