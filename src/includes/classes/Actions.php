<?php
namespace WebSharks\WpSuperSnow;

class Actions extends AbsBase
{
    protected $allowed_actions = [
        'saveOptions',
        'restoreDefaultOptions',
    ];

    public function __construct(Plugin $Plugin)
    {
        parent::__construct($Plugin);

        if (empty($_REQUEST[$this::GLOBAL_NS])) {
            return; // Nothing to do.
        }
        foreach ((array) $_REQUEST[$this::GLOBAL_NS] as $action => $args) {
            if (in_array($action, $this->allowed_actions, true) && method_exists($this, $action)) {
                $this->{$action}($args);
            }
        }
    }

    public function saveOptions($args)
    {
        $args = (array) $args;

        if (!current_user_can($this->Plugin->cap)) {
            return; // Nothing to do.
        }
        if (empty($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'])) {
            return; // Unauthenticated POST data.
        }
        $options = stripslashes_deep($args);
        $options = array_map('trim', array_map('strval', $options));

        $this->Plugin->options = array_merge($this->Plugin->default_options, $options);
        $this->Plugin->options = array_intersect_key($this->Plugin->options, $this->Plugin->default_options);
        update_option($this::GLOBAL_NS.'_options', $this->Plugin->options);

        $redirect_to = self_admin_url('/admin.php');
        $query_args  = [
            $this::GLOBAL_NS.'_updated' => '1',
            'page'                      => $this::GLOBAL_NS,
        ];
        $redirect_to = add_query_arg(urlencode_deep($query_args), $redirect_to);

        wp_redirect($redirect_to);
        exit; // Stop here.
    }

    public function restoreDefaultOptions()
    {
        if (!current_user_can($this->Plugin->cap)) {
            return; // Nothing to do.
        }
        if (empty($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'])) {
            return; // Unauthenticated POST data.
        }
        delete_option($this::GLOBAL_NS.'_options');
        $this->Plugin->options = $this->Plugin->default_options;

        $redirect_to = self_admin_url('/admin.php');
        $query_args  = [
             $this::GLOBAL_NS.'_restored' => '1',
            'page'                        => $this::GLOBAL_NS,
        ];
        $redirect_to = add_query_arg(urlencode_deep($query_args), $redirect_to);

        wp_redirect($redirect_to);
        exit; // Stop here.
    }
}
