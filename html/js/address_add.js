var address_type = 0;

$('.content-address-type').click(function() {
	event.preventDefault();
	$('.content-address-type').removeClass('btn-success');

	$(this).addClass('btn-success');

	address_type = $(this).attr('data-value');
});

$('button[name=address_submit]').click(function() {
	event.preventDefault();

	var address_house = $('input[name=address_house]').val();
	var address_barangay = $('input[name=address_barangay]').val();
	var address_municipality = $('input[name=address_municipality]').val();
	var address_province = $('input[name=address_province]').val();
	var address_zip = $('input[name=address_zip]').val();

	var vars = [address_house, address_barangay, address_municipality, address_province, address_zip];

	var errs = 0;

	vars.map((value) => {
		if (value == '') {
			errs = errs + 1;
		}
	});

	if (address_type == 0) {
		$('#error-handler').show();
		$('#admin_err').html('Please select address type');

		hideErr();
	} else {
		if (errs > 0) {
			$('#error-handler').show();
			$('#admin_err').html(error_empty);

			hideErr();
		} else {
			$.ajax({
				url: 'api/add/address',
				method: 'post',
				data: {
					address_type:address_type,
					address_house: address_house,
					address_barangay: address_barangay,
					address_municipality: address_municipality,
					address_province: address_province,
					address_zip: address_zip
				},
				success:function(response) {
					var data = JSON.parse(response);

					if (data.result != 'error') {
						window.location.href = '/address';
					} else {
						console.log(data.error);
					}
				}
			});
		}
	}
});