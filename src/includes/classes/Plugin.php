<?php
namespace WebSharks\WpSuperSnow;

class Plugin extends AbsBase
{
    public $file = '';
    public $cap  = '';

    public $default_options = array();
    public $options         = array();

    public function __construct()
    {
        parent::__construct();

        $plugin_dir = dirname(dirname(dirname(__FILE__)));
        $this->file = $plugin_dir.'/wp-super-snow.php';

        add_action('after_setup_theme', array($this, 'setup'));
        register_activation_hook($this->file, array($this, 'activate'));
        register_deactivation_hook($this->file, array($this, 'deactivate'));
    }

    public function setup()
    {
        do_action('before_'.__METHOD__);

        load_plugin_textdomain('wp-super-snow');

        $this->default_options = array(
            'version' => $this::VERSION,

            'enable' => '0', // `0|1`.

            'container' => 'body',
            'z_index'   => '999999',

            'flakes' => $this->url('/client-s/images/snowflake.png', 'relative')."\n".
                        $this->url('/client-s/images/snowball.png', 'relative'),

            'total_flakes'    => '50',
            'max_size'        => '50',
            'max_duration'    => '25',
            'use_flake_trans' => '0',

            'conditionals' => '!wp_is_mobile()',

            'uninstall_on_deactivation' => '0',
        ); // Default options are merged with those defined by the site owner.

        $options               = is_array($options = get_option($this::GLOBAL_NS.'_options')) ? $options : array();
        $this->default_options = apply_filters(__METHOD__.'_default_options', $this->default_options, get_defined_vars());
        $this->options         = array_merge($this->default_options, $options); // This considers old options also.
        $this->options         = apply_filters(__METHOD__.'_options', $this->options, get_defined_vars());

        $this->cap = apply_filters(__METHOD__.'_cap', 'activate_plugins');

        add_action('wp_loaded', array($this, 'actions'));

        add_action('wp_head', array($this, 'enqueueScripts'), -1);

        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminStyles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));

        add_action('admin_init', array($this, 'checkVersion'));
        add_action('all_admin_notices', array($this, 'allAdminNotices'));
        add_action('all_admin_notices', array($this, 'allAdminErrors'));
        add_action('admin_menu', array($this, 'addMenuPages'));

        do_action('after_'.__METHOD__, get_defined_vars());
        do_action(__METHOD__.'_complete', get_defined_vars());
    }

    public function activate()
    {
        $this->setup();
    }

    public function checkVersion()
    {
        if (version_compare($this->options['version'], $this::VERSION, '>=')) {
            return; // Nothing to do in this case.
        }
        $this->options['version'] = $this::VERSION;
        update_option($this::GLOBAL_NS.'_options', $this->options);

        $notices   = is_array($notices = get_option($this::GLOBAL_NS.'_notices')) ? $notices : array();
        $notices[] = __('<strong>WP Super Snow:</strong> detected a new version of itself. Recompiling w/ latest version... all done :-)', 'wp-super-snow');
        update_option($this::GLOBAL_NS.'_notices', $notices);
    }

    public function deactivate()
    {
        if (!$this->options['uninstall_on_deactivation']) {
            return; // Nothing to do here.
        }
        delete_option($this::GLOBAL_NS.'_options');
        delete_option($this::GLOBAL_NS.'_notices');
        delete_option($this::GLOBAL_NS.'_errors');
    }

    public function actions()
    {
        if (!empty($_REQUEST[$this::GLOBAL_NS])) {
            new Actions();
        }
    }

    public function url($file = '', $scheme = '')
    {
        static $dir_url; // Static cache.

        if (!isset($dir_url)) { // Not cached yet?
            $dir_url = rtrim(plugin_dir_url($this->file), '/');
        }
        $url = $dir_url.(string) $file;

        if ($scheme) { // A specific URL scheme?
            $url = set_url_scheme($url, (string) $scheme);
        }
        return $url;
    }

    public function escSq($string, $times = 1)
    {
        return str_replace("'", str_repeat('\\', abs($times))."'", (string) $string);
    }

    public function isMultisiteFarmBlog()
    {
        return defined('MULTISITE_FARM') && MULTISITE_FARM && !is_main_site();
    }

    public function forecastsSnow()
    {
        if (!$this->options['enable']) {
            $snow = false;
        } elseif ($this->isMultisiteFarmBlog() && wp_is_mobile()) {
            $snow = false;
        } elseif (!$this->isMultisiteFarmBlog() && $this->options['conditionals']
            && !eval('return ('.$this->options['conditionals'].');')) {
            $snow = false;
        } else {
            $snow = true;
        }
        return $snow = apply_filters(__METHOD__, $snow);
    }

    public function enqueueScripts()
    {
        if (!$this->options['enable']) {
            return; // Nothing to do.
        }
        if (!$this->forecastsSnow()) {
            return; // Nothing to do.
        }
        $_this  = $this; // Reference used below.
        $flakes = preg_split('/['."\r\n".']+/', $this->options['flakes'], -1, PREG_SPLIT_NO_EMPTY);

        wp_enqueue_script($this::GLOBAL_NS, $this->url('/client-s/js/snow.min.js'), array('jquery'), $this::VERSION, true);

        add_action('wp_footer', function () use ($_this, $flakes) {
            echo '<script type="text/javascript">'."\n".
                 '  jQuery(document).ready(function($){'."\n".
                 "     $('".$_this->escSq($_this->options['container'])."').wpSuperSnow({"."\n".
                 "        flakes: ['".implode("','", array_map(array($_this, 'escSq'), $flakes))."'],"."\n".
                 "        totalFlakes: '".$_this->escSq($_this->options['total_flakes'])."',"."\n".
                 "        zIndex: '".$_this->escSq($_this->options['z_index'])."',"."\n".
                 "        maxSize: '".$_this->escSq($_this->options['max_size'])."',"."\n".
                 "        maxDuration: '".$_this->escSq($_this->options['max_duration'])."',"."\n".
                 '        useFlakeTrans: '.($_this->options['use_flake_trans'] ? 'true' : 'false')."\n".
                 '     });'."\n".
                 '  });'."\n".
                 '</script>'."\n";
        }, PHP_INT_MAX);
    }

    public function enqueueAdminStyles()
    {
        if (empty($_GET['page']) || strpos($_GET['page'], $this::GLOBAL_NS) !== 0) {
            return; // Nothing to do; NOT a plugin page in the administrative area.
        }
        wp_enqueue_style($this::GLOBAL_NS, $this->url('/client-s/css/menu-pages.min.css'), array(), $this::VERSION, 'all');
    }

    public function enqueueAdminScripts()
    {
        if (empty($_GET['page']) || strpos($_GET['page'], $this::GLOBAL_NS) !== 0) {
            return; // Nothing to do; NOT a plugin page in the administrative area.
        }
        wp_enqueue_script($this::GLOBAL_NS, $this->url('/client-s/js/snow.min.js'), array('jquery'), $this::VERSION, true);
        wp_enqueue_script($this::GLOBAL_NS.'-menu-pages', $this->url('/client-s/js/menu-pages.min.js'), array('jquery'), $this::VERSION, true);
    }

    public function addMenuPages()
    {
        add_menu_page(__('Super Snow', 'wp-super-snow'), // Menu page for plugin options/config.
                      __('Super Snow', 'wp-super-snow'), $this->cap, $this::GLOBAL_NS, array($this, 'menuPageOptions'),
                      $this->url('/client-s/images/menu-icon.png'));
    }

    public function menuPageOptions()
    {
        new menu_pages('options');
    }

    public function allAdminNotices()
    {
        if (!is_array($notices = get_option($this::GLOBAL_NS.'_notices'))) {
            $notices = array(); // Force array.
        }
        if (($notices = array_unique($notices))) {
            delete_option($this::GLOBAL_NS.'_notices');
        }
        if (current_user_can($this->cap)) {
            foreach ($notices as $_notice) {
                echo '<div class="updated"><p>'.$_notice.'</p></div>';
            } // unset($_notice); // Housekeeping.
        }
    }

    public function allAdminErrors()
    {
        if (!is_array($errors = get_option($this::GLOBAL_NS.'_errors'))) {
            $errors = array(); // Force array.
        }
        if (($errors = array_unique($errors))) {
            delete_option($this::GLOBAL_NS.'_errors');
        }
        if (current_user_can($this->cap)) {
            foreach ($errors as $_error) {
                echo '<div class="error"><p>'.$_error.'</p></div>';
            } // unset($_error); // Housekeeping.
        }
    }
}
