jQuery(document).ready(function(){

	jQuery('#page-meta').hide();
	jQuery('.page-meta-btn a, #page-meta a.close').live('click', function() {
		if(jQuery('#page-meta').css('display') == 'none') {
			jQuery('.page-meta-btn a').addClass('tabbed');
			jQuery('.page-meta-btn').addClass('bg-color');
			jQuery('#page-meta').toggle({ duration:200 });
			return false;
		} else {
			jQuery('.page-meta-btn a').removeClass('tabbed');
			jQuery('.page-meta-btn').removeClass('bg-color');
			jQuery('#page-meta').toggle({ duration:100 });
			return false;
		}
	});

	jQuery('#related-books').hide();
	jQuery('.related-books-btn a, #related-books a.close').live('click', function() {
		if(jQuery('#related-books').css('display') == 'none') {
			jQuery('.related-books-btn a').addClass('tabbed');
			jQuery('.related-books-btn').addClass('bg-color');
			jQuery('#related-books').toggle({ duration:200 });
			return false;
		} else {
			jQuery('.related-books-btn a').removeClass('tabbed');
			jQuery('.related-books-btn').removeClass('bg-color');
			jQuery('#related-books').toggle({ duration:100 });
			return false;
		}
	});
});

