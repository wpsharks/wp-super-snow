(function($)
	{
		'use strict'; // Strict standards.

		$(document).ready( // On DOM ready handler.
			function() // Normally this is called ONE time only.
			{
				var _i, css = '', $window = $(window), $document = $(document), $body = $('body'),
					defaults = {flake: '*', flakeFontFamily: 'serif', particles: 75, size: 75, zIndex: 9999999},
					winds = ['wpSuperSnowL', 'wpSuperSnowR'];

				var options = (typeof window.wpSuperSnowOptions === 'object') ? window.wpSuperSnowOptions : {};
				options = $.extend({}, defaults, options);

				css += '@keyframes wpSuperSnowL {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; transform:translate3D(100px,1500px,0) rotate(250deg);}}';
				css += '@keyframes wpSuperSnowR {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; transform:translate3D(-100px,1500px,0) rotate(-500deg);}}';

				css += '@-webkit-keyframes wpSuperSnowL {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(100px,1500px,0) rotate(250deg);}}';
				css += '@-webkit-keyframes wpSuperSnowR {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(-100px,1500px,0) rotate(-500deg);}}';

				css += '@-moz-keyframes wpSuperSnowL {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(100px,1500px,0) rotate(250deg);}}';
				css += '@-moz-keyframes wpSuperSnowR {0% {opacity:0;} 50% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(-100px,1500px,0) rotate(-500deg);}}';

				$('head').append('<style type="text/css">' + css + '</style>');
				for(_i = 1; _i <= options.particles; _i++) $body.append('<div class="wp-super-snow">' + options.flake + '</div>');

				$('div.wp-super-snow').each( // Particles.
					function()
					{
						var duration = (Math.random() * 10) + 20;
						var left = Math.round(Math.random() * 100);
						var visibility = Math.round(Math.random() * 10);
						var delay = Math.round(Math.random() * duration);
						var wind = winds[Math.round(Math.random() * winds.length)];
						var size = Math.round(Math.random() * options.size) + 8;

						$(this).css({'font-size'    : size,
							            'font-family': options.flakeFontFamily,
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
	})(jQuery);