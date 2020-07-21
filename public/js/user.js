var user = new user();

function user()
{
	init();
	var loader = '<div class="text-center col-md-12"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>'; 
    
	function init()
	{
		btn_function();
		password_auth();
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
	}

	function password_auth()
	{
		// alert('test');
		$(".form-password").unbind("submit");
		$(".form-password").bind("submit", function(e){
			e.preventDefault();
			var action = $(this).attr('action');
			var method = $(this).attr('method');
			var formdata = $(this).serialize();
			var btn 	= $(".btn-auth-pass");
			var html 	= btn.html();
			btn.html('Authenticating...');
			$(".auth-status").html("");
			$.ajax({
				url 	: 	action,
				type 	: 	method,
				data 	: 	formdata,
				success : 	function(result)
				{
					btn.html(html);
					if(result.status == 'success')
					{
						$(".auth-status").html('<p class="text-success">'+result.message+'</p>');
						$(".user-password-container").addClass('hide');
					}
					else
					{
						// console.log();
						$(".auth-status").html('<p class="text-danger">'+result.message+'</p>');
						$(".user-password-container").removeClass('hide');
					}
				},
				error 	: 	function(err)
				{
					btn.html(html);
					$(".auth-status").html('<p class="text-danger">Error, please reload this page and try again.</p>');
				}
			});
		});
	}

	function form_submit()
	{
		$(".form-submit").unbind('submit');
		$(".form-submit").bind("submit", function(e){
			e.preventDefault();

			$('.invalid-feedback').css('display', 'none');
			$('.error-msg').html(' ');
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
					$("#modal-user").modal('toggle');
				},
				error 	: 	function(Err){
					// error_handler();
					const e_msg = Err.responseJSON;
					$('.invalid-feedback').css('display', 'block');
					// console.log(e_msg);
					// console.log(e_msg.errors);
					$.each(e_msg.errors, function(i, item) {
					    
					    $('.' + i + '-error').html(item);
					});
				}
			});
		});
		$(".password-update").unbind("change");
		$(".password-update").bind("change", function(){
			var is_required = false;
			$(".password-update").each(function(){
				if($(this).val() != '')
				{
					is_required = true;
				}
			});
			// console.log(is_required);

			if(is_required)
			{
				$("#password").attr('required','required');
				$("#password-confirm").attr('required','required');
				// console.log('required');
			}
			else
			{
				$("#password").removeAttr('required');
				$("#password-confirm").removeAttr('required');
				// console.log('not required');
			}
		});

		$(".is_waiter").unbind("change");
		$(".is_waiter").bind("change", function(){
			if($(this).is(":checked"))
			{
				$(".div-pincode").removeClass("hide");
				$(".div-premission").addClass("hide");
				$('#permission_id').removeAttr('required');
				$('#pincode').attr('required','required');
			}
			else
			{
				$(".div-pincode").addClass("hide");
				$(".div-premission").removeClass("hide");
				$('#permission_id').attr('required','required');
				$('#pincode').removeAttr('required');
			}
		});

		$(".btn-pin-code").unbind("click");
		$(".btn-pin-code").bind("click", function(){
			var link = $(this).data('url');
			var target = $(".pin-code");
			var old = target.val();
			target.val('generating...');
			$.ajax({
				url  	: 	link,
				type 	: 	'POST',
				data 	: 	{},
				success : 	function(result)
				{
					target.val(result);
				},
				error 	: 	function(err)
				{

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