var error_empty = 'Please fill out all fields';

var form = '';
var inputs = [];
var values = [];

function addForm(form_name) {
	form = form_name;
}

function addInput(array_value) {
	inputs = array_value;
}

function addValue(array_value) {
	values = array_value;
}

function addValueToInput() {
	console.log(form);
	console.log(inputs);
	console.log(values);
	for (var i = 0;i <= inputs.length - 1;i++) {
		$('#'+form).find('#'+inputs[i]).val(values[i]);
	}
}

$('#error-handler-update').hide();
$('#error-handler').hide();
$('#error-handler2').hide();
$('#error-handler3').hide();
$('#error-handler4').hide();
$('#error-handler5').hide();

function doSuccess(data) {
	if (data != 'success') {
		$('#error-handler').show();
		$('#admin_err').html(data);
		$('#error-handler2').show();
		$('#admin_err2').html(data);
		$('#error-handler3').show();
		$('#admin_err3').html(data);
		$('#error-handler4').show();
		$('#admin_err4').html(data);
		$('#error-handler5').show();
		$('#admin_err5').html(data);
		$('#error-handler-update').show();
		$('#admin_err_update').html(data);

		hideErr();
	} else {
		alert(data);
		window.location.reload();
	}
}

function hideErr() {
	var x = setInterval(function(){
		$('#error-handler').fadeOut();
		$('#error-handler2').fadeOut();
		$('#error-handler3').fadeOut();
		$('#error-handler4').fadeOut();
		$('#error-handler5').fadeOut();
		$('#error-handler-update').fadeOut();
		clearInterval(x);
	}, 5000);
}

var delete_id = 0;
var delete_table_name = '';

function deleteOnTable(table_name) {
	delete_table_name = table_name;
}

function putOnDelete(id) {
	delete_id = id;
}

function proceedOnDelete() {
	var request = 'delete_general';

	if (confirm) {
		if (delete_table_name != undefined && delete_id != undefined) {
			$.ajax({
				url: '/ajax_request',
				method: 'post',
				data: {
					id:delete_id,
					table:delete_table_name,
					request:request
				},
				success:function(data) {
					if(data == 'success') {
						window.location.reload();
					} else {
						alert(data);
					}
				}
			});
		}
	}
}

$('.menu-toggle').click(function() {
	document.getElementById('menu').classList.toggle('active');
});

$('#form_login').on('submit', function() {
	event.preventDefault();
	var username = $('#form_login').find('input[type=text]').val();
	var password = $('#form_login').find('input[type=password]').val();

	var request = 'user_login';

	var vars = [username, password];

	var errs = 0;

	vars.map((value) => {
		if (value == '') {
			errs = errs + 1;
		}
	});

	if (errs == 0) {
		$.ajax({
			url: '/ajax_request',
			method: 'post',
			data: {
				username:username,
				password:password,
				request:request
			},
			success:function(data) {
				if (data == 'success') {
					window.location.href = '/';
				} else {
					$('#error-handler').show();
					$('#admin_err').html(data);

					hideErr();
				}
			}
		});
	} else {
		$('#error-handler').show();
		$('#admin_err').html(error_empty);

		hideErr();
	}
});

$('#submit_form_register').click(function() {
	event.preventDefault();
	var firstname = $('#form_register').find('input[id=firstname]').val();
	var lastname = $('#form_register').find('input[id=lastname]').val();
	var email = $('#form_register').find('input[id=email]').val();
	var phone_number = $('#form_register').find('input[id=phone_number]').val();
	var password = $('#form_register').find('input[id=password]').val();
	var confirm_password = $('#form_register').find('input[id=confirm_password]').val();

	var request = 'user_register';

	var vars = [firstname, lastname, email, phone_number, password, confirm_password];

	var errs = 0;

	vars.map((value) => {
		if (value == '') {
			errs = errs + 1;
		}
	});

	if (errs == 0) {
		if (password == confirm_password) {
			$.ajax({
				url: '/ajax_request',
				method: 'post',
				data: {
					firstname:firstname,
					lastname:lastname,
					email:email,
					phone_number:phone_number,
					password:password,
					confirm_password:confirm_password,
					request:request
				},
				success:function(data) {
					console.log(data);
					if (data == 'success') {
						window.location.href = '/register/success';
					} else {
						$('#error-handler').show();
						$('#admin_err').html(data);

						hideErr();
					}
				}
			});
		} else {
			$('#error-handler').show();
			$('#admin_err').html('Password does not match');

			hideErr();
		}
	} else {
		$('#error-handler').show();
		$('#admin_err').html(error_empty);

		hideErr();
	}
});

$('.book-button').click(function() {
	navigator.geolocation.getCurrentPosition(function(position) {
		console.log(position);
		$.ajax({
			method: 'post',
			url: '/api/book',
			data: {
				user_lat: position.coords.latitude,
				user_lng: position.coords.longitude
			},
			success:function(data) {
				window.location.href = '/map';
			}
		});
	});
})

$('button[name=submit_booking]').click(function() {
	event.preventDefault();

	var complete_address = $('input[name=complete_address]').val();
	var address_lat = $('input[name=address_lat]').val();
	var address_lng = $('input[name=address_lng]').val();

	var vars = [firstname, lastname, email, phone_number, password, confirm_password];

	var errs = 0;

	vars.map((value) => {
		if (value == '') {
			errs = errs + 1;
		}
	});

});