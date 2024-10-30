<?php
/**
 * Plugin Name:Insert Google Analytics Id
 * Plugin URI: http://www.aarvis.com
 * Description: This is a simple plugin to insert your Google Analytics Tracking Id. This plugin  hooks the analytic code directly to the header section.
 * Version: 1.1.3
 * Author: Subhash Bhaskaran
 * Author URI: http://www.aarvis.com
 */
 	if ( ! function_exists('arvs_insert_google_analytics'))
	 {
		  function arvs_insert_google_analytics() 
			{ 
				 $arvs_gid = get_option( 'Tracking_Id'); 
				 if ($arvs_gid != null)
				 {
					?>
						<script data-cfasync="false">
						(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
						m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
						})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
						ga('create', '<?php echo($arvs_gid) ?>', 'auto');
						ga('send', 'pageview');

						</script>
					<?php
				 }
			}
	 }
 /*add_action('init', 'arvs_insert_google_analytics',10);*/
add_action('wp_head', 'arvs_insert_google_analytics');
 /** Step 2 (from text above). */
add_action( 'admin_menu', 'arvs_plugin_menu' );

/** Step 1. */
function arvs_plugin_menu() {
	add_options_page( 'Insert Google Analytics Id', 'Insert Google Analytics Id', 'manage_options', 'arvs-unique-identifier', 'arvs_plugin_options' );
}

/** Step 3. */
function arvs_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	 // variables for the field and option names 
    $arvs_opt_name = 'Tracking_Id';
    $arvs_hidden_field_name = 'mt_submit_hidden';
    $arvs_data_field_name = 'Tracking_Id';

    // Read in existing option value from database
    $arvs_opt_val = get_option( $arvs_opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $arvs_hidden_field_name ]) && $_POST[ $arvs_hidden_field_name ] == 'Y' ) 
	{
        // Read their posted value
        $arvs_opt_val = $_POST[ $arvs_data_field_name ];

        // Save the posted value in the database
        update_option( $arvs_opt_name, $arvs_opt_val );

        // Put a "settings saved" message on the screen

		?>
		<div class="updated"><p><strong><?php _e('settings saved.', 'arvs-menu' ); ?></strong></p></div>
		<?php

    }

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Insert Google Analytics Id', 'arvs-menu' ) . "</h2>";

    // settings form
    
    ?>

<form name="arvs_form" method="post" action="">

<input type="hidden" name="<?php echo $arvs_hidden_field_name; ?>" value="Y">

<p><?php _e(" Your Google Tracking Id : ", 'arvs-menu' ); ?> 
<input type="text" name="<?php echo $arvs_data_field_name; ?>" value="<?php echo $arvs_opt_val; ?>" size=20">
</p><hr /><br><table><tr><td>
<li>If you have not created your "Google Analytics Tracking ID" yet, then you can create one here <a href="https://www.google.com/analytics
">https://www.google.com/analytics</a><br><br>
<li>Copy and paste your ID (eg: UA-84****13-**34) in the above text field and click <b>"Save Changes"</b>. OK, you are done with integration. <br><br>
<li>You can verify the integration by using "Tag Assistant" extension in Google chrome. Otherwise you may directly login to Google analytics account and go to Reporting --> Real-TIme --> Overview section and check for online users. Please keep your website open in another window.<br><br>
<li>No bloated codes or style sheets to slow down your website. We keep it so simple...
</td>
<td>
<a href="https://aarvis.com"><img src = "https://aarvis.com/new-logo-3/"></a>
</td>
</tr>
</table>
<hr>

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>
<?php
 
}