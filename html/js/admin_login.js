$(document).ready(function() {
	$('#error_text').hide();
});
$('button[name=admin_login]').click(function() {
	event.preventDefault();

	var username = $('input[name=username]').val();
	var password = $('input[name=password]').val();

	if (username == '' || password == '') {
		$('#error_text').html('Please fill out all fields');
		$('#error_text').fadeIn();
		var close = setInterval(function() {
			$('#error_text').fadeOut();
			clearInterval(close);
		}, 5000);
	} else {
		$('#error_text').fadeOut();
		$.ajax({
			url: '/api/admin/login',
			method: 'post',
			data: {
				username:username,
				password:password
			},
			success:function(response) {
				var data = JSON.parse(response);

				if (data.result == 'error') {
					$('#error_text').html(data.error);
					$('#error_text').fadeIn();
					var close = setInterval(function() {
						$('#error_text').fadeOut();
						clearInterval(close);
					}, 5000);
				} else {
					window.location.href = '/admin';
				}
			}
		});
	}
});