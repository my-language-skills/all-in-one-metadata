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

    //Making sure that the parents selection in the properties of each type is is on the default value
    jQuery('.selectParent').val('parents');

    //Simple fix for the settings to save properly, without this the settings for choosing schema Types,
    //will not save properly
    jQuery('.active-schemas-forms').submit(function() {
        jQuery('.property-settings').remove();
    });

    //TODO Here we need to cancel all requests before making a new one, this approach will make the submission faster
    //Submitting information for the property settings
    jQuery('.property-checkbox').on('click',function(){
        var form = jQuery(this).closest('form');
        var loadingImage = jQuery('.properties-loading-image');
        var savingMessage = jQuery('.saving-message');
        loadingImage.show();
        savingMessage.hide();
        var data =  form.serialize();
        jQuery.post( 'options.php', data ).error(
            function() {
                savingMessage.text('Error Saving Settings');
                savingMessage.css('color','red');
                savingMessage.show();
                loadingImage.hide();
                hideMessage(savingMessage);
            }).success( function() {

        });
    });

    //Function that handles the display of the parent types properties in the properties section
    jQuery('.selectParent').change(function() {
        var form = jQuery(this).parent();
        var name = jQuery(form).find('.selectParent :selected').val();
        jQuery(form).find('.parents').hide();
        jQuery(form).find('#' + name).show();
    });

    //Controlling the parent filtering for the schema types
    jQuery('#parent-filters-form').find('th').remove();
    jQuery('#parent-filters-form').find('tr').css("float","left");
    jQuery(".parent-filters-settings").prop('checked', false);

    jQuery('.parent-filters').click(function(event){
        event.preventDefault();
        var parentName = jQuery(this).attr('id');
        parentName = parentName.replace("link", "setting");
        console.log(parentName);
        jQuery("#"+parentName).attr('checked', 'checked');
        jQuery('#parent-filters-form').submit();
    });
});

//Function that alerts when all property settings are saved
jQuery(document).ajaxStop(function() {
    var loadingImage = jQuery('.properties-loading-image');
    var savingMessage = jQuery('.saving-message');
    window.onbeforeunload = null;
    loadingImage.hide();
    savingMessage.show();
    savingMessage.css('color','green');
    hideMessage(savingMessage);
});

//Function that alerts the user when he is trying to leave the page without all the property settings being saved
jQuery(document).ajaxStart(function() {
    window.onbeforeunload = confirmExit;
    function confirmExit()
    {
        return "Not all properties are saved.  Are you sure you want to exit this page?";
    }
});

//Function for hiding the message after its displayed
function hideMessage(message){
    setTimeout( function(){
        message.hide();
    }  , 2000 );
}

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