<form class="form-submit" method="POST" action="{{route('category_save')}}">
	<input type="hidden" name="_token" value="{{csrf_token()}}" class="_token">
	<div class="modal-header">
		<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		<h4 class="modal-title">New Category</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12 margin-b-10">
				<label>Category Name</label>
				<input type="text" class="form-control" name="category_name" required>
			</div>
		</div>
		
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" type="submit">Submit</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</form>