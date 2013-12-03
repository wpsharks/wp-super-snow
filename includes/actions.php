<?php
namespace wp_super_snow // Root namespace.
	{
		if(!defined('WPINC')) // MUST have WordPress.
			exit('Do NOT access this file directly: '.basename(__FILE__));

		class actions // Action handlers.
		{
			public function __construct()
				{
					if(empty($_REQUEST[__NAMESPACE__])) return;
					foreach((array)$_REQUEST[__NAMESPACE__] as $action => $args)
						if(method_exists($this, $action)) $this->{$action}($args);
				}

			public function save_options($args)
				{
					if(!current_user_can(plugin()->cap))
						return; // Nothing to do.

					if(empty($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce']))
						return; // Unauthenticated POST data.

					$args             = array_map('trim', stripslashes_deep((array)$args));
					plugin()->options = array_merge(plugin()->default_options, $args);
					update_option(__NAMESPACE__.'_options', $args);

					$redirect_to = self_admin_url('/admin.php'); // Redirect preparations.
					$query_args  = array('page' => __NAMESPACE__, __NAMESPACE__.'__updated' => '1');
					$redirect_to = add_query_arg(urlencode_deep($query_args), $redirect_to);

					wp_redirect($redirect_to).exit(); // All done :-)
				}

			public function restore_default_options($args)
				{
					if(!current_user_can(plugin()->cap))
						return; // Nothing to do.

					if(empty($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce']))
						return; // Unauthenticated POST data.

					delete_option(__NAMESPACE__.'_options');

					$redirect_to = self_admin_url('/admin.php'); // Redirect preparations.
					$query_args  = array('page' => __NAMESPACE__, __NAMESPACE__.'__restored' => '1');
					$redirect_to = add_query_arg(urlencode_deep($query_args), $redirect_to);

					wp_redirect($redirect_to).exit(); // All done :-)
				}
		}

		new actions(); // Initialize/handle actions.
	}