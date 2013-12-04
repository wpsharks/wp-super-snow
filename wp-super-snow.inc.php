<?php
namespace wp_super_snow // Root namespace.
	{
		if(!defined('WPINC')) // MUST have WordPress.
			exit('Do NOT access this file directly: '.basename(__FILE__));

		class plugin // Base plugin class.
		{
			public $is_pro = FALSE; // Lite version flag.
			public $file = ''; // Defined by class constructor.
			public $version = '131203'; // See: `readme.txt` file.
			public $text_domain = ''; // Defined by class constructor.
			public $default_options = array(); // Defined @ setup.
			public $options = array(); // Defined @ setup.
			public $cap = ''; // Defined @ setup.

			public function __construct() // Constructor.
				{
					if(strpos(__NAMESPACE__, '\\') !== FALSE) // Sanity check.
						throw new \exception('Not a root namespace: `'.__NAMESPACE__.'`.');

					$this->file        = preg_replace('/\.inc\.php$/', '.php', __FILE__);
					$this->text_domain = str_replace('_', '-', __NAMESPACE__);

					add_action('after_setup_theme', array($this, 'setup'));
					register_activation_hook($this->file, array($this, 'activate'));
					register_deactivation_hook($this->file, array($this, 'deactivate'));
				}

			public function setup()
				{
					do_action('before__'.__METHOD__, get_defined_vars());

					load_plugin_textdomain($this->text_domain);

					$this->default_options = array( // Default options.
						'version'                   => $this->version,

						'enable'                    => '1', // `0|1`.

						'container'                 => 'body',
						'flake'                     => '*',
						'flake_font_family'         => 'serif',
						'particles'                 => '75',
						'size'                      => '75',
						'z_index'                   => '9999999',

						'uninstall_on_deactivation' => '0' // `0|1`.
					); // Default options are merged with those defined by the site owner.
					$options               = (is_array($options = get_option(__NAMESPACE__.'_options'))) ? $options : array();
					$this->default_options = apply_filters(__METHOD__.'__default_options', $this->default_options, get_defined_vars());
					$this->options         = array_merge($this->default_options, $options); // This considers old options also.
					$this->options         = apply_filters(__METHOD__.'__options', $this->options, get_defined_vars());

					$this->cap = apply_filters(__METHOD__.'__cap', 'activate_plugins');

					add_action('wp_loaded', array($this, 'actions'));

					add_action('wp_head', array($this, 'enqueue_scripts'), -1);

					add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
					add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

					add_action('admin_init', array($this, 'check_version'));
					add_action('all_admin_notices', array($this, 'all_admin_notices'));
					add_action('all_admin_notices', array($this, 'all_admin_errors'));
					add_action('admin_menu', array($this, 'add_menu_pages'));

					do_action('after__'.__METHOD__, get_defined_vars());
					do_action(__METHOD__.'_complete', get_defined_vars());
				}

			public function activate()
				{
					$this->setup(); // Setup routines.
				}

			public function check_version()
				{
					if(version_compare($this->options['version'], $this->version, '>='))
						return; // Nothing to do in this case.

					$this->options['version'] = $this->version;
					update_option(__NAMESPACE__.'_options', $this->options);

					if(!$this->options['enable']) return; // Nothing more to do.

					$notices   = (is_array($notices = get_option(__NAMESPACE__.'_notices'))) ? $notices : array();
					$notices[] = __('<strong>WP Super Snow:</strong> detected a new version of itself. Recompiling w/ latest version... all done :-)', $this->text_domain);
					update_option(__NAMESPACE__.'_notices', $notices);
				}

			public function deactivate()
				{
					if(!$this->options['uninstall_on_deactivation'])
						return; // Nothing to do here.

					delete_option(__NAMESPACE__.'_options');
					delete_option(__NAMESPACE__.'_notices');
					delete_option(__NAMESPACE__.'_errors');
				}

			public function is_pro_preview()
				{
					static $is;
					if(isset($is)) return $is;

					if(!empty($_REQUEST[__NAMESPACE__.'_pro_preview']))
						return ($is = TRUE);

					return ($is = FALSE);
				}

			public function url($file = '', $scheme = '')
				{
					static $plugin_directory; // Static cache.

					if(!isset($plugin_directory)) // Not cached yet?
						$plugin_directory = rtrim(plugin_dir_url($this->file), '/');

					$url = $plugin_directory.(string)$file;

					if($scheme) // A specific URL scheme?
						$url = set_url_scheme($url, (string)$scheme);

					return apply_filters(__METHOD__, $url, get_defined_vars());
				}

			public function esc_sq($string, $times = 1)
				{
					return str_replace("'", str_repeat('\\', abs($times))."'", (string)$string);
				}

			public function actions()
				{
					if(empty($_REQUEST[__NAMESPACE__])) return;

					require_once dirname(__FILE__).'/includes/actions.php';
				}

			public function enqueue_scripts() // Scripts on-site.
				{
					if(!$this->options['enable'])
						return; // Nothing to do.

					$deps = array('jquery'); // Dependencies.

					wp_enqueue_script(__NAMESPACE__, $this->url('/client-s/js/wp-super-snow.min.js'), $deps, $this->version, TRUE);

					$_this = $this; // Reference used below.
					add_action('wp_footer', function () use ($_this)
						{
							echo '<script type="text/javascript">'."\n".
							     "  jQuery(document).ready(function($){"."\n".
							     "     $('".$_this->esc_sq($_this->options['container'])."').wpSuperSnow({"."\n".
							     "        flake: '".$_this->esc_sq($_this->options['flake'])."',"."\n".
							     "        flakeFontFamily: '".$_this->esc_sq($_this->options['flake_font_family'])."',"."\n".
							     "        particles: '".$_this->esc_sq($_this->options['particles'])."',"."\n".
							     "        size: '".$_this->esc_sq($_this->options['size'])."',"."\n".
							     "        zIndex: '".$_this->esc_sq($_this->options['z_index'])."'"."\n".
							     "     });"."\n".
							     "  });"."\n".
							     '</script>'."\n";
						}, PHP_INT_MAX);
				}

			public function enqueue_admin_styles()
				{
					if(empty($_GET['page']) || strpos($_GET['page'], __NAMESPACE__) !== 0)
						return; // Nothing to do; NOT a plugin page in the administrative area.

					$deps = array(); // Plugin dependencies.

					wp_enqueue_style(__NAMESPACE__, $this->url('/client-s/css/menu-pages.min.css'), $deps, $this->version, 'all');
				}

			public function enqueue_admin_scripts()
				{
					if(empty($_GET['page']) || strpos($_GET['page'], __NAMESPACE__) !== 0)
						return; // Nothing to do; NOT a plugin page in the administrative area.

					$deps = array('jquery'); // Plugin dependencies.

					wp_enqueue_script(__NAMESPACE__, $this->url('/client-s/js/menu-pages.min.js'), $deps, $this->version, TRUE);
				}

			public function add_menu_pages()
				{
					add_menu_page(__('WP Super Snow', $this->text_domain), // Menu page for plugin options/config.
					              __('WP Super Snow', $this->text_domain), $this->cap, __NAMESPACE__, array($this, 'menu_page_options'),
					              $this->url('/client-s/images/menu-icon.png'));
				}

			public function menu_page_options()
				{
					require_once dirname(__FILE__).'/includes/menu-pages.php';
					$menu_pages = new menu_pages();
					$menu_pages->options();
				}

			public function all_admin_notices()
				{
					$notices = (is_array($notices = get_option(__NAMESPACE__.'_notices'))) ? $notices : array();
					if($notices) delete_option(__NAMESPACE__.'_notices'); // Process one-time only.

					$notices = array_unique($notices); // Don't show dupes.

					if(current_user_can($this->cap)) foreach($notices as $_notice)
						echo apply_filters(__METHOD__.'__notice', '<div class="updated"><p>'.$_notice.'</p></div>', get_defined_vars());
					unset($_notice); // Housekeeping.
				}

			public function all_admin_errors()
				{
					$errors = (is_array($errors = get_option(__NAMESPACE__.'_errors'))) ? $errors : array();
					if($errors) delete_option(__NAMESPACE__.'_errors'); // Process one-time only.

					$errors = array_unique($errors); // Don't show dupes.

					if(current_user_can($this->cap)) foreach($errors as $_error)
						echo apply_filters(__METHOD__.'__error', '<div class="error"><p>'.$_error.'</p></div>', get_defined_vars());
					unset($_error); // Housekeeping.
				}
		}

		/**
		 * @return plugin Class instance.
		 */
		function plugin() // Easy reference.
			{
				return $GLOBALS[__NAMESPACE__];
			}

		$GLOBALS[__NAMESPACE__] = new plugin(); // New plugin instance.
	}