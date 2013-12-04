(function($)
	{
		'use strict'; // Strict standards.

		$.fn.wpSuperSnow = function(options) // Start snowing.
			{
				var i, css = '', $head = $('head'), $body = $('body'), $container,
					defaults = {flake: '*', flakeFontFamily: 'serif', particles: 75, size: 75, zIndex: 9999999},
					winds = ['wpSuperSnowL', 'wpSuperSnowR'];

				options = $.extend({}, defaults, options); // Extend default options.

				if($.wpSuperSnowCSS) // This property is emptied each time; e.g. we do this ONE-time-only.
					$head.append('<style type="text/css">' + $.wpSuperSnowCSS + '</style>'), $.wpSuperSnowCSS = '';

				return this.each // A jQuery object array; we iterate all items.
				(function() // Each of these are containers sharing the same `options`.
				 {
					 for($container = $(this), i = 1; i <= options.particles; i++) // Snowflakes.
						 $container.append('<div class="wp-super-snow-flake">' + options.flake + '</div>');

					 $('.wp-super-snow-flake', $container).each // Snowflakes.
					 (function() // Iterating each snowflake inside this container.
					  {
						  var duration = (Math.random() * 10) + 20;
						  var left = Math.round(Math.random() * 100);
						  var visibility = Math.round(Math.random() * 10);
						  var delay = Math.round(Math.random() * duration);
						  var wind = winds[Math.round(Math.random() * winds.length)];
						  var size = Math.round(Math.random() * options.size) + 8;

						  $(this).css // Let it snow...
						  ({'width': size + 'px', 'height': size + 'px',

							   'font-family': options.flakeFontFamily,
							   'font-size'  : size + 'px', 'line-height': size + 'px',
							   'color'      : 'rgba(255,255,255,.' + visibility + ')',
							   'text-shadow': '0 0 10px rgba(255,255,255,.' + visibility + ')',

							   'position': 'fixed',
							   'z-index' : options.zIndex,
							   'left'    : left + '%', 'top': '0',
							   'opacity' : '0',

							   'animation'        : wind + ' ' + duration + 's infinite', 'animation-delay': delay + 's',
							   '-webkit-animation': wind + ' ' + duration + 's infinite', '-webkit-animation-delay': delay + 's',
							   '-moz-animation'   : wind + ' ' + duration + 's infinite', '-moz-animation-delay': delay + 's'
						   });
					  });
				 });
			};
		$.wpSuperSnowCSS = '@keyframes wpSuperSnowL {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; transform:translate3D(100px,1500px,0); rotate(250deg);}}';
		$.wpSuperSnowCSS += '@keyframes wpSuperSnowR {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; transform:translate3D(-100px,1500px,0); rotate(-500deg);}}';

		$.wpSuperSnowCSS += '@-webkit-keyframes wpSuperSnowL {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(100px,1500px,0); rotate(250deg);}}';
		$.wpSuperSnowCSS += '@-webkit-keyframes wpSuperSnowR {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(-100px,1500px,0); rotate(-500deg);}}';

		$.wpSuperSnowCSS += '@-moz-keyframes wpSuperSnowL {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(100px,1500px,0); rotate(250deg);}}';
		$.wpSuperSnowCSS += '@-moz-keyframes wpSuperSnowR {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(-100px,1500px,0); rotate(-500deg);}}';
	})(jQuery);