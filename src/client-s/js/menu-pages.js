(function ($) {
  'use strict';

  var plugin = {},
    $window = $(window),
    $document = $(document);

  plugin.onReady = function () {
    postboxes.save_state = function () {};
    postboxes.save_order = function () {};
    postboxes.add_postbox_toggles(window.pagenow);

    var $menuPage = $('.plugin-menu-page');

    $('[data-action]', $menuPage).on('click', function () {
      var $this = $(this),
        data = $this.data();
      if (typeof data.confirmation !== 'string' || confirm(data.confirmation))
        location.href = data.action;
    });

    $('.-vsb-button', $menuPage).on('click', function (event) {
      var $vsb = $('.-vsb', $menuPage);
      $('.wp-super-snow-flake', $vsb).remove();

      $vsb.wpSuperSnow({
        flakes: $.trim($('[name$="\\[flakes\\]"]', $menuPage).val()).split(/[\r\n]+/),
        totalFlakes: $.trim($('[name$="\\[total_flakes\\]"]', $menuPage).val()),
        zIndex: $.trim($('[name$="\\[z_index\\]"]', $menuPage).val()),
        maxSize: $.trim($('[name$="\\[max_size\\]"]', $menuPage).val()),
        maxDuration: $.trim($('[name$="\\[max_duration\\]"]', $menuPage).val()),
        useFlakeTrans: $.trim($('[name$="\\[use_flake_trans\\]"]', $menuPage).val()) === '1'
      });
    }).trigger('click');
  };
  $document.ready(plugin.onReady);
})(jQuery);
