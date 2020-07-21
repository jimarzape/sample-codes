var voucher = new voucher();

function voucher()
{
	var selected_permissions = null;

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
					if(result.html)
					{
						$(target).html(result.html);	
						_jstree(result.json);
					}
					else
					{
						$(target).html(result);	
					}
					
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

			//STOPS the btn_function on firing
			event.stopPropagation();
			
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
	}

	function _jstree(json)
	{
		var _data = [];
		$.each(json, function(index, data){
			var temp = {
				"icon": data.icon, "id" : data.id, "parent" : data.parent, "text" : data.text, 
	       		state       : {
				    opened    : true,
				    selected  : data.selected
				}
			};
			_data.push(temp);
		});
		$(".jstree").jstree({
			'core' :
			{
				data : _data
			},
			"checkbox" : {
				"keep_selected_style" : false
			},
			"plugins" : [ "wholerow", "checkbox" ]
		});

		$('.jstree').on("changed.jstree", function (e, data) {
		  selected_permissions = data.selected;
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
					$("#modal-permission").modal('toggle');
				},
				error 	: 	function(Err){
					error_handler();
				}
			});
		});

		$('.form-submit-permission').unbind('submit');
		$(".form-submit-permission").bind("submit", function(e){
			e.preventDefault();
			var _token 		= $("._token").val();
			var userlevel 	= $(".user-level").val();
			var id 			= $(".permission-id").val();
			var formdata 	= {
				'permission' : selected_permissions,
				'_token'	 : _token,
				'userlevel'  : userlevel,
				'id'		 : id
			}
			var action 		= $(this).attr('action');
			var method 		= $(this).attr('method');

			$.ajax({
				url 	: 	action,
				type 	: 	method,
				data 	: 	formdata,
				success : 	function(result)
				{
					reload();
					$("#modal-permission").modal('toggle');
				},
				error 	: 	function(error)
				{
					alert('Error, something went wrong.');
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