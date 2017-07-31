<?php
/**
* The file containing the html for the specificMeta Metabox in the settings.
*
* @link       https://github.com/Books4Languages/pressbooks-metadata
* @since      0.x
*
* @package    Pressbooks_Metadata
* @subpackage Pressbooks_Metadata/admin/partials
* @author     Christos Amyrotos <christosv2@hotmail.com>
*/
?>

<p>Other Types of Metadata Vocabularies</p>
<div class="nav-tab-wrapper">
	<button class="tablinks nav-tab defaultOpen" onclick="openSett(event, 'coins','vocab')">Coins</button>
	<button class="tablinks nav-tab" onclick="openSett(event, 'dublin','vocab')">Dublin</button>
	<button class="tablinks nav-tab" onclick="openSett(event, 'educational','vocab')">Educational</button>
</div>

<div id="coins" class="vocab">
	<h3>Coins Metadata</h3>
</div>

<div id="dublin" class="vocab">
	<h3>Dublin Metadata</h3>
</div>

<div id="educational" class="vocab">
	<h3>Educational Metadata</h3>
</div>