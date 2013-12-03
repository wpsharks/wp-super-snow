<?php
namespace wp_super_snow // Root namespace.
	{
		if(!defined('WPINC')) // MUST have WordPress.
			exit('Do NOT access this file directly: '.basename(__FILE__));

		class menu_pages // Plugin options.
		{
			public function options()
				{
					echo '<form id="plugin-menu-page" class="plugin-menu-page" method="post" enctype="multipart/form-data"'.
					     ' action="'.esc_attr(add_query_arg(urlencode_deep(array('page' => __NAMESPACE__, '_wpnonce' => wp_create_nonce())), self_admin_url('/admin.php'))).'">'."\n";

					echo '<div class="plugin-menu-page-heading">'."\n";

					echo '   <button type="button" class="plugin-menu-page-restore-defaults"'. // Restores default options.
					     '      data-confirmation="'.esc_attr(__('Restore default plugin options? You will lose all of your current settings! Are you absolutely sure about this?', plugin()->text_domain)).'"'.
					     '      data-action="'.esc_attr(add_query_arg(urlencode_deep(array('page' => __NAMESPACE__, '_wpnonce' => wp_create_nonce(), __NAMESPACE__ => array('restore_default_options' => '1'))), self_admin_url('/admin.php'))).'">'.
					     '      '.__('Restore', plugin()->text_domain).' <i class="fa fa-ambulance"></i></button>'."\n";

					echo '   <div class="plugin-menu-page-panel-togglers" title="'.esc_attr(__('All Panels', plugin()->text_domain)).'">'."\n";
					echo '      <button type="button" class="plugin-menu-page-panels-open"><i class="fa fa-chevron-down"></i></button>'."\n";
					echo '      <button type="button" class="plugin-menu-page-panels-close"><i class="fa fa-chevron-up"></i></button>'."\n";
					echo '   </div>'."\n";

					echo '   <div class="plugin-menu-page-upsells">'."\n";
					echo '      <a href="'.esc_attr(add_query_arg(urlencode_deep(array('page' => __NAMESPACE__, __NAMESPACE__.'_pro_preview' => '1')), self_admin_url('/admin.php'))).'"><i class="fa fa-eye"></i> Preview Pro Features</a>'."\n";
					echo '      <a href="http://www.websharks-inc.com/product/wp-super-snow/" target="_blank"><i class="fa fa-heart-o"></i> Pro Upgrade</a>'."\n";
					echo '      <a href="http://www.websharks-inc.com/r/wp-super-snow-subscribe/" target="_blank"><i class="fa fa-envelope"></i> WP Super Snow Updates (via Email)</a>'."\n";
					echo '   </div>'."\n";

					echo '   <img src="'.plugin()->url('/client-s/images/options.png').'" alt="'.esc_attr(__('Plugin Options', plugin()->text_domain)).'" />'."\n";

					echo '</div>'."\n";

					if(!empty($_REQUEST[__NAMESPACE__.'__updated'])) // Options updated successfully?
						{
							echo '<div class="plugin-menu-page-notice notice">'."\n";
							echo '   <i class="fa fa-thumbs-up"></i> '.__('Options updated successfully.', plugin()->text_domain)."\n";
							echo '</div>'."\n";
						}
					if(!empty($_REQUEST[__NAMESPACE__.'__restored'])) // Restored default options?
						{
							echo '<div class="plugin-menu-page-notice notice">'."\n";
							echo '   <i class="fa fa-thumbs-up"></i> '.__('Default options successfully restored.', plugin()->text_domain)."\n";
							echo '</div>'."\n";
						}
					if(!empty($_REQUEST[__NAMESPACE__.'_pro_preview']))
						{
							echo '<div class="plugin-menu-page-notice info">'."\n";
							echo '<a href="'.add_query_arg(urlencode_deep(array('page' => __NAMESPACE__)), self_admin_url('/admin.php')).'" class="pull-right" style="margin:0 0 15px 25px; font-variant:small-caps; text-decoration:none;">'.__('close', plugin()->text_domain).' <i class="fa fa-eye-slash"></i></a>'."\n";
							echo '   <i class="fa fa-eye"></i> '.__('<strong>Pro Features (Preview)</strong> ~ New option panels below. Please explore before <a href="http://www.websharks-inc.com/product/wp-super-snow/" target="_blank">upgrading <i class="fa fa-heart-o"></i></a>.<br /><small>NOTE: the free version of WP Super Snow (this LITE version); is more-than-adequate for most sites. Please upgrade only if you desire advanced features or would like to support the developer.</small>', plugin()->text_domain)."\n";
							echo '</div>'."\n";
						}
					if(!plugin()->options['enable']) // Not enabled yet?
						{
							echo '<div class="plugin-menu-page-notice warning">'."\n";
							echo '   <i class="fa fa-warning"></i> '.__('WP Super Snow is currently disabled; please review options below.', plugin()->text_domain)."\n";
							echo '</div>'."\n";
						}
					echo '<div class="plugin-menu-page-body">'."\n";

					echo '<div class="plugin-menu-page-panel">'."\n";

					echo '   <div class="plugin-menu-page-panel-heading'.((!plugin()->options['enable']) ? ' open' : '').'">'."\n";
					echo '      <i class="fa fa-flag"></i> '.__('Enable/Disable', plugin()->text_domain)."\n";
					echo '   </div>'."\n";

					echo '   <div class="plugin-menu-page-panel-body'.((!plugin()->options['enable']) ? ' open' : '').' clearfix">'."\n";
					echo '      <p style="float:right; margin:-5px 0 0 0; font-weight:bold;">Quick Cache = <i class="fa fa-tachometer fa-4x"></i> SPEED<em>!!</em></p>'."\n";
					echo '      <p style="margin-top:1em;"><label class="switch-primary"><input type="radio" name="'.esc_attr(__NAMESPACE__).'[save_options][enable]" value="1"'.checked(plugin()->options['enable'], '1', FALSE).' /> <i class="fa fa-magic fa-flip-horizontal"></i> '.__('Yes, enable Quick Cache!', plugin()->text_domain).'</label> &nbsp;&nbsp;&nbsp; <label><input type="radio" name="'.esc_attr(__NAMESPACE__).'[save_options][enable]" value="0"'.checked(plugin()->options['enable'], '0', FALSE).' /> '.__('No, disable.', plugin()->text_domain).'</label></p>'."\n";
					echo '      <hr />'."\n";
					echo '      <p class="info">'.__('<strong>HUGE Time-Saver:</strong> Approx. 95% of all WordPress sites running Quick Cache, simply enable it here; and that\'s it :-) <strong>No further configuration is necessary (really).</strong> All of the other options (down below) are already tuned for the BEST performance on a typical WordPress installation. Simply enable Quick Cache here and click "Save All Changes". If you get any warnings please follow the instructions given. Otherwise, you\'re good <i class="fa fa-smile-o"></i>. This plugin is designed to run just fine like it is. Take it for a spin right away; you can always fine-tune things later if you deem necessary.', plugin()->text_domain).'</p>'."\n";
					echo '      <hr />'."\n";
					echo '      <img src="'.esc_attr(plugin()->url('/client-s/images/db-screenshot.png')).'" class="screenshot" />'."\n";
					echo '      <h3>'.__('How Can I Tell Quick Cache is Working?', plugin()->text_domain).'</h3>'."\n";
					echo '      <p>'.__('First of all, please make sure that you\'ve enabled Quick Cache here; then scroll down to the bottom of this page and click "Save All Changes". All of the other options (below) are already pre-configured for typical usage. Feel free to skip them all for now. You can go back through all of these later and fine-tune things the way you like them.', plugin()->text_domain).'</p>'."\n";
					echo '      <p>'.__('Once Quick Cache has been enabled, <strong>you\'ll need to log out (and/or clear browser cookies)</strong>. By default, cache files are NOT served to visitors who are logged-in, and that includes you too ;-) Cache files are NOT served to recent comment authors either. If you\'ve commented (or replied to a comment lately); please clear your browser cookies before testing.', plugin()->text_domain).'</p>'."\n";
					echo '      <p>'.__('<strong>To verify that Quick Cache is working</strong>, navigate your site like a normal visitor would. Right-click on any page (choose View Source), then scroll to the very bottom of the document. At the bottom, you\'ll find comments that show Quick Cache stats and information. You should also notice that page-to-page navigation is <i class="fa fa-flash"></i> <strong>lightning fast</strong> now that Quick Cache is running; and it gets faster over time!', plugin()->text_domain).'</p>'."\n";
					echo '      <p><select name="'.esc_attr(__NAMESPACE__).'[save_options][debugging_enable]">'."\n";
					echo '            <option value="1"'.selected(plugin()->options['debugging_enable'], '1', FALSE).'>'.__('Yes, enable notes in the source code so I can see it\'s working (recommended).', plugin()->text_domain).'</option>'."\n";
					echo '            <option value="0"'.selected(plugin()->options['debugging_enable'], '0', FALSE).'>'.__('No, I don\'t want my source code to contain any of these notes.', plugin()->text_domain).'</option>'."\n";
					echo '         </select></p>'."\n";
					echo '   </div>'."\n";

					echo '</div>'."\n";

					echo '<div class="plugin-menu-page-panel">'."\n";

					echo '   <div class="plugin-menu-page-panel-heading">'."\n";
					echo '      <i class="fa fa-shield"></i> '.__('Deactivation Safeguards', plugin()->text_domain)."\n";
					echo '   </div>'."\n";

					echo '   <div class="plugin-menu-page-panel-body clearfix">'."\n";
					echo '      <i class="fa fa-shield fa-4x" style="float:right; margin: 0 0 0 25px;"></i>'."\n";
					echo '      <h3>'.__('Uninstall on Deactivation; or Safeguard Options?', plugin()->text_domain).'</h3>'."\n";
					echo '      <p>'.__('<strong>Tip:</strong> By default, if you deactivate Quick Cache from the plugins menu in WordPress; nothing is lost. However, if you want to uninstall Quick Cache you should set this to <code>Yes</code> and <strong>THEN</strong> deactivate it from the plugins menu in WordPress. This way Quick Cache will erase your options for the plugin, clear the cache, remove the <code>advanced-cache.php</code> file, terminate CRON jobs, etc. It erases itself from existence completely.', plugin()->text_domain).'</p>'."\n";
					echo '      <p><select name="'.esc_attr(__NAMESPACE__).'[save_options][uninstall_on_deactivation]">'."\n";
					echo '            <option value="0"'.selected(plugin()->options['uninstall_on_deactivation'], '0', FALSE).'>'.__('If I deactivate Quick Cache please safeguard my options and the cache (recommended).', plugin()->text_domain).'</option>'."\n";
					echo '            <option value="1"'.selected(plugin()->options['uninstall_on_deactivation'], '1', FALSE).'>'.__('Yes, uninstall (completely erase) Quick Cache on deactivation.', plugin()->text_domain).'</option>'."\n";
					echo '         </select></p>'."\n";
					echo '   </div>'."\n";

					echo '</div>'."\n";

					echo '<div class="plugin-menu-page-save">'."\n";
					echo '   <button type="submit">'.__('Save All Changes', plugin()->text_domain).' <i class="fa fa-save"></i></button>'."\n";
					echo '</div>'."\n";

					echo '</div>'."\n";
					echo '</form>';
				}
		}
	}