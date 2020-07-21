<form class="form-submit" method="POST" action="{{route('items_save')}}">
	@csrf
	<div class="modal-header">
		<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		<h4 class="modal-title">New Item</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-6 margin-b-10">
				<label>Item Name</label>
				<input type="text" class="form-control" name="item_name" required>
			</div>
			<div class="col-md-6 margin-b-10">
				<label>Item Price</label>
				<input type="number" step="any" class="form-control" name="item_price" required>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 margin-b-10">
				<label>Category</label>
				<select class="form-control" name="category" required>
					<option value="">Select Category</option>
					@foreach($_category as $category)
						<option value="{{$category->category_id}}">{{$category->category_name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-6 margin-b-10">
				<label>Ingredients (Tags)</label>
				<input type="text" name="tags" class="form-control input-tag" data-role="tagsinput">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 margin-b-10">
				<label>Description</label>
				<textarea class="form-control" rows="10" name="description" required></textarea>
			</div>
			
		</div>
		<div class="row margin-b-10">
			<div class="col-md-4 text-center main-upload-container">
				<label>Main Image</label><br>
				<span>(Recommended size (px) : 1024 X 768)</span>
				<div class="main-image margin-b-10">
					<img src="/media/image-placeholder.png" class="img-main img-200">
					<input type="hidden" name="main_img" class="img-main-input gray-background" value="/media/image-placeholder.png">
					<div class="progress-200 margin-auto hide">
						<div class="progress-bar"></div>
					</div>
				</div>

				<input type="file" name="" data-url="{{route('upload_picture')}}" class="hide main-upload" accept="image/x-png,image/jpeg">
				<button class="btn btn-primary btn-block btn-upload" data-target=".main-upload" type="button">Upload picture</button>
			</div>
			<div class="col-md-8 multi-upload-container">
				<label>Sub Image/s</label>&nbsp;<span>(Recommended size (px) : 1024 X 768)</span>
				<div class="sub-images sub-images-container margin-b-10">

					
				</div>
				<input type="file" data-url="{{route('upload_picture')}}" name="" class="hide multi-upload" accept="image/x-png,image/jpeg" multiple>
				<button class="btn btn-primary btn-upload" data-target=".multi-upload" type="button">Upload pictures</button>

			</div>
		</div>
		
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" type="submit">Submit</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</form> 