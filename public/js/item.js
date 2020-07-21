var item = new item();

function item()
{
	init();
	var loader 	= '<div class="text-center col-md-12"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>'; 
    var token 	= $('meta[name="csrf-token"]').attr('content');
	function init()
	{
		btn_function();
	}

	function btn_function()
	{
		$(".btn-modal").unbind("click");
		$(".btn-modal").bind("click", function(){
			var id 		= $(this).data('id');
			var link 	= $(this).data('url');
			var target 	= $(this).data('container');
			$(target).html(loader);
			$.ajax({
				url 	: 	link,
				type 	: 	'POST',
				data 	: 	{
					'id' : id,
				},
				success : 	function(result)
				{
					$(target).html(result);
					form_submit();
				},
				error 	: 	function(err)
				{
					error_handler();
				}
			});
		});

		$(".status-toggle").unbind("click");
		$(".status-toggle").bind("click", function(){
			var status 	= $(this).data('status');
			var link	= $(this).data('url');
			var id 		= $(this).data('id');
			$.ajax({
				url 	: 	link,
				type 	: 	'POST',
				data 	: 	{
					'id' : id,
					'status' : status
				},
				success : 	function(result)
				{
					reload();
				},
				error 	: 	function(err)
				{
					error_handler();
				}
			});
		});

		$(".btn-archived").unbind("click");
		$(".btn-archived").bind("click", function(){
			var link 	= $(this).data('url');
			var id 		= $(this).data('id');
			var name 	= $(this).data('name');
			var con  	= confirm('Do your really want to remove ' + name + "?");
			if(con)
			{
				$.ajax({
					url 	: 	link,
					type 	: 	'POST',
					data 	: 	{
						'id' : id
					},
					success : 	function(result)
					{
						reload();
					},
					error 	: 	function(err)
					{
						error_handler();
					}
				});
			}
			
		});

	}

	function form_submit()
	{
		remove_img();
		upload_picture();
		$(".input-tag").tagsinput({
			allowDuplicates: true
		});

		$(".btn-upload").unbind("click");
		$(".btn-upload").bind("click", function(){
			var target = $(this).data('target');
			$(target).click();
		});

		$(".text-editor").trumbowyg({
	        btns: [
	                ['viewHTML'],
	                ['undo', 'redo'], // Only supported in Blink browsers
	                ['formatting'],
	                ['strong', 'em', 'del'],
	                ['superscript', 'subscript'],
	                ['link'],
	                // ['insertImage'],
	                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
	                ['unorderedList', 'orderedList'],
	                ['horizontalRule'],
	                ['removeformat'],
	                // ['fullscreen']
	            ],
	        autogrow: true,
	        autogrowOnEnter: true
	    });

	    $(".form-submit").unbind("submit");
	    $(".form-submit").bind("submit", function(e){
	    	e.preventDefault();
	    	var formdata = $(this).serialize();
	    	var link 	= $(this).attr('action');
	    	var method 	= $(this).attr('method');
	    	$.ajax({
	    		url 	: 	link,
	    		type 	: 	method,
	    		data 	: 	formdata,
	    		success : 	function(result)
	    		{
	    			reload();
	    			$("#modal-item").modal('toggle');
	    		},
	    		error 	: 	function(err)
	    		{
	    			error_handler();
	    		}
	    	});
	    });
	}

	function upload_picture()
	{
		$(".main-upload").unbind('change');
		$(".main-upload").bind('change', function(){
			var image   = $(this)[0].files[0];
			var url     = $(this).data('url');
			// var token   = $(this).data('token');
			var formdata    = new FormData();
			var ajax        = new XMLHttpRequest();
			var _progress   = $(".progress-200").find('.progress-bar');
			$(".progress-200").removeClass('hide');

			formdata.append("image", image);
			formdata.append('_token',token);

			ajax.upload.addEventListener('progress', function(e){
			_progress.css("width",Math.ceil(e.loaded/e.total) * 100 + '%');
			}, false);
			ajax.addEventListener("load", function(e){
				var link = e.target.responseText;
				$(".img-main").attr("src",ajax.responseText);
				$(".img-main-input").val(ajax.responseText);
				$(".progress-200").addClass('hide');
				upload_picture();

			}, false);
			ajax.open('POST', url);
			ajax.send(formdata);
		});

		$(".multi-upload").unbind('change');
		$(".multi-upload").bind("change", function(){
			// console.log("sub-images");
			var _files 	= $(this)[0].files;
			var url     = $(this).data('url');
			upload_multiple(url, _files, ".sub-images");
		});

		$(".multi-upload-option").unbind("change");
		$(".multi-upload-option").bind("change", function(){
			// console.log("sub-images-container");
			var _files 	= $(this)[0].files;
			var url     = $(this).data('url');
			upload_multiple(url, _files, ".option-image" , true);
		});
		

		$(".has-option").unbind("change");
		$(".has-option").bind("change", function(){
			if($(this).is(":checked"))
			{
				$(".special-option").removeClass("hide");
			}
			else
			{
				$(".special-option").addClass("hide");
				$(".option-image").html("");
			}
		});
	}

	function upload_multiple(url, _files, target = "", has_input = false)
	{
		console.log("has_input : " + has_input);
		console.log("target : " + target);
		$.each(_files, function(index, data){
			// console.log(data);
			
			var rnd 	= makeid(5);
			var html 	= '<div class="sub-image-content" id="img-sub-'+rnd+'">' + 
							'<span class="rem-sub-img hide"><i class="ion-trash-a"></i></span>' +
							'<img src="/media/image-placeholder.png" class="img-100px img-sub border-gray">' + 
							'<input type="hidden" name="sub_img[]" class="img-sub-input" value="/media/image-placeholder.png">' +
							'<div class="progress-container hide">' +
								'<div class="progress-bar"></div>' + 
							'</div>' +
						'</div>';

			if(has_input)
			{
				html 	= '<div class="sub-image-content text-center" id="img-sub-'+rnd+'">' + 
							'<span class="rem-sub-img margin-l-115"><i class="ion-trash-a"></i></span>' +
							'<img src="/media/image-placeholder.png" class="img-100px img-sub border-gray margin-b-10">' + 
							'<input type="hidden" name="option_img[]" class="img-sub-input" value="/media/image-placeholder.png">' +
							'<div class="progress-container hide">' +
								'<div class="progress-bar"></div>' + 
							'</div>' +
							'<input type="text" class="form-control text-center" name="label[]" placeholder="Label/Name" required>' +
						'</div>';
			}

			$(target).append(html);
			var parent 				= $("#img-sub-" + rnd);
			var image 				= parent.find(".img-sub");
			var imge_input			= parent.find(".img-sub-input");
			var rem_img 			= parent.find('.rem-sub-img');
			var progress_container 	= parent.find('.progress-container');
			// console.log(parent.html());
			var formdata    		= new FormData();
			var ajax        		= new XMLHttpRequest();
			var _progress   		= progress_container.find('.progress-bar');
			progress_container.removeClass('hide');

			formdata.append("image", data);
			formdata.append('_token',token);

			ajax.upload.addEventListener('progress', function(e){
			_progress.css("width",Math.ceil(e.loaded/e.total) * 100 + '%');
			}, false);
			ajax.addEventListener("load", function(e){
				var link = e.target.responseText;
				image.attr("src",ajax.responseText);
				imge_input.val(ajax.responseText);
				rem_img.attr('data-img',ajax.responseText);
				rem_img.removeClass('hide');
				progress_container.addClass('hide');
				upload_picture();
				remove_img();
			}, false);
			ajax.open('POST', url);
			ajax.send(formdata);
		});
	}


	function makeid(length) {
	   var result           = '';
	   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	   var charactersLength = characters.length;
	   for ( var i = 0; i < length; i++ ) {
	      result += characters.charAt(Math.floor(Math.random() * charactersLength));
	   }
	   return result;
	}

	function remove_img()
	{
		$(".rem-sub-img").unbind("click");
		$(".rem-sub-img").bind("click", function(){
			var parent = $(this).parent('.sub-image-content');
			// console.log($(this).data('img'));
			parent.remove();
		});
	}

	function error_handler(err_msg = 'Error, something went wrong.')
	{
		alert(err_msg);
	}


	function reload()
	{
		$(".reload-content").load(document.URL + ' .reload-content', function(){
            btn_function();
        });
	}
}