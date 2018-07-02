<?php
/**
* The file containing the html for the specificMeta Metabox in the settings.
*
* @link       https://github.com/Books4Languages/pressbooks-metadata
* @since      0.10
*
* @package    Pressbooks_Metadata
* @subpackage Pressbooks_Metadata/admin/partials
* @author     Christos Amyrotos @MashRoofa
*/
?>

<p><?=__('Other Types of Metadata Vocabularies', 'all-in-one-metadata')?></p>
<div class="nav-tab-wrapper">
	<button class="tablinks-vocab nav-tab" onclick="openSett(event,'tablinks-vocab', 'coins','vocab')">Coins</button>
	<button class="tablinks-vocab nav-tab" onclick="openSett(event,'tablinks-vocab', 'dublin','vocab')">Dublin</button>
	<button class="tablinks-vocab nav-tab" onclick="openSett(event,'tablinks-vocab', 'educational','vocab')">Educational</button>
</div>

<div id="coins" class="vocab">
    <form method="post" action="options.php">
		<?php
		settings_fields( 'coins_level_tab' );
		do_settings_sections( 'coins_level_tab' );
		submit_button();
		echo '<br><br>';
		?>
    </form>
</div>

<div id="dublin" class="vocab">
    <form method="post" action="options.php">
		<?php
		settings_fields( 'dublin_level_tab' );
		do_settings_sections( 'dublin_level_tab' );
		submit_button();
		echo '<br><br>';
		?>
    </form>
</div>

<div id="educational" class="vocab">
    <form method="post" action="options.php">
		<?php
		settings_fields( 'educational_level_tab' );
		do_settings_sections( 'educational_level_tab' );
		submit_button();
		echo '<br><br>';
		?>
    </form>
</div>