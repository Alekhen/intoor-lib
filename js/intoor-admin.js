/**
 * Интоор Library Admin JS Object
 *
 * @require jquery.js
 * @version 1.0
 */

(function($) {

var IntoorAdmin = {

	init: function() {

		this.setMetaBoxToggles();
		this.setMetaBoxCheckboxContainers();
		this.setMetaBoxButtons();
		this.setPopularMetaBox();
		this.setTrackingAdminMenu();

	},

	setMetaBoxToggles: function() {

		$('input[type="checkbox"]').on('change', function() {
			var id = $(this).attr('id'),
				hidden = $(this).parent().find('#hidden-' + id),
				val = ($(this).is(':checked')) ? '1' : '0';
			hidden.val(val);
		});

	},

	setMetaBoxCheckboxContainers: function() {

		$('.contained-checkbox').on('change', function() {
			var value = $(this).val(),
				controller = $(this).parent().parent().parent().parent().parent().find('.checkbox-container-controller'),
				controllerValue = controller.val(),
				newControllerValue = '';
			if($(this).is(':checked')) {
				if( controllerValue === '' ) {
					controller.val(value);
				} else {
					newControllerValue = controllerValue + ',' + value;
					newControllerValue.replace(',,', ',');
					controller.val(newControllerValue);
				}
			} else {
				newControllerValue = controllerValue.replace(value, '').replace(',,', ',').replace(/,$/, '').replace(/^,/, '');
				controller.val(newControllerValue);
			}
		});

	},

	setMetaBoxButtons: function() {

		$('.meta-box-restore-defaults').on('click', function(e) {
			e.preventDefault();
			var conf = confirm('Are you sure you want to reset this meta box with the default values?');
			if(conf){
				var box = $(this).parent().parent();
				var id = box.find('.meta-box-form-section .meta-box-section-id').val();
				var defaults = box.find('.meta-box-form-defaults').html();
				box.find('.meta-box-form-section').remove();
				box.find('.meta-box-buttons').before('<div class="meta-box-form-section">' + defaults + '</div>');
				box.find('.meta-box-form-section .meta-box-section-id').val(id);
				IntoorAdmin.setMetaBoxToggles();
			}
		});

		$('.meta-box-add-form-section').on('click', function(e) {
			e.preventDefault();
			var box = $(this).parent().parent();
			var defaults = box.find('.meta-box-form-defaults').html();
			box.find('.meta-box-buttons').before('<div class="meta-box-form-section">' + defaults + '</div>');
			IntoorAdmin.setMetaBoxToggles();
		});

		$('.meta-box-remove-form-section').on('click', function(e) {
			e.preventDefault();
			var box = $(this).parent().parent();
			var section = box.find('.meta-box-form-section').last();
			section.css('display', 'none').removeClass('meta-box-form-section').addClass('meta-box-form-section-disabled');
			section.find('.meta-box-section-id').val('-' + section.find('.meta-box-section-id').val());
		});

	},

	setPopularMetaBox: function() {

		var popularCount = 0,
			temp;

		$('#popular-posts-popular').on('change', function() {
			temp = parseInt($('#total-popular-count').text());
			if($(this).is(':checked')) {
				popularCount = temp + 1;
			} else {
				popularCount = temp - 1;
			}
			$('#total-popular-count').text(popularCount);
		});

	},

	setTrackingAdminMenu: function() {

		var form, temp;

		$('#add-param').on('click', function() {
			form = $(this).parent().parent();
			temp = form.find('table#template tr').html();
			form.find('table.form-table tbody').append('<tr>' + temp + '</tr>');
		});

	}

};

$(function() {
	IntoorAdmin.init();
});

})(jQuery);