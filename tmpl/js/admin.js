
$(document).ready(function () {

	elements.allow_linked_groups = $('#allow_linked_groups');
	elements.allow_federated_circles = $('#allow_federated_circles');

	elements.allow_linked_groups.on('change', function () {
		saveChange();
	});
	elements.allow_federated_circles.on('change', function () {
		saveChange();
	});

	saveChange = function () {
		$.ajax({
			method: 'POST',
			url: OC.generateUrl('/apps/circles/admin/settings'),
			data: {
				allow_linked_groups: (elements.allow_linked_groups.is(
					':checked')) ? '1' : '0',
				allow_federated_circles: (elements.allow_federated_circles.is(
					':checked')) ? '1' : '0'
			}
		}).done(function (res) {
			elements.allow_linked_groups.prop('checked', (res.allowLinkedGroups === '1'));
			elements.allow_federated_circles.prop('checked', (res.allowFederatedCircles === '1'));
		});
	};

	$.ajax({
		method: 'GET',
		url: OC.generateUrl('/apps/circles/admin/settings'),
		data: {}
	}).done(function (res) {
		elements.allow_linked_groups.prop('checked', (res.allowLinkedGroups === '1'));
		elements.allow_federated_circles.prop('checked', (res.allowFederatedCircles === '1'));
	});

});