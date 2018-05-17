<?php
/**
* The file containing the html for the genral settings Metabox in the settings.
*
* @link       https://github.com/Books4Languages/pressbooks-metadata
* @since      0.x
*
* @package    Pressbooks_Metadata
* @subpackage Pressbooks_Metadata/admin/partials
* @author     Christos Amyrotos <christosv2@hotmail.com>
*/
?>

<form method="post" action="options.php">
    <?php
    settings_fields( 'general_settings_page' );
    do_settings_sections( 'general_settings_page' );
    submit_button();
    echo '<br><br>';
    ?>
</form>
