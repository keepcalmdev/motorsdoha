(function($){

	$(document).ready(function(){

		var bsaProItem = $('.bsaProItem');
		bsaProItem.each(function() {
			if ( $(this).data('animation') != null && $(this).data('animation') != 'none' ) {
				$(this).addClass('bsaHidden').viewportChecker({
					// Class to add to the elements when they are visible
					classToAdd: 'animated ' + $(this).data('animation'),
					offset: 100,
					repeat: false,
					callbackFunction: function(elem, action){}
				});
			}
		});

	});

})(jQuery);