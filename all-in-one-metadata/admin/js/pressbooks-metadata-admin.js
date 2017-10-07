jQuery(document).ready(function() {
    //Code used to remove the Button (Add new site metadata) from the CPT Named Site-Meta
    var txt =  jQuery('.page-title-action').text();

    if(txt == 'Add New Site Metadata'){
        jQuery('.page-title-action').hide();
    }

    // Get the element with id="defaultOpen" and click on it to make it the default open tab
    var i;
    var defaults = document.getElementsByClassName('nav-tab-active');
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

    //Handling the overwrite_prop_clean button
    jQuery('.property-overwrite').click(function(){
        var btn = this.id + '_btn';
        var btn2 = this.id + '_btn2';
        if ( jQuery(this).is(':checked') ) {
            jQuery('#'+btn2).addClass('hide');
            jQuery('#'+btn).addClass('hide');
        }
        else {
            jQuery('#'+btn2).removeClass('hide');
            jQuery('#'+btn).removeClass('hide');
        }
    });

    //Handling the overwrite_prop_disable
    jQuery('.overwrite_prop_disable').click(function(event) {
        event.preventDefault();
        var propId = jQuery(this).attr('id');
        if(confirm('Note that by continuing you are disabling this property from all relevant posts')){
            var data = {
                'action': 'overwrite_prop_disable',
                'property': propId
            };
            jQuery.post( 'admin-ajax.php', data ).error(
                function() {
                    savingMessage.text('Error Disabling Properties');
                    savingMessage.css('color','red');
                    savingMessage.show();
                    loadingImage.hide();
                    hideMessage(savingMessage);
                }).success( function() {

            });
        }
    });

    //Handling the overwrite_prop_clean
    jQuery('.overwrite_prop_clean').click(function(event) {
        event.preventDefault();
        var propId = jQuery(this).attr('id');
        if(confirm('Note that by continuing you are deleting this property from all relevant posts')){
            var data = {
                'action': 'overwrite_prop_clean',
                'property': propId
            };
            jQuery.post( 'admin-ajax.php', data ).error(
                function() {
                    savingMessage.text('Error Clearing Properties');
                    savingMessage.css('color','red');
                    savingMessage.show();
                    loadingImage.hide();
                    hideMessage(savingMessage);
                }).success( function() {

            });
        }
    });

    //Clicking on the last visited tab
    var buttonGroups = ['tablinks-level','tablinks-activeSch','tablinks-vocab'];
    for (i = 0; i < buttonGroups.length; i++) {
        var buttons = document.getElementsByClassName(buttonGroups[i]);
        var lastClickedTab = localStorage.getItem(buttonGroups[i]);
        if(buttons[0] == null) continue;
        if(lastClickedTab == null){
            buttons[0].className += " nav-tab-active";
            buttons[0].click();
        }else{
            let found = false;
            for (j = 0; j < buttons.length; j++) {
                if(buttons[j].textContent == lastClickedTab){
                    buttons[j].className += " nav-tab-active";
                    buttons[j].click();
                    found = true;
                    break;
                }
            }
            if(found == false){
                buttons[0].className += " nav-tab-active";
                buttons[0].click();
            }
        }
    }

    //Autosaving parent filters on change
    jQuery('#parent_filter_form :input').change(function(){
        let data = jQuery('#parent_filter_form').serialize();
        jQuery.post( 'options.php', data ).error(
            function() {
                alert('Error filtering, please refresh')
            }).success( function() {
                location.reload();
        });
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

//TODO Remember to fix this
//Function that alerts the user when he is trying to leave the page without all the property settings being saved
/*jQuery(document).ajaxStart(function() {
 window.onbeforeunload = confirmExit;
 function confirmExit()
 {
 return "Not all properties are saved.  Are you sure you want to exit this page?";
 }
 });*/

//Function for hiding the message after its displayed
function hideMessage(message){
    setTimeout( function(){
        message.hide();
    }  , 2000 );
}

//Functions for the settings page
function openSett(evt,tablink, settName, tabType) {
    //Saving the last visited tab
    localStorage.setItem(tablink,evt.currentTarget.textContent);
    var i, tablinks,tabcontent;
    tabcontent = document.getElementsByClassName(tabType);
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName(tablink);
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" nav-tab-active", "");
    }
    document.getElementById(settName).style.display = "block";
    evt.currentTarget.className += " nav-tab-active";
}