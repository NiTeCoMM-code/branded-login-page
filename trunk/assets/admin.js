jQuery(function ($) {
	$('.clb-color-field').wpColorPicker();

	$(document).on('click', '.clb-upload-button', function (e) {
		e.preventDefault();

		var button = $(this);
		var target = $(button.data('target'));

		var frame = wp.media({
			title: 'Select Image',
			button: {
				text: 'Use this image'
			},
			multiple: false
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			target.val(attachment.url).trigger('change');
		});

		frame.open();
	});

	$(document).on('click', '.clb-clear-button', function (e) {
		e.preventDefault();

		var button = $(this);
		var target = $(button.data('target'));
		target.val('').trigger('change');
	});
});