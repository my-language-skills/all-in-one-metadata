jQuery(document).ready(function() {
    //Code used to remove the Button (Add new site metadata) from the CPT Named Site-Meta
    var txt =  jQuery('.page-title-action').text();

    if(txt == 'Add New Site Metadata'){
        jQuery('.page-title-action').hide();
    }

    // Get the element with id="defaultOpen" and click on it to make it the default open tab
    var i;
    var defaults = document.getElementsByClassName('defaultOpen');
    for (i = 0; i < defaults.length; i++) {
        defaults[i].click();
    }

    //Simple fix for the settings to save properly, without this the settings for choosing schema Types,
    //will not save properly
    jQuery('.active-schemas-forms').submit(function() {
        jQuery('.property-settings').remove();
    });

    //Submitting information for the property settings
    jQuery('.properties-options-form').submit(function(event){
        var form = jQuery(this).closest('form');
        event.preventDefault();
        jQuery('.properties-loading-image').show();
        jQuery('.saving-message').hide();
        var data =  form.serialize();
        jQuery.post( 'options.php', data ).error(
            function() {
                jQuery('.saving-message').text('Error Saving Settings');
                jQuery('.saving-message').css('color','red');
                jQuery('.saving-message').show();
                hideMessage();
            }).success( function() {
            jQuery('.properties-loading-image').hide();
            jQuery('.saving-message').show();
            jQuery('.saving-message').css('color','green');
            hideMessage();
        });
        return false;
    });

    //Function for hiding the message after its displayed
function hideMessage(){
    setTimeout( function(){
        jQuery('.saving-message').hide();
    }  , 2000 );
}

});

//Functions for the settings page
function openSett(evt, settName, tabType) {
    var i, tablinks,tabcontent;
    tabcontent = document.getElementsByClassName(tabType);
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(settName).style.display = "block";
    evt.currentTarget.className += " active";
}