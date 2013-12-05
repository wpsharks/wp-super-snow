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

					echo '   <button type="submit">'.__('Save', plugin()->text_domain).' <i class="fa fa-save"></i></button>'."\n";

					echo '   <button type="button" class="plugin-menu-page-restore-defaults"'. // Restores default options.
					     '      data-confirmation="'.esc_attr(__('Restore default plugin options? You will lose all of your current settings! Are you absolutely sure about this?', plugin()->text_domain)).'"'.
					     '      data-action="'.esc_attr(add_query_arg(urlencode_deep(array('page' => __NAMESPACE__, '_wpnonce' => wp_create_nonce(), __NAMESPACE__ => array('restore_default_options' => '1'))), self_admin_url('/admin.php'))).'">'.
					     '      '.__('Restore', plugin()->text_domain).' <i class="fa fa-ambulance"></i></button>'."\n";

					echo '   <div class="plugin-menu-page-panel-togglers" title="'.esc_attr(__('All Panels', plugin()->text_domain)).'">'."\n";
					echo '      <button type="button" class="plugin-menu-page-panels-open"><i class="fa fa-chevron-down"></i></button>'."\n";
					echo '      <button type="button" class="plugin-menu-page-panels-close"><i class="fa fa-chevron-up"></i></button>'."\n";
					echo '   </div>'."\n";

					echo '   <div class="plugin-menu-page-upsells">'."\n";
					// echo '      <a href="'.esc_attr(add_query_arg(urlencode_deep(array('page' => __NAMESPACE__, __NAMESPACE__.'_pro_preview' => '1')), self_admin_url('/admin.php'))).'"><i class="fa fa-eye"></i> Preview Pro Features</a>'."\n";
					// echo '      <a href="http://www.websharks-inc.com/product/wp-super-snow/" target="_blank"><i class="fa fa-heart-o"></i> Pro Upgrade</a>'."\n";
					echo '      <a href="http://www.websharks-inc.com/r/wp-theme-plugin-donation/" target="_blank"><i class="fa fa-heart-o"></i> Donate (Support the Developer)</a>'."\n";
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
					echo '      <p style="float:right; margin:-5px 0 0 0; font-weight:bold;"><img src="'.esc_attr(plugin()->url('/client-s/images/flakes-icon.png')).'" style="vertical-align:middle;" /> = <i class="fa fa-smile-o fa-4x"></i> happy visitors<em>!</em></p>'."\n";
					echo '      <p style="margin-top:1em;"><label class="switch-primary"><input type="radio" name="'.esc_attr(__NAMESPACE__).'[save_options][enable]" value="1"'.checked(plugin()->options['enable'], '1', FALSE).' /> <i class="fa fa-magic fa-flip-horizontal"></i> '.__('Yes, enable WP Super Snow!', plugin()->text_domain).'</label> &nbsp;&nbsp;&nbsp; <label><input type="radio" name="'.esc_attr(__NAMESPACE__).'[save_options][enable]" value="0"'.checked(plugin()->options['enable'], '0', FALSE).' /> '.__('No, disable.', plugin()->text_domain).'</label></p>'."\n";
					echo '      <hr />'."\n";
					echo '      <p class="info" style="display:block;">'.__('<strong>HUGE Time-Saver:</strong> Approx. 95% of all WordPress sites running WP Super Snow, simply enable it here; and that\'s it :-) <strong>No further configuration is necessary (really).</strong> All of the other options (down below) are already tuned for the BEST performance on a typical WordPress installation. Simply enable WP Super Snow here and click "Save All Changes". If you get any warnings please follow the instructions given. Otherwise, you\'re good <i class="fa fa-smile-o"></i>. This plugin is designed to run just fine like it is. Take it for a spin right away; you can always fine-tune things later if you deem necessary.', plugin()->text_domain).'</p>'."\n";
					echo '   </div>'."\n";

					echo '</div>'."\n";

					echo '<div class="plugin-menu-page-panel">'."\n";

					echo '   <div class="plugin-menu-page-panel-heading">'."\n";
					echo '      <i class="fa fa-shield"></i> '.__('Deactivation Safeguards', plugin()->text_domain)."\n";
					echo '   </div>'."\n";

					echo '   <div class="plugin-menu-page-panel-body clearfix">'."\n";
					echo '      <i class="fa fa-shield fa-4x" style="float:right; margin: 0 0 0 25px;"></i>'."\n";
					echo '      <h3>'.__('Uninstall on Deactivation; or Safeguard Options?', plugin()->text_domain).'</h3>'."\n";
					echo '      <p>'.__('<strong>Tip:</strong> By default, if you deactivate WP Super Snow from the plugins menu in WordPress; nothing is lost. However, if you want to uninstall WP Super Snow you should set this to <code>Yes</code> and <strong>THEN</strong> deactivate it from the plugins menu in WordPress. This way WP Super Snow will erase your options for the plugin. It erases itself from existence completely.', plugin()->text_domain).'</p>'."\n";
					echo '      <p><select name="'.esc_attr(__NAMESPACE__).'[save_options][uninstall_on_deactivation]">'."\n";
					echo '            <option value="0"'.selected(plugin()->options['uninstall_on_deactivation'], '0', FALSE).'>'.__('If I deactivate WP Super Snow please safeguard my options (recommended).', plugin()->text_domain).'</option>'."\n";
					echo '            <option value="1"'.selected(plugin()->options['uninstall_on_deactivation'], '1', FALSE).'>'.__('Yes, uninstall (completely erase) WP Super Snow on deactivation.', plugin()->text_domain).'</option>'."\n";
					echo '         </select></p>'."\n";
					echo '   </div>'."\n";

					echo '</div>'."\n";

					echo '<div class="plugin-menu-page-panel">'."\n";

					echo '   <div class="plugin-menu-page-panel-heading">'."\n";
					echo '      <i class="fa fa-gears"></i> '.__('Virtual Snow Blower', plugin()->text_domain)."\n";
					echo '   </div>'."\n";

					echo '   <div class="plugin-menu-page-panel-body clearfix">'."\n";
					echo '      <table style="width:100%;">'."\n";
					echo '         <tbody>'."\n";
					echo '            <tr>'."\n";
					echo '               <td style="width:100%; vertical-align:top;">'."\n";
					echo '                  <i class="fa fa-gears fa-4x" style="float:right; margin: 0 0 0 25px;"></i>'."\n";
					echo '                  <button type="button" class="plugin-virtual-snow-blower-preview" style="float:right; margin: 0 0 0 25px;"><i class="fa fa-eye"></i> '.__('Preview', plugin()->text_domain).'</button>'."\n";
					echo '                  <h3>'.__('Virtual Snow Blower (Advanced Configuration)', plugin()->text_domain).'</h3>'."\n";
					echo '                  <p>'.__('The options below support an advanced configuration of WP Super Snow. The defaults work just fine; but you might like to change things up just a bit. It\'s fun. <i class="fa fa-smile-o"></i>', plugin()->text_domain).'</p>'."\n";
					echo '                  <hr />'."\n";
					echo '                  <h3>'.__('WP Super Snow Container', plugin()->text_domain).'</h3>'."\n";
					echo '                  <p>'.__('This is almost always the <code>body</code> tag. However, you might decide to change this if you have a specific area of your site that WP Super Snow should be restricted to. Note: if you DO change this, please use a CSS selector expression for jQuery; e.g. <code>#my_div</code>', plugin()->text_domain).'</p>'."\n";
					echo '                  <p><input type="text" name="'.esc_attr(__NAMESPACE__).'[save_options][container]" value="'.esc_attr(plugin()->options['container']).'" /></p>'."\n";
					echo '                  <h3>'.__('z-Index for all Snowflakes', plugin()->text_domain).'</h3>'."\n";
					echo '                  <p>'.__('This is the layered stack order for all snowflakes; e.g. <code>style="z-index:999999;"</code>. Generally speaking, it\'s best to keep snowflakes on top of everything else. See also: <a href="http://www.w3schools.com/cssref/pr_pos_z-index.asp" target="_blank">z-index @ W3Schools</a> if you\'re not familiar with this term.', plugin()->text_domain).'</p>'."\n";
					echo '                  <p><input type="text" name="'.esc_attr(__NAMESPACE__).'[save_options][z_index]" value="'.esc_attr(plugin()->options['z_index']).'" /></p>'."\n";
					echo '                  <h3>'.__('Snowflake Images (a Line-Delimited List Please)', plugin()->text_domain).'</h3>'."\n";
					echo '                  <p>'.__('If you\'d like to add your own images; or replace the default snowflake graphics — you can do that here. We recommend alpha transparent PNG files approx 100 x 100 pixels. There is no limit on the number of graphics (one image path per line please).', plugin()->text_domain).'</p>'."\n";
					echo '                  <p style="margin-bottom:0;"><textarea name="'.esc_attr(__NAMESPACE__).'[save_options][flakes]" spellcheck="false" class="monospace" rows="3">'.esc_textarea(plugin()->options['flakes']).'</textarea></p>'."\n";
					echo '                  <p class="info" style="margin-top:0;">'.__('<strong>Tip:</strong> images that have the word <code>flake</code> anywhere their URL/path are spinned in a 3D rotation at random (WP Super Snow assumes these are actual snowflake graphics). All other graphics rotate left-to-right and/or right-to-left at random (compatiblity mode).', plugin()->text_domain).'</p>'."\n";
					echo '                  <h3>'.__('Total Snowflakes to Process', plugin()->text_domain).'</h3>'."\n";
					echo '                  <p>'.__('Snowflakes are processed (animated) in and out of view at random intervals. This setting determines the total number of snowflakes that should ever be processed at the same time. Note: the more snowflakes you process, the slower your site might become.', plugin()->text_domain).'</p>'."\n";
					echo '                  <p><input type="text" name="'.esc_attr(__NAMESPACE__).'[save_options][total_flakes]" value="'.esc_attr(plugin()->options['total_flakes']).'" /></p>'."\n";
					echo '                  <h3>'.__('Max Snowflake Size (in Pixels)', plugin()->text_domain).'</h3>'."\n";
					echo '                  <p>'.__('Snowflake sizes are always random. However, you can control the randomizer (to a certain extent) by defining the largest possible size. Note: the default snowflake graphics that come with WP Super Snow will support up to <code>100</code> pixels (before distortion occurs).', plugin()->text_domain).'</p>'."\n";
					echo '                  <p><input type="text" name="'.esc_attr(__NAMESPACE__).'[save_options][max_size]" value="'.esc_attr(plugin()->options['max_size']).'" /></p>'."\n";
					echo '                  <h3>'.__('Max Snowflake Duration (in Seconds)', plugin()->text_domain).'</h3>'."\n";
					echo '                  <p>'.__('Snowflake animations are always random. However, you can control the randomizer (to a certain extent) by defining the longest possible duration of a falling snowflake. Note: a larger number = a slower speed; a smaller number = faster (e.g. a shorter duration).', plugin()->text_domain).'</p>'."\n";
					echo '                  <p><input type="text" name="'.esc_attr(__NAMESPACE__).'[save_options][max_duration]" value="'.esc_attr(plugin()->options['max_duration']).'" /></p>'."\n";
					echo '                  <h3>'.__('Use Snow Flake Transparency Effects?', plugin()->text_domain).'</h3>'."\n";
					echo '                  <p>'.__('Snowflake animations always include transpareny effects. This setting enables/disables some ADDITIONAL snowflake image transparency effects for an enhanced viewing experience in modern browsers (best on dark backgrounds).', plugin()->text_domain).'</p>'."\n";
					echo '                  <p><select name="'.esc_attr(__NAMESPACE__).'[save_options][use_flake_trans]">'."\n";
					echo '                        <option value="0"'.selected(plugin()->options['use_flake_trans'], '0', FALSE).'>'.__('No, don\'t use image transparency (recommended for improved performance; speedier).', plugin()->text_domain).'</option>'."\n";
					echo '                        <option value="1"'.selected(plugin()->options['use_flake_trans'], '1', FALSE).'>'.__('Yes, add image transparency effects (best visual experience).', plugin()->text_domain).'</option>'."\n";
					echo '                     </select></p>'."\n";
					echo '               </td>'."\n";
					echo '               <td style="width:1px; vertical-align:top; white-space:nowrap;">'."\n";
					echo '               <div class="plugin-virtual-snow-blower" style="width:400px; height:400px; margin: 0 0 15px 25px; border-radius:5px; border:1px solid #000000; background:url(\''.esc_attr(plugin()->url('/client-s/images/vsb-bg.png')).'\') no-repeat;"></div>'."\n";
					echo '               <p class="info" style="text-align:center; width:400px; margin:15px 0 0 25px; white-space:normal;">'.__('<strong>Tip:</strong> snowflakes will fall inside this graphic. Please click the Preview button (above) to see changes in configuration.', plugin()->text_domain).'</p>'."\n";
					echo '               </td>'."\n";
					echo '            </tr>'."\n";
					echo '         </tbody>'."\n";
					echo '      </table>'."\n";
					echo '   </div>'."\n";

					echo '</div>'."\n";

					if(!plugin()->is_multisite_farm_blog())
						{
							echo '<div class="plugin-menu-page-panel">'."\n";

							echo '   <div class="plugin-menu-page-panel-heading">'."\n";
							echo '      <i class="fa fa-cloud"></i> '.__('Forecasting / Conditions', plugin()->text_domain)."\n";
							echo '   </div>'."\n";

							echo '   <div class="plugin-menu-page-panel-body clearfix">'."\n";
							echo '      <span class="fa-stack fa-2x" style="float:right; margin: 0 0 0 25px;"><i class="fa fa-cloud fa-stack-2x"></i><i class="fa fa-code fa-stack-1x fa-inverse"></i></span>'."\n";
							echo '      <h3>'.__('Have Conditions to Check for?', plugin()->text_domain).'</h3>'."\n";
							echo '      <p>'.__('By default, WP Super Snow is displayed on every page of your site (but DISABLED for mobile devices; see note below). If there are other conditions you\'d like to satisify before WP Super Snow is loaded (e.g. only load it on certain Posts/Pages; or only between specific dates/times; or only on certain devices); you can specify those conditions here using <a href="http://codex.wordpress.org/Conditional_Tags" target="_blank">Conditional Tags</a>.', plugin()->text_domain).'</p>'."\n";
							echo '      <table style="width:100%;"><tr><td style="width:1px; font-weight:bold; white-space:nowrap;"><code>if(</code></td><td><input type="text" name="'.esc_attr(__NAMESPACE__).'[save_options][conditionals]" value="'.esc_attr(plugin()->options['conditionals']).'" /></td><td style="width:1px; font-weight:bold; white-space:nowrap;"><code>)</code></td></tr></table>'."\n";
							echo '      <p class="info">'.__('<strong>Example:</strong> <code>!wp_is_mobile() && is_page(\'christmas-promo\')</code> e.g. only run on one specific page.', plugin()->text_domain).'</p>'."\n";
							echo '      <p class="info">'.__('<strong>Example:</strong> <code>!wp_is_mobile() && !is_ssl()</code> e.g. NOT on mobile devices &amp; NOT over HTTPS (SSL).', plugin()->text_domain).'</p>'."\n";
							echo '      <p class="info">'.sprintf(__('<strong>Example:</strong> <code>!wp_is_mobile() && time() >= strtotime(\'%1$s-12-01\') && time() <= strtotime(\'%1$s-12-31\')</code> e.g. only run in the month of December %1$s.', plugin()->text_domain), date('Y')).'</p>'."\n";
							echo '      <p class="info">'.__('<strong>Example:</strong> <code>!wp_is_mobile()</code> e.g. only run on desktops/laptops; NOT on mobile devices. See also: <a href="http://detectmobilebrowsers.com/" target="_blank">DetectMobileBrowsers.com</a>', plugin()->text_domain).'</p>'."\n";
							echo '      <p class="warning">'.__('<strong>Why disable on mobile devices?</strong> By default, mobile devices are excluded from the snow effect; only because it\'s not good for their CPUs (or their batteries). If your local marketing department insists, "This must work on mobile!" despite being warned of the downsides, you can remove that condition above.', plugin()->text_domain).'</p>'."\n";
							echo '   </div>'."\n";

							echo '</div>'."\n";
						}
					echo '<div class="plugin-menu-page-save">'."\n";
					echo '   <button type="submit">'.__('Save All Changes', plugin()->text_domain).' <i class="fa fa-save"></i></button>'."\n";
					echo '</div>'."\n";

					echo '</div>'."\n";
					echo '</form>';
				}
		}
	}