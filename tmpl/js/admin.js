

/** global: OC */

var elements = {
	test_{{app_id}}: null
};

$(document).ready(function () {

	elements.test_{{app_id}} = $('#test_{{app_id}}');
	elements.test_{{app_id}}.on('change', function () {
		saveChange();
	});


	saveChange = function () {
		$.ajax({
			method: 'POST',
			url: OC.generateUrl('/apps/{{app_id}}/settings/admin'),
			data: {
				data: {
					test_{{app_id}}: (elements.test_{{app_id}}.is(':checked')) ? '1' : '0'
				}
			}

		}).done(function (res) {
			self.refreshSettings(res);
		});
	};

	refreshSettings = function (result) {
		elements.test_{{app_id}}.prop('checked', (result.test_{{app_id}} === '1'));
	};

	$.ajax({
		method: 'GET',
		url: OC.generateUrl('/apps/{{app_id}}/settings/admin'),
		data: {}
	}).done(function (res) {
		self.refreshSettings(res);
	});


});