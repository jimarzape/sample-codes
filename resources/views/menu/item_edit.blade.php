<form class="form-submit" method="POST" action="{{route('items_update')}}">
	@csrf
	<input type="hidden" name="item_id" value="{{$item->item_id}}">
	<div class="modal-header">
		<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		<h4 class="modal-title">Item</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-6 margin-b-10">
				<label>Item Name</label>
				<input type="text" class="form-control" value="{{$item->item_name}}" name="item_name" required>
			</div>
			<div class="col-md-6 margin-b-10">
				<label>Item Price</label>
				<input type="number" step="any" value="{{$item->item_price}}" class="form-control" name="item_price" required>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 margin-b-10">
				<label>Category</label>
				<select class="form-control" name="category" required>
					<option value="">Select Category</option>
					@foreach($_category as $category)
						<option value="{{$category->category_id}}" {{$category->category_id == $item->category_id ? 'selected="selected"' : ''}}>{{$category->category_name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-6 margin-b-10">
				<label>Ingredients (Tags)</label>
				<input type="text" name="tags" value="{{$tags->tags}}" class="form-control input-tag" data-role="tagsinput">
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 margin-b-10">
				<label>Description</label>
				<textarea class="form-control" rows="10" name="description" required>{{$item->item_description}}</textarea>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-4 text-center main-upload-container">
				<label>Main Image</label><br>
				<span>(Recommended size (px) : 1024 X 768)</span>
				<div class="main-image margin-b-10">
					<img src="{{$item->item_image}}" class="img-main img-200">
					<input type="hidden" name="main_img" class="img-main-input" value="{{$item->item_image}}">
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
					@foreach($_img as $img)
					<div class="sub-image-content" id="img-sub-'+rnd+'"> 
						<span class="rem-sub-img"><i class="ion-trash-a"></i></span>
						<img src="{{$img->item_image}}" class="img-100px img-sub border-gray"> 
						<input type="hidden" name="sub_img[]" class="img-sub-input" value="{{$img->item_image}}">
						<div class="progress-container hide">
							<div class="progress-bar"></div> 
						</div>
					</div>
					@endforeach
					
				</div>
				<input type="file" data-url="{{route('upload_picture')}}" name="" class="hide multi-upload" accept="image/x-png,image/jpeg" multiple>
				<button class="btn btn-primary btn-upload" data-target=".multi-upload" type="button">Upload picture</button>
			</div>
		</div>
		
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" type="submit">Submit</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</form> 