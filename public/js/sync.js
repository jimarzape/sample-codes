var sync = new sync();

function sync()
{
	init();
	var data_url = [];
	var _token 		= '';
	var url_target 	= '';
	var loader = '<div class="text-center col-md-12"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>'; 
    
	function init()
	{
		btn_function();
	}

	function btn_function()
	{
		$(".btn-sync").unbind("click");
		$(".btn-sync").bind("click", function(){
			var link 	= $(this).data('url');
			var btn  	= $(this);
			var def 	= $(".sync-default");
			var status 	= $(".progress-sync");
			var details = $(".syncronize-status");
			var percent = $(".progress-status-sync");
			var bar 	= $(".progress-bar-sync");
			_token		= $(this).data('token');
			url_target 	= $(this).data('process');
			$(".error-status").addClass('hide');
			def.addClass("hide");
			status.removeClass("hide");
			details.html("Fetching data url");
			btn.attr('disabled', true);
			var target_e = {
					'btn' 		: btn,
					'def' 		: def,
					'status' 	: status,
					'details' 	: details,
					'percent' 	: percent,
					'bar' 		: bar,
			}
			$.ajax({
				url 	: 	link,
				type 	: 	'POST',
				data 	: 	{},
				success : 	function(result)
				{
					// result 		= JSON.parse(result);
					if(result.status == 404)
					{
						$(".error-status").removeClass('hide');
						$(".error-message").html(result.error_description);
						$(".progress-sync").addClass('hide');
						btn.removeAttr('disabled');
						// init();
						// alert('Error, ' + result.error_description);
					}
					else
					{
						data_url 	= result.url;
						process_sync(target_e);
					}
					
				},
				error 	: 	function(err)
				{
					alert('Error, something went wrong.');
					btn.removeAttr('disabled');
					status.addClass("hide");
					def.removeClass("hide");
				}
			});
		});

		$(".btn-modal").unbind("click");
		$(".btn-modal").bind("click", function(){
			var id 		= $(this).data('id');
			var link 	= $(this).data('url');
			var target 	= $(".custom-modal-details");
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
				},
				error 	: 	function(err)
				{
					error_handler();
				}
			});
		});
	}

	// function 

	function process_sync(target_e, count = 0)
	{
		var data_form 		= data_url[count];
		var target_lenght 	= data_url.length - 1;
		if(target_lenght >= count)
		{
			target_e.details.html("Fetching " + data_form.name);
			var percent 	= (count / target_lenght ) * 100;
			var percent_str = percent.toFixed(2) + '%';
			target_e.percent.html(percent_str);
			target_e.bar.css('width', percent_str);
			$.ajax({
				url 	: 	url_target,
				type 	: 	'POST',
				data 	: 	data_form,
				success : 	function(result)
				{
					count++;
					process_sync(target_e, count);
				},
				error 	: 	function(err)
				{
					target_e.details.html("Failed to fetch " + data_form.name + '. Retrying...');
					process_sync(target_e, count);
				}
			});
		}
		else
		{

			target_e.bar.css('width', '0%');
			target_e.btn.removeAttr('disabled');
			target_e.status.addClass("hide");
			target_e.def.removeClass("hide");
			reload();
		}
		
	}

	function reload()
	{
		$(".reload-content").load(document.URL + ' .reload-content', function(){
            init();
        });
	}

	function error_handler(err_msg = 'Error, something went wrong.')
	{
		alert(err_msg);
	}

}