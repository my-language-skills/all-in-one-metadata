//Code used to remove the Button (Add new site metadata) from the CPT Named Site-Meta

jQuery(document).ready(function() {

    var txt =  jQuery('.page-title-action').text();

    if(txt == 'Add New Site Metadata'){
        jQuery('.page-title-action').hide();
    }
});