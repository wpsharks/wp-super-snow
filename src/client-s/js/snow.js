(function($)
{
	'use strict'; // Strict standards.

	$.fn.wpSuperSnow = function(options) // Start snowing.
	{
		var i, left, visibility, duration, delay, size, wind, flake, $flake,
			$head = $('head'), $body = $('body'), $container, position, initialDelays,

			defaults = {
				flakes : [], totalFlakes: 50, zIndex: 999999,
				maxSize: 50, maxDuration: 25, useFlakeTrans: false
			},

			flakeOnlyWinds = ['wpSuperSnowFlake_l', 'wpSuperSnowFlake_r'],
			compatibleWinds = ['wpSuperSnow_l', 'wpSuperSnow_r'];

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
			 initialDelays = [0, 0, 1, 1, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9, 10]; // Start snowing immediately.

			 for($container = $(this), i = 1; i <= Number(options.totalFlakes); i++)
			 {
				 left = mtRand(0, 100);
				 visibility = mtRand(1, 9);
				 size = mtRand(1, Number(options.maxSize));

				 duration = mtRand(Math.floor(Number(options.maxDuration) / 5), Number(options.maxDuration));
				 delay = (initialDelays.length) ? initialDelays.shift() : mtRand(0, Math.floor(duration / 5));

				 flake = options.flakes[mtRand(0, options.flakes.length - 1)];
				 wind = (flake.indexOf('flake') !== -1) // Flakes can handle more complex winds.
					 ? flakeOnlyWinds[mtRand(0, flakeOnlyWinds.length - 1)] : compatibleWinds[mtRand(0, compatibleWinds.length - 1)];

				 $flake = $('<div class="wp-super-snow-flake"><img src="' + flake + '" /></div>');

				 $flake.css // Let it snow...
				 ({
					  'width': size + 'px', 'height': size + 'px',

					  'position': position,
					  'z-index' : Number(options.zIndex),
					  'left'    : left + '%', 'top': '-200px',
					  'opacity' : '0',

					  'user-select'        : 'none',
					  '-webkit-user-select': 'none',
					  '-moz-user-select'   : 'none',
					  '-ms-user-select'    : 'none',

					  'backface-visibility'        : 'visible',
					  '-webkit-backface-visibility': 'visible',
					  '-moz-backface-visibility'   : 'visible',
					  '-ms-backface-visibility'    : 'visible',

					  'animation'        : wind + ' ' + duration + 's infinite', 'animation-delay': delay + 's',
					  '-webkit-animation': wind + ' ' + duration + 's infinite', '-webkit-animation-delay': delay + 's',
					  '-moz-animation'   : wind + ' ' + duration + 's infinite', '-moz-animation-delay': delay + 's',
					  '-ms-animation'    : wind + ' ' + duration + 's infinite', '-ms-animation-delay': delay + 's'
				  }),
					 $('img', $flake).css({
						                      width  : '100%', height: 'auto', border: 0,
						                      opacity: (options.useFlakeTrans) ? '.' + visibility : 1
					                      });
				 $container.append($flake);
			 }
		 });
	}; // Winds w/ both a left and right rotation. Compatible with a variety of graphics; including snowballs.

	$.wpSuperSnowCSS = '@keyframes wpSuperSnow_l {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; transform:translate3D(500px,1500px,0) rotate(250deg);}}';
	$.wpSuperSnowCSS += '@keyframes wpSuperSnow_r {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; transform:translate3D(-500px,1500px,0) rotate(-500deg);}}';

	$.wpSuperSnowCSS += '@-webkit-keyframes wpSuperSnow_l {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(500px,1500px,0) rotate(250deg);}}';
	$.wpSuperSnowCSS += '@-webkit-keyframes wpSuperSnow_r {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(-500px,1500px,0) rotate(-500deg);}}';

	$.wpSuperSnowCSS += '@-moz-keyframes wpSuperSnow_l {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(500px,1500px,0) rotate(250deg);}}';
	$.wpSuperSnowCSS += '@-moz-keyframes wpSuperSnow_r {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(-500px,1500px,0) rotate(-500deg);}}';

	$.wpSuperSnowCSS += '@-ms-keyframes wpSuperSnow_l {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -ms-transform:translate3D(500px,1500px,0) rotate(250deg);}}';
	$.wpSuperSnowCSS += '@-ms-keyframes wpSuperSnow_r {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -ms-transform:translate3D(-500px,1500px,0) rotate(-500deg);}}';

	// Winds w/ both a left and right rotation; plus a Y-axis rotation for 3D spinning. Suitable for true snowflakes only.

	$.wpSuperSnowCSS += '@keyframes wpSuperSnowFlake_l {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; transform:translate3D(500px,1500px,0) rotateY(720deg) rotate(250deg);}}';
	$.wpSuperSnowCSS += '@keyframes wpSuperSnowFlake_r {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; transform:translate3D(-500px,1500px,0) rotateY(-720deg) rotate(-500deg);}}';

	$.wpSuperSnowCSS += '@-webkit-keyframes wpSuperSnowFlake_l {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(500px,1500px,0) rotateY(720deg) rotate(250deg);}}';
	$.wpSuperSnowCSS += '@-webkit-keyframes wpSuperSnowFlake_r {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -webkit-transform:translate3D(-500px,1500px,0) rotateY(-720deg) rotate(-500deg);}}';

	$.wpSuperSnowCSS += '@-moz-keyframes wpSuperSnowFlake_l {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(500px,1500px,0) rotateY(720deg) rotate(250deg);}}';
	$.wpSuperSnowCSS += '@-moz-keyframes wpSuperSnowFlake_r {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -moz-transform:translate3D(-500px,1500px,0) rotateY(-720deg) rotate(-500deg);}}';

	$.wpSuperSnowCSS += '@-ms-keyframes wpSuperSnowFlake_l {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -ms-transform:translate3D(500px,1500px,0) rotateY(720deg) rotate(250deg);}}';
	$.wpSuperSnowCSS += '@-ms-keyframes wpSuperSnowFlake_r {0% {opacity:0;} 25% {opacity:1;} 100% {opacity:0; -ms-transform:translate3D(-500px,1500px,0) rotateY(-720deg) rotate(-500deg);}}';
})(jQuery);
