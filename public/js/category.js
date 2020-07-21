var category = new category();

function category()
{
	init();
	var loader = '<div class="text-center col-md-12"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>'; 
    
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

		$(".btn-archived").unbind("click");
		$(".btn-archived").bind("click", function(){
			var link 	= $(this).data('url');
			var id 		= $(this).data('id');
			var name 	= $(this).data('name');
			var con 	= confirm("Do you really want to remove " + name + "?");
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
					error 	: 	function(Err)
					{
						error_handler();
					}
				});
			}	
		});
	}


	function form_submit()
	{

		$(".form-submit").unbind('submit');
		$(".form-submit").bind("submit", function(e){
			e.preventDefault();
			var formdata = $(this).serialize();
			var link	 = $(this).attr('action');
			var method 	 = $(this).attr('method');
			$.ajax({
				url 	: 	link,
				type 	: 	method,
				data 	: 	formdata,
				success : 	function(result)
				{
					reload();
					$("#modal-category").modal('toggle');
				},
				error 	: 	function(Err){
					error_handler();
				}
			});
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