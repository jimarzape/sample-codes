var upload = new upload();

function upload()
{
	var loader 	= '<div class="text-center col-md-12"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>'; 
    var token 	= $('meta[name="csrf-token"]').attr('content');
	init();
	function init()
	{
		btn_function();
	}

	function btn_function()
	{
		$(".btn-modal").unbind("click");
		$(".btn-modal").bind("click", function(){
			$(".custom-modal").html(loader);
			var link = $(this).data("url");
			$.ajax({
				url 	: 	link,
				type 	: 	'POST',
				data 	: 	{},
				success : 	function(result){
					$(".custom-modal").html(result);
					modal_btn();
				},
				error 	: 	function(err)
				{
					alert('Error, something went wrong.');
					$("#modal-sync").modal('toggle');
				}
			});
		});

		$(".btn-upload-check").unbind("click");
		$(".btn-upload-check").bind("click", function () {
			var id 		= $(this).data('id');
			var link 	= $(this).data('url');
			var target 	= $(".orders-modal");
			target.html(loader);
			$.ajax({
				url 	: 	link,
				type 	: 	'POST',
				data 	: 	{
					'id' : id
				},
				success : 	function(result)
				{
					target.html(result);
				},
				error 	: 	function(error)
				{
					error_handler();
				}
			});
		});
	}

	function modal_ajax(target, id)
	{
		
	}
	var _link 		= [];
	var count_link 	= 0;

	function modal_btn()
	{
		$(".btn-upload").unbind("click");
		$(".btn-upload").bind("click", function(){
			_link = [
				{
					'url' : $("#order-input").val(),
					'title' : 'Uploading Order'
				},
				{
					'url' : $("#customer-input").val(),
					'title' : 'Uploading Customers'
				},
			];
			$(".status-upload").html(loader);
			var modal = $("#modal-sync");
			setTimeout(function() {
				process_upload(0, modal);
			}, 10);
			
		});
		
	}

	function process_upload(count = 0, modal)
	{
		var target = _link[count];
		console.log(target);
		$.ajax({
			url 	: 	target.url,
			type	: 	'post',
			data 	: 	{},
			success : 	function(result)
			{
				if(count < _link.lenght)
				{
					count++;
					process_upload(count, modal);
				}
				else
				{
					modal.modal('toggle');
					reload();
				}

			},
			error 	: 	function(err)
			{
				console.log(err);
			}
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