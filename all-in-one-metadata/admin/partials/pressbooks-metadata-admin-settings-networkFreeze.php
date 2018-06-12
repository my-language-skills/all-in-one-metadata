<?php
/**
 * The file containing the html for the networkFreeze Metabox in the settings.
 *
 * @link       https://github.com/my-language-skills/all-in-one-metadata
 * @since      0.18
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/partials
 * @author     Daniil Zhitnitskii <danonchik98@gmail.com>
 */
?>



	<div id="networkFreeze" class="levels">
		<form method="post" action="options.php">
			<?php
			settings_fields( 'network_freeze' );
			do_settings_sections( 'network_freeze' );
			submit_button();
			?>
		</form>
		<p></p>
	</div>

