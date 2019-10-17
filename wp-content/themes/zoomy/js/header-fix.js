jQuery(function($) {

	$(window).on('scroll', function() {
		// ヘッダーを固定する
		if ($(this).scrollTop() > 300) {
			if (!$('#js-header').hasClass('is-header-fixed')) {
				$('#js-header').addClass('is-header-fixed--animate').addClass('is-header-fixed');
				$(window).trigger('resize');

				setTimeout(function(){
					$('#js-header').removeClass('is-header-fixed--animate');
				}, 500);
			}
		} else {
			if ($('#js-header').hasClass('is-header-fixed')) {

				$('#js-header').removeClass('is-header-fixed--animate').removeClass('is-header-fixed');
				$(window).trigger('resize');
			}
		}
	});

});