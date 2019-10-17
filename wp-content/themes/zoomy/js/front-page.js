jQuery(function($){

	/**
	 * ボーダーなしヘッダーバー
	 */
	if ($('.p-index-video').length || $('#js-index-slider').length) {
		$('.p-header__bar').addClass('u-no-border');
	}

	/**
	 * コンテンツビルダー最終コンテンツが背景ありの場合クラス追加
	 */
	if ($('.p-cb__item:last').hasClass('has-bg')) {
		$('.l-main').addClass('is-cb__last-item__has-bg');
	}

	/**
	 * 初期化処理
	 */
	$(document).on('js-initialized', function(){

		/**
		 * モバイル全高表示でcssでのvh指定だとアドレスバー分ずれる対策初期化処理
		 */
		var hcmlLastWidth = 0;
		var hcmlLastHeight = 0;
		var setHeaderContentMobileHeight = function(){
			var w = $(window).innerWidth() || $('body').width();
			var h = $(window).innerHeight();
			if (hcmlLastWidth === w && hcmlLastHeight === h) return;
			hcmlLastWidth = w;
			hcmlLastHeight = h;

			if (w > 767) {
				$('.p-index-video, .p-index-slider, .p-header-content__image > img, #js-index-youtube').removeAttr('style');
			} else {
				// ヘッダーバー分減らす
				h -= $('body.l-header--type1--mobile #js-header,body.l-header--type2--mobile #js-header').height();

				// アドミンバー分減らす
				h -= $('#wpadminbar').height();

				$('.p-index-video, .p-index-slider, .p-header-content__image > img').height(h);

				// youtubeの場合16：9に合わせて左右をはみ出して表示
				if ($('#js-index-youtube').length) {
					var ytw = Math.ceil(h / 9 * 16);
					var ytl = (ytw - w) / -2;
					$('#js-index-youtube').css({
						width: ytw,
						left: ytl
					});
				}
			}
		};

		/**
		 * header video/youtube
		 */
		if ($('.p-index-video').length) {
			setHeaderContentMobileHeight();
			$(window).on('resize', function(){
				setHeaderContentMobileHeight();
			});
		}

		/**
		 * header video
		 */
		if ($('#js-index-video').length) {
			$('#js-index-video').get(0).play();
			$('.p-index-video').addClass('is-active');

		/**
		 * header youtube
		 */
		} else if ($('#js-index-youtube').length) {
			var $youtube = $('#js-index-youtube');
			$youtube.on('load', function(){
				$youtube.closest('.p-index-video').addClass('is-active');
				$youtube.animate({opacity:1}, 1000).get(0).contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
			});

			// loadイベントが発火しない対策
			if ($youtube.attr('data-src')) {
				$youtube.attr('src', $youtube.attr('data-src'));
			}

		/**
		 * header video/youtube mobile device
		 */
		} else if ($('.p-index-video').length) {
			$('.p-index-video').addClass('is-active');
		}

		/**
		 * header slider
		 */
		if ($('#js-index-slider').length) {
			var $slider = $('#js-index-slider');
			var $slides = $('#js-index-slider .p-index-slider__item');

			$slider.slick({
				adaptiveHeight: true,
				arrows: false,
				prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
				nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
				autoplay: true,
				autoplaySpeed: $('#js-index-slider').attr('data-interval') * 1000 || 7000,
				dots: $slides.length > 1,
				fade: false,
				infinite: true,
				lazyLoad: 'progressive',
				slide: '.p-index-slider__item',
				slidesToShow: 1,
				slidesToScroll: 1,
				speed: 600,
				responsive: [
					{
						breakpoint: 768,
						settings: {
							dots: false
						}
					}
				]
			});

			// モバイル全高表示でcssでのvh指定だとアドレスバー分ずれる対策
			setHeaderContentMobileHeight();

			// first slide activate
			setTimeout(function(){
				$slider.addClass('is-active');
				$slides.filter('.slick-active').addClass('is-active');
			}, 600);

			// beforeChange
			$slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
				$slides.filter('.is-active').removeClass('is-active')
			});

			// afterChange
			$slider.on('afterChange', function(event, slick, currentSlide) {
				$slides.filter('.slick-active').addClass('is-active');
			});
		}

		/**
		 * header content mobile arrow
		 */
		$('.p-header-content__mobile-arrow').click(function(){
			var $cl = $(this).closest('.p-index-slider, .p-index-video');
			if ($cl.length) {
				var scrollTo = $cl.offset().top + $cl.outerHeight();
				if ($('body').is('.l-header--type2--mobile, .l-header--type3--mobile')) {
					scrollTo -= $('.l-header__bar--mobile').height();
				}

				$('body, html').animate({
					scrollTop: scrollTo
				}, 500);
			}
			return false;
		});

		/**
		 * news ticker
		 */
		if ($('#js-index-newsticker').length) {
			$('#js-index-newsticker').slick({
				infinite: true,
				dots: false,
				arrows: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: true,
				autoplay: true,
				speed: 1000,
				fade: true,
				autoplaySpeed: $('#js-index-newsticker').attr('data-interval') * 1000 || 7000
			});
		}
	});

});
