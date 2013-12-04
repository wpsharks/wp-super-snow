(function($)
	{
		'use strict'; // Strict standards.

		$.fn.wpSuperSnow = function(options) // Start snowing.
			{
				var i, left, visibility, duration, delay, size, wind, flake, $flake,
					$head = $('head'), $body = $('body'), $container, position,
					defaults = {flakes: [], totalFlakes: 50, zIndex: 9999999,
						maxSize        : 50, maxDuration: 25, useFlakeTrans: true},
					winds = ['wpSuperSnowL', 'wpSuperSnowR'];

				options = $.extend({}, defaults, options); // Extend default options.
				if(!options.flakes.length) return this; // We have no flakes to display.

				if($.wpSuperSnowCSS) // This property is emptied each time; e.g. we do this ONE-time-only.
					$head.append('<style type="text/css">' + $.wpSuperSnowCSS + '</style>'), $.wpSuperSnowCSS = '';

				var mtRand = function(min, max)
					{
						min = (typeof min === 'number') ? min : 0;
						max = (typeof max === 'number') ? max : Number.MAX_VALUE;
						return Math.floor(Math.random() * (max - min + 1)) + min;
					};
				return this.each // A jQuery object array; we iterate all containers.
				(function() // Each of these are containers sharing the same `options`.
				 {
					 $container = $(this), position = 'fixed'; // Default positioning.
					 if($.inArray($container[0].nodeName.toLowerCase(), ['html', 'body']) === -1)
						 $container.css({position: 'relative', overflow: 'hidden'}), position = 'absolute';

					 for($container = $(this), i = 1; i <= Number(options.totalFlakes); i++)
						 {
							 left = mtRand(0, 100);
							 visibility = mtRand(1, 9);
							 size = mtRand(1, Number(options.maxSize));

							 duration = mtRand(Math.floor(Number(options.maxDuration) / 4),
							                   Number(options.maxDuration));
							 delay = mtRand(1, duration);

							 wind = winds[mtRand(0, winds.length - 1)];
							 flake = options.flakes[mtRand(0, options.flakes.length - 1)];

							 $flake = $('<div class="wp-super-snow-flake"><img src="' + flake + '" /></div>');

							 $flake.css // Let it snow...
							 ({'width': size + 'px', 'height': size + 'px',

								  'position': position,
								  'z-index' : Number(options.zIndex),
								  'left'    : left + '%', 'top': '0',
								  'opacity' : '0',

								  '-webkit-user-select': 'none',
								  '-moz-user-select'   : 'none',
								  'user-select'        : 'none',

								  'animation'        : wind + ' ' + duration + 's infinite', 'animation-delay': delay + 's',
								  '-webkit-animation': wind + ' ' + duration + 's infinite', '-webkit-animation-delay': delay + 's',
								  '-moz-animation'   : wind + ' ' + duration + 's infinite', '-moz-animation-delay': delay + 's'
							  }),
								 $('img', $flake).css({width    : '100%', height: 'auto', border: 0,
									                      opacity: (options.useFlakeTrans) ? '.' + visibility : 1});

							 $container.append($flake);
						 }
				 });
			};
		$.wpSuperSnowCSS = '@keyframes wpSuperSnowL {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; transform:translate3D(100px,1500px,100px) rotate(250deg);}}';
		$.wpSuperSnowCSS += '@keyframes wpSuperSnowR {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; transform:translate3D(-100px,1500px,-100px) rotate(-500deg);}}';

		$.wpSuperSnowCSS += '@-webkit-keyframes wpSuperSnowL {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(100px,1500px,100px) rotate(250deg);}}';
		$.wpSuperSnowCSS += '@-webkit-keyframes wpSuperSnowR {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(-100px,1500px,-100px) rotate(-500deg);}}';

		$.wpSuperSnowCSS += '@-moz-keyframes wpSuperSnowL {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(100px,1500px,0) rotate(250deg);}}';
		$.wpSuperSnowCSS += '@-moz-keyframes wpSuperSnowR {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(-100px,1500px,0) rotate(-500deg);}}';
	})(jQuery);