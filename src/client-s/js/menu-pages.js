(function($)
{
	'use strict'; // Standards.

	var plugin = {}, $window = $(window), $document = $(document);

	plugin.onReady = function() // jQuery DOM ready event handler.
	{
		var $menuPage = $('#plugin-menu-page');

		$('.plugin-menu-page-panels-open', $menuPage).on('click', function()
		{
			$('.plugin-menu-page-panel-heading', $menuPage).addClass('open')
				.next('.plugin-menu-page-panel-body').addClass('open');
		});
		$('.plugin-menu-page-panels-close', $menuPage).on('click', function()
		{
			$('.plugin-menu-page-panel-heading', $menuPage).removeClass('open')
				.next('.plugin-menu-page-panel-body').removeClass('open');
		});
		$('.plugin-menu-page-panel-heading', $menuPage).on('click', function()
		{
			$(this).toggleClass('open').next('.plugin-menu-page-panel-body').toggleClass('open');
		});
		$('[data-action]', $menuPage).on('click', function()
		{
			var $this = $(this), data = $this.data();
			if(typeof data.confirmation !== 'string' || confirm(data.confirmation))
				location.href = data.action;
		});
		$('select[name$="_enable\\]"], select[name$="_enable_flavor\\]"]', $menuPage).on('change', function()
		{
			var $this = $(this), thisName = $this[0].name, thisValue = $this.val(),
				$thisPanel = $this.closest('.plugin-menu-page-panel');

			if((thisName.indexOf('_enable]') !== -1 && (thisValue === '' || thisValue === '1'))
			   || (thisName.indexOf('_flavor]') !== -1 && thisValue !== '0')) // Enabled?
				$thisPanel.find('.plugin-menu-page-panel-if-enabled').css('opacity', 1).find(':input').removeAttr('disabled');
			else $thisPanel.find('.plugin-menu-page-panel-if-enabled').css('opacity', 0.4).find(':input').attr('disabled', 'disabled');
		})
			.trigger('change'); // Initialize.

		$('.plugin-virtual-snow-blower-preview')
			.click(function() // Based on current settings.
			       {
				       var $vsb = $('.plugin-virtual-snow-blower', $menuPage);
				       $('.wp-super-snow-flake', $vsb).remove(); // Remove any existing snowflakes.
				       $vsb.wpSuperSnow({
					                        flakes       : $.trim($('[name$="\\[flakes\\]"]', $menuPage).val()).split(/[\r\n]+/),
					                        totalFlakes  : $.trim($('[name$="\\[total_flakes\\]"]', $menuPage).val()),
					                        zIndex       : $.trim($('[name$="\\[z_index\\]"]', $menuPage).val()),
					                        maxSize      : $.trim($('[name$="\\[max_size\\]"]', $menuPage).val()),
					                        maxDuration  : $.trim($('[name$="\\[max_duration\\]"]', $menuPage).val()),
					                        useFlakeTrans: $.trim($('[name$="\\[use_flake_trans\\]"]', $menuPage).val()) === '1'
				                        });
			       }).trigger('click');
	};
	$document.ready(plugin.onReady); // On DOM ready.
})(jQuery);
