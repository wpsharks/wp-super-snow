<?php
namespace WebSharks\WpSuperSnow;

class MenuPage extends AbsBase
{
    public function __construct(Plugin $Plugin)
    {
        parent::__construct($Plugin);

        # Options...

        echo '<form class="plugin-menu-page"'.
        ' method="post" enctype="multipart/form-data" autocomplete="off" novalidate="novalidate"'.
        ' action="'.esc_attr(add_query_arg(urlencode_deep(['page' => $this::GLOBAL_NS, '_wpnonce' => wp_create_nonce()]), self_admin_url('/admin.php'))).'">'."\n";

        # Notices (if applicable)...

        if (!empty($_REQUEST[$this::GLOBAL_NS.'_updated'])) {
            echo '<div class="updated fade">'."\n";
            echo '  <p>'."\n";
            echo '      <i class="si si-thumbs-up"></i> '.__('Options updated successfully.', 'wp-super-snow')."\n";
            echo '  </p>'."\n";
            echo '</div>'."\n";
        }
        if (!empty($_REQUEST[$this::GLOBAL_NS.'_restored'])) {
            echo '<div class="updated fade">'."\n";
            echo '  <p>'."\n";
            echo '   <i class="si si-thumbs-up"></i> '.__('Default options successfully restored.', 'wp-super-snow')."\n";
            echo '  </p>'."\n";
            echo '</div>'."\n";
        }
        if (!$this->Plugin->options['enable']) {
            echo '<div class="error fade">'."\n";
            echo '  <p>'."\n";
            echo '   <i class="si si-info-circle"></i> '.__('<strong>WP Super Snow</strong> is currently disabled. Please review options below.', 'wp-super-snow')."\n";
            echo '  </p>'."\n";
            echo '</div>'."\n";
        }
        # Heading...

        echo '<div class="-heading">'."\n";

        echo '   <button type="button" class="-restore button"'.// Restores default options.
             '      data-confirmation="'.esc_attr(__('Restore default plugin options? You will lose all of your current settings! Are you absolutely sure about this?', 'wp-super-snow')).'"'.
             '      data-action="'.esc_attr(add_query_arg(urlencode_deep(['page' => $this::GLOBAL_NS, '_wpnonce' => wp_create_nonce(), $this::GLOBAL_NS => ['restoreDefaultOptions' => uniqid('', true)]]), self_admin_url('/admin.php'))).'">'.
             '      '.__('Restore Default Options', 'wp-super-snow').' <i class="si si-ambulance"></i></button>'."\n";

        echo '   <div class="-upsells">'."\n";
        echo '      <a href="http://websharks-inc.com/r/wp-theme-plugin-donation/" target="_blank"><i class="si si-heart-o"></i> '.__('Donate (Support the Developer)', 'wp-super-snow').'</a>'."\n";
        echo '      <a href="http://websharks-inc.com/r/wp-super-snow-subscribe/" target="_blank"><i class="si si-envelope"></i> '.__('WP Super Snow Updates (via Email)', 'wp-super-snow').'</a>'."\n";
        echo '   </div>'."\n";

        echo '   <img class="-logo" src="'.$this->Plugin->url('/src/client-s/images/options.png').'" />'."\n";

        echo '</div>'."\n";

        # Body and container...

        echo '<div class="-body postbox-container">'."\n";
        echo '<div class="-container metabox-holder">'."\n";

        # Config. panels using postbox classes...

        echo '<div class="-panel postbox'.($this->Plugin->options['enable'] ? ' closed' : '').'" id="'.esc_attr(str_replace('.', '', uniqid('pb-', true))).'">'."\n";
        echo '  <div class="-toggler handlediv"><br /></div>'."\n";

        echo '   <h3 class="-heading hndle">'."\n";
        echo '      <i class="si si-flag"></i> '.__('Enable/Disable', 'wp-super-snow')."\n";
        echo '   </h3>'."\n";

        echo '   <div class="-body inside">'."\n";
        echo '      <p><label class="-enable"><input type="radio" name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][enable]" value="1"'.checked($this->Plugin->options['enable'], '1', false).' /> '.__('Yes, enable WP Super Snow!', 'wp-super-snow').'</label> &nbsp;&nbsp;&nbsp; <label><input type="radio" name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][enable]" value="0"'.checked($this->Plugin->options['enable'], '0', false).' /> '.__('No, disable.', 'wp-super-snow').'</label></p>'."\n";
        echo '      <p class="-info">'.__('<strong>HUGE Time-Saver:</strong> Approx. 95% of all WordPress sites running WP Super Snow, simply enable it here and that\'s it :-) <strong>No further configuration is necessary (really).</strong> All of the other options are already tuned for the BEST performance on a typical WordPress site. Simply enable WP Super Snow here and click "Save All Changes". If you get any warnings please follow the instructions given. Otherwise, you\'re good. <i class="si si-smile-o"></i> This plugin is designed to run just fine like it is. Take it for a spin right away. You can always fine-tune things later if you deem necessary.', 'wp-super-snow').'</p>'."\n";
        echo '   </div>'."\n";

        echo '</div>'."\n";

        echo '<div class="-panel postbox closed" id="'.esc_attr(str_replace('.', '', uniqid('pb-', true))).'">'."\n";
        echo '  <div class="-toggler handlediv"><br /></div>'."\n";

        echo '   <h3 class="-heading hndle">'."\n";
        echo '      <i class="si si-cogs"></i> '.__('Virtual Snow Blower', 'wp-super-snow')."\n";
        echo '   </h3>'."\n";

        echo '   <div class="-body inside">'."\n";
        echo '      <table style="width:100%;">'."\n";
        echo '         <tbody>'."\n";
        echo '            <tr>'."\n";

        echo '               <td style="width:100%; vertical-align:top;">'."\n";
        echo '                  <button type="button" class="-vsb-button button"><i class="si si-eye"></i> '.__('Preview', 'wp-super-snow').'</button>'."\n";

        echo '                  <h3>'.__('The Virtual Snow Blower allows for an advanced configuration.', 'wp-super-snow').'</h3>'."\n";
        echo '                  <p>'.__('The defaults work just fine, but you might like to change things up just a bit. It\'s fun! <i class="si si-smile-o"></i>', 'wp-super-snow').'</p>'."\n";

        echo '                  <hr />'."\n";

        echo '                  <h3>'.__('WP Super Snow Container', 'wp-super-snow').'</h3>'."\n";
        echo '                  <p>'.__('This is almost always the <code>body</code> tag. However, you might decide to change this if you have a specific area of your site that WP Super Snow should be restricted to. Note: if you DO change this, please use a CSS selector expression for jQuery; e.g., <code>#my_div</code>. You can apply snow to multiple elements using comma-delimited format; e.g., <code>#my_div,.snow-here</code>', 'wp-super-snow').'</p>'."\n";
        echo '                  <p><input type="text" name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][container]" value="'.esc_attr($this->Plugin->options['container']).'" /></p>'."\n";

        echo '                  <h3>'.__('z-Index for all Snowflakes', 'wp-super-snow').'</h3>'."\n";
        echo '                  <p>'.__('This is the layered stack order for all snowflakes; e.g., <code>style="z-index:999999;"</code>. Generally speaking, it\'s best to keep snowflakes on top of everything else. See also: <a href="http://www.w3schools.com/cssref/pr_pos_z-index.asp" target="_blank">z-index @ W3Schools</a> if you\'re not familiar with this term. The default value of <code>999999</code> puts snow on top of everything else for most sites.', 'wp-super-snow').'</p>'."\n";
        echo '                  <p><input type="text" name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][z_index]" value="'.esc_attr($this->Plugin->options['z_index']).'" /></p>'."\n";

        echo '                  <h3>'.__('Snowflake Images (Line-Delimited)', 'wp-super-snow').'</h3>'."\n";
        echo '                  <p>'.__('If you\'d like to add your own images or replace the <a href="'.esc_attr($this->Plugin->url('/src/client-s/images/graphics.zip')).'">default snowflake graphics</a>, you can do that here. We recommend alpha transparent PNG files approx 100x100 pixels. There is no limit on the number of graphics. Just be sure to put ONE on each line. Note: this also allows WP Super Snow to be used for other holiday ideas too; e.g., you could have snowing pumpkins!', 'wp-super-snow').'</p>'."\n";
        echo '                  <p style="margin-bottom:0;"><textarea name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][flakes]" spellcheck="false" class="monospace" rows="3">'.esc_textarea($this->Plugin->options['flakes']).'</textarea></p>'."\n";
        echo '                  <p class="-info" style="margin-top:0;">'.__('<strong>Tip:</strong> images that have the word <code>flake</code> anywhere their URL/path are spinned in a 3D rotation at random (WP Super Snow assumes these are actual snowflake graphics). All other graphics rotate left-to-right and/or right-to-left at random (i.e., in compatiblity mode).', 'wp-super-snow').'</p>'."\n";

        echo '                  <h3>'.__('Total Snowflakes to Process', 'wp-super-snow').'</h3>'."\n";
        echo '                  <p>'.__('Snowflakes are processed (animated) in and out of view at random intervals. This setting determines the total number of snowflakes that should ever be processed at the same time. However, please be warned! The more snowflakes you process, the slower your site might become!', 'wp-super-snow').'</p>'."\n";
        echo '                  <p><input type="text" name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][total_flakes]" value="'.esc_attr($this->Plugin->options['total_flakes']).'" /></p>'."\n";

        echo '                  <h3>'.__('Max Snowflake Size (in Pixels)', 'wp-super-snow').'</h3>'."\n";
        echo '                  <p>'.__('Snowflake sizes are always random. However, you can control the randomizer (to a certain extent) by defining the largest possible size. The default snowflake graphics that come with WP Super Snow will support up to <code>100</code> pixels (before distortion occurs).', 'wp-super-snow').'</p>'."\n";
        echo '                  <p><input type="text" name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][max_size]" value="'.esc_attr($this->Plugin->options['max_size']).'" /></p>'."\n";

        echo '                  <h3>'.__('Max Snowflake Duration (in Seconds)', 'wp-super-snow').'</h3>'."\n";
        echo '                  <p>'.__('Snowflake animations are always random. However, you can control the randomizer (to a certain extent) by defining the longest possible duration of a falling snowflake. A larger number = a slower speed; a smaller number = faster (i.e., a shorter duration).', 'wp-super-snow').'</p>'."\n";
        echo '                  <p><input type="text" name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][max_duration]" value="'.esc_attr($this->Plugin->options['max_duration']).'" /></p>'."\n";

        echo '                  <h3>'.__('Use Snow Flake Transparency Effects?', 'wp-super-snow').'</h3>'."\n";
        echo '                  <p>'.__('Snowflake animations always include transpareny effects. This setting enables/disables some ADDITIONAL snowflake image transparency effects for an enhanced viewing experience in modern browsers (best on dark backgrounds).', 'wp-super-snow').'</p>'."\n";
        echo '                  <p><select name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][use_flake_trans]">'."\n";
        echo '                        <option value="0"'.selected($this->Plugin->options['use_flake_trans'], '0', false).'>'.__('No, don\'t use image transparency (recommended for improved performance; speedier).', 'wp-super-snow').'</option>'."\n";
        echo '                        <option value="1"'.selected($this->Plugin->options['use_flake_trans'], '1', false).'>'.__('Yes, add image transparency effects (best visual experience).', 'wp-super-snow').'</option>'."\n";
        echo '                     </select></p>'."\n";
        echo '               </td>'."\n";

        echo '               <td style="width:1px; vertical-align:top; white-space:nowrap;">'."\n";
        echo '                  <div class="-vsb" style="width:400px; height:400px; margin: 0 0 15px 25px; border-radius:5px; border:1px solid #000000; background:url(\''.esc_attr($this->Plugin->url('/src/client-s/images/vsb-bg.png')).'\') no-repeat;"></div>'."\n";
        echo '                  <p class="info" style="text-align:center; width:400px; margin:15px 0 0 25px; white-space:normal;">'.__('<strong>Tip:</strong> snowflakes will fall inside this graphic. Please click the Preview button (above) to see changes in configuration.', 'wp-super-snow').'</p>'."\n";
        echo '               </td>'."\n";

        echo '            </tr>'."\n";
        echo '         </tbody>'."\n";
        echo '      </table>'."\n";
        echo '   </div>'."\n";

        echo '</div>'."\n";

        if (!$this->Plugin->isMultisiteFarmBlog()) {
            echo '<div class="-panel postbox closed" id="'.esc_attr(str_replace('.', '', uniqid('pb-', true))).'">'."\n";
            echo '  <div class="-toggler handlediv"><br /></div>'."\n";

            echo '   <h3 class="-heading hndle">'."\n";
            echo '      <i class="si si-cloud"></i> '.__('Forecasting / Conditions', 'wp-super-snow')."\n";
            echo '   </h3>'."\n";

            echo '   <div class="-body inside">'."\n";
            echo '      <p>'.__('By default, WP Super Snow is displayed on every page of your site. However, it is DISABLED for mobile devices (not good for their CPUs or their batteries). If there are other conditions you\'d like to satisify before WP Super Snow is loaded (e.g., only load it on certain Posts/Pages; or only between specific dates/times; or only on certain devices); you can specify those conditions here using <a href="http://codex.wordpress.org/Conditional_Tags" target="_blank">Conditional Tags</a>.', 'wp-super-snow').'</p>'."\n";
            echo '      <table style="width:100%;"><tr><td style="width:1px; font-weight:bold; white-space:nowrap;"><code>if(</code></td><td><input type="text" name="'.esc_attr($this::GLOBAL_NS).'[saveOptions][conditionals]" value="'.esc_attr($this->Plugin->options['conditionals']).'" /></td><td style="width:1px; font-weight:bold; white-space:nowrap;"><code>)</code></td></tr></table>'."\n";
            echo '      <p class="-info">'.__('<strong>Example:</strong> <code>!wp_is_mobile() && is_page(\'christmas-promo\')</code> i.e., only run on one specific page.', 'wp-super-snow').'</p>'."\n";
            echo '      <p class="-info">'.__('<strong>Example:</strong> <code>!wp_is_mobile() && !is_ssl()</code> i.e., NOT on mobile devices &amp; NOT over HTTPS (SSL).', 'wp-super-snow').'</p>'."\n";
            echo '      <p class="-info">'.sprintf(__('<strong>Example:</strong> <code>!wp_is_mobile() && time() >= strtotime(\'%1$s-12-01\') && time() <= strtotime(\'%1$s-12-31\')</code> i.e., only run in the month of December %1$s.', 'wp-super-snow'), date('Y')).'</p>'."\n";
            echo '      <p class="-info">'.__('<strong>Example:</strong> <code>!wp_is_mobile()</code> i.e., only run on desktops/laptops; NOT on mobile devices. See also: <a href="http://detectmobilebrowsers.com/" target="_blank">DetectMobileBrowsers.com</a>', 'wp-super-snow').'</p>'."\n";
            echo '      <p class="-warning">'.__('<strong>MOBILE DEVICES:</strong> By default, mobile devices are excluded from the snow effect. It\'s not good for their CPUs (or their batteries).', 'wp-super-snow').'</p>'."\n";
            echo '   </div>'."\n";

            echo '</div>'."\n";
        }
        # Save and submit button...

        echo '<div class="-save submit">'."\n";
        echo '   <button type="submit" class="-button button button-primary">'.
                    __('Save All Changes', 'wp-super-snow').' <i class="si si-floppy-o"></i>'.
                '</button>'."\n";
        echo '</div>'."\n";

        # Closers.

        echo '</div>'."\n";
        echo '</div>'."\n";
        echo '</form>';
    }
}
