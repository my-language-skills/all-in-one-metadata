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
        event.preventDefault();
        var form = jQuery(this).closest('form');
        var loadingImage = jQuery(form).find('.properties-loading-image');
        var savingMessage = jQuery(form).find('.saving-message');
        loadingImage.show();
        savingMessage.hide();
        var data =  form.serialize();
        jQuery.post( 'options.php', data ).error(
            function() {
                savingMessage.text('Error Saving Settings');
                savingMessage.css('color','red');
                savingMessage.show();
                hideMessage(savingMessage);
            }).success( function() {
            loadingImage.hide();
            savingMessage.show();
            savingMessage.css('color','green');
            hideMessage(savingMessage);
        });
        return false;
    });

    //Function for hiding the message after its displayed
    function hideMessage(message){
        setTimeout( function(){
            message.hide();
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