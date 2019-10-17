jQuery(function($){

	var winWidth = $(window).innerWidth();
	$(window).on('resize', function(){
		winWidth = $(window).innerWidth();

		// ボーダーなしヘッダーバー レスポンシブ
		if ($('.p-member-menu--static').length) {
			if (winWidth < 992) {
				$('.p-header__bar').removeClass('u-no-border');
			} else {
				$('.p-header__bar').addClass('u-no-border');
			}
		}
	});

	/**
	 * ボーダーなしヘッダーバー
	 */
	if ($('.p-page-header__image').length) {
		$('.p-header__bar').addClass('u-no-border');
	}

	/**
	 * サイドメニュー
	 */
	$('#js-menu-button').click(function() {
		$('body').toggleClass('show-sidemenu');
		$('.p-member-menu').removeClass('is-active');

		$(window).on('scroll.sidemenuHeaderScroll', sidemenuHeaderScroll).on('resize.sidemenuHeaderScroll', sidemenuHeaderScroll).trigger('scroll')
		return false;
	});
	$('#js-sidemenu-close').click(function() {
		$('body').removeClass('show-sidemenu');
		$('.p-member-menu').removeClass('is-active');
		$(window).off('scroll.sidemenuHeaderScroll').off('resize.sidemenuHeaderScroll');
		return false;
	});
	$('.p-sidemnu a[href^="#"]').click(function() {
		$('body').removeClass('show-sidemenu');
	});
	var sidemenuHeaderScroll = function(event, b,c){
		var ad_h = $('#wpadminbar').height() || 0;
		var top = $('.l-header__bar').height() + ad_h;
		var bottom = 0;

		if (!$('.p-header__bar:visible').hasClass('u-no-border')) {
			top--;
		}

		if (!$('#js-header').hasClass('is-header-fixed')) {
			top -= $(window).scrollTop();
			if (top < ad_h) {
				top = ad_h;
			}
		}

		if ($('#js-footer-bar').hasClass('is-active')) {
			bottom = $('#js-footer-bar').height();
		}

		$('.p-sidemnu').css('top', top);
		$('.p-sidemnu').css('bottom', bottom);
	};

	/**
	 * スムーススクロール
	 */
	$('a[href^="#"]:not([href="#"])').on('click.smoothscroll', function() {
		if (this.hash) {
			if ($(this.hash).length) {
				var t = $(this.hash).offset().top;
				if (winWidth < 992) {
					if ($('body').hasClass('l-header--type2--mobile') || $('body').hasClass('l-header--type3--mobile')) {
						t -= 60;
					}
				} else {
					if ($('body').hasClass('l-header--type2') || $('body').hasClass('l-header--type3')) {
						t -= 80;
					}
				}
				$('body, html').animate({
					scrollTop: t
				}, 800);
			}
			return false;
		}
	});

	/**
	 * ページトップ
	 */
	var pagetop = $('#js-pagetop');
	pagetop.click(function() {
		$('body, html').animate({
			scrollTop: 0
		}, 1000);
		return false;
	});
	$(window).scroll(function() {
		if (winWidth < 992) {
			if ($(this).scrollTop() > 100) {
				pagetop.fadeIn(1000);
			} else {
				pagetop.fadeOut(300);
			}
		}
	});
	$('#js-pagetop a').off('click.smoothscroll');

	/**
	 * 記事一覧でのカテゴリークリック
	 */
	$(document).on('mouseenter', 'a [data-url]', function(){
		var $a = $(this).closest('a');
		$a.attr('data-href', $a.attr('href'));
		if ($(this).attr('data-url')) {
			$a.attr('href', $(this).attr('data-url'));
		}
	}).on('mouseleave', 'a [data-url]', function(){
		var $a = $(this).closest('a');
		$a.attr('href', $a.attr('data-href'));
	});

	/**
	 * コメント
	 */
	if ($('#js-comment__tab').length) {
		var commentTab = $('#js-comment__tab');
		commentTab.find('a').click(function() {
			if (!$(this).parent().hasClass('is-active')) {
				$($('.is-active a', commentTab).attr('href')).animate({opacity: 'hide'}, 0);
				$('.is-active', commentTab).removeClass('is-active');
				$(this).parent().addClass('is-active');
				$($(this).attr('href')).animate({opacity: 'show'}, 1000);
			}
			return false;
		});
	}

	/**
	 * カテゴリー ウィジェット
	 */
	$('.p-widget-categories li ul.children').each(function() {
		$(this).closest('li').addClass('has-children');
		$(this).hide().before('<span class="toggle-children"></span>');
	});
	$('.p-widget-categories .toggle-children').click(function() {
		$(this).closest('li').toggleClass('is-active').find('> ul.children').slideToggle();
	});
	$('.p-widget-categories li.current-cat').each(function() {
		$(this).parents('.has-children').each(function() {
			$(this).addClass('is-active').find('> ul.children').show();
		});
	});

	/**
	 * アーカイブウィジェット
	 */
	if ($('.p-dropdown').length) {
		$('.p-dropdown__title').click(function() {
			$(this).toggleClass('is-active');
			$('+ .p-dropdown__list:not(:animated)', this).slideToggle();
		});
	}

	/**
	 * WP検索ウィジェット
	 */
	$('.p-widget .searchform #searchsubmit').val($('<div>').html('&#xe915;').text());

	/**
	 * フッターウィジェット
	 */
	if ($('#js-footer-widget').length) {
		var footer_widget_resize_timer;
		var footer_widget_layout = function(){
			$('#js-footer-widget .p-widget').filter('.p-footer-widget__border-top').removeClass('p-footer-widget__border-top');

			if (winWidth < 992) {
				var $elems = $('#js-footer-widget .p-widget:visible');
				var elems_top = $elems.position().top || 0;
				var top = elems_top;
				$elems.each(function(i){
					var pos = $(this).position();
					if (pos.top !== elems_top && i > 0) {
						$(this).addClass('p-footer-widget__border-top');
					}
				});
			}
		};
		$(window).on('load', footer_widget_layout);
		$(window).on('resize', function(){
			clearTimeout(footer_widget_resize_timer);
			footer_widget_resize_timer = setTimeout(footer_widget_layout, 100);
		});
	}

	/**
	 * object-fit: cover未対応ブラウザ対策
	 */
	var ua = window.navigator.userAgent.toLowerCase();
	if (ua.indexOf('msie') > -1 || ua.indexOf('trident') > -1) {
		// object-fit: cover前提のcssをリセット
		var init_object_fit_cover = function(el) {
			$(el).css({
				width: 'auto',
				height: 'auto',
				maxWidth: 'none',
				minWidth: '100%',
				minHeight: '100%',
				top : 0,
				left : 0
			});
		};

		// サイズに応じてcss指定
		var fix_object_fit_cover = function(el) {
			$(el).each(function(){
				var $cl, cl_w, cl_h, cl_ratio, img_w, img_h, img_ratio, inc_ratio;
				$cl = $(this).closest('.js-object-fit-cover');
				cl_w = $cl.innerWidth();
				cl_h = $cl.innerHeight();
				cl_ratio = cl_w / cl_h;
				img_w = $(this).width();
				img_h = $(this).height();
				img_ratio = img_w / img_h;
				inc_ratio = cl_ratio - img_ratio;

				// 同じ縦横比
				if (inc_ratio >= 0 && inc_ratio < 0.1 || inc_ratio <= 0 && inc_ratio > -0.1) {
					$(this).removeAttr('style');

				// 縦長
				} else if (cl_ratio > img_ratio) {
					var t = (cl_w / img_w * img_h - cl_h) / 2 * -1;
					if (t < 0) {
						$(this).css({
							width: '100%',
							top: t
						});
					}

				// 横長・正方形
				} else {
					var l = (cl_h / img_h * img_w - cl_w) / 2 * -1;
					if (l < 0) {
						$(this).css({
							height: '100%',
							left: l
						});
					}
				}
			});
		};

		// cssリセット
		init_object_fit_cover($('.js-object-fit-cover img'));

		// 画像読み込み時処理
		$('.js-object-fit-cover img').load(function(){
			fix_object_fit_cover(this);
		}).each(function(){
			if (this.complete || this.readyState === 4 || this.readyState === 'complete') {
				fix_object_fit_cover(this);
			}
		});

		var object_fit_cover_resize_timer;
		$(window).on('resize.object_fit_cover', function(){
			clearTimeout(object_fit_cover_resize_timer);
			object_fit_cover_resize_timer = setTimeout(function(){
				$('.js-object-fit-cover img').each(function(){
					init_object_fit_cover(this);
					fix_object_fit_cover(this);
				});
			}, 500);
		});
	}

	/**
	 * 写真詳細 写真下テキストを画像幅に合わせる
	 */
	if ($('.p-entry-photo__inner').length) {
		var set_entry_photo_inner_max_width = function(img){
			var imgw = $(img).prop('naturalWidth') || $(img).width();
			if (imgw < 675) {
				imgw = 675;
			} else if (imgw > 1200) {
				imgw = 1200;
			}
			$('.p-entry-photo__inner').css('maxWidth', imgw);
		};
		$('.p-entry-photo__thumbnail img').load(function(){
			set_entry_photo_inner_max_width(this);
		}).each(function(){
			if (this.complete || this.readyState === 4 || this.readyState === 'complete') {
				set_entry_photo_inner_max_width(this);
			}
		});
	}

	/**
	 * 初期化処理
	 */
	$(document).on('js-initialized', function(){
		// フッタースライダー
		if ($('#js-footer-slider').length) {
			var footerSliderLastWidth = 0;
			$('#js-footer-slider').slick({
				adaptiveHeight: false,
				autoplay: true,
				autoplaySpeed: $('#js-footer-slider').attr('data-interval') * 1000 || 7000,
				arrows: true,
				prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
				nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
				dots: false,
				infinite: true,
				slidesToShow: 5,
				slidesToScroll: 5,
				speed: 1000,
				responsive : [
					{
						breakpoint: 992,
						settings: {
							slidesToShow: 4,
							slidesToScroll: 4
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3
						}
					},
					{
						breakpoint: 500,
						settings: {
							arrows: false,
							slidesToShow: 2,
							slidesToScroll: 2
						}
					}
				]
			}).on('setPosition', function(event, slick) {
				var w = $('#js-footer-slider').closest('.p-footer-blog').width();
				if (footerSliderLastWidth == w) return;
				footerSliderLastWidth == w;

				var diff = (w - $('#js-footer-slider').width()) / -2 ;
				$('#js-footer-slider .slick-prev').css('left', diff);
				$('#js-footer-slider .slick-next').css('right', diff);
			});
		}

		/**
		 * 複数行対応3点リーダ
		 */
		if ($('.js-multiline-ellipsis').length) {
			initMultilineEllipsis('.js-multiline-ellipsis');
		}
	});

});

/**
 * 複数行対応3点リーダ
 */
var multilineEllipsisVars = {
	winHeight: 0,
	winWidth: 0,
	timer: null
};
var initMultilineEllipsis = function(el){
	if (!el) {
		el = '.js-multiline-ellipsis';
	}
	jQuery(el).each(function(){
		jQuery(this).attr('data-default-text', jQuery(this).text());
	});
	multilineEllipsisVars.winHeight = 0;
	multilineEllipsisVars.winWidth = 0;
	setMultilineEllipsis(el);
	jQuery(window).off('resize.multilineEllipsis').on('resize.multilineEllipsis', resizeMultilineEllipsis);
};
var setMultilineEllipsis = function(el){
	winHeight = jQuery(window).innerHeight();
	winWidth = jQuery(window).innerWidth();

	if ( winHeight == multilineEllipsisVars.winHeight && winWidth == multilineEllipsisVars.winWidth ) {
		return false;
	}
	multilineEllipsisVars.winHeight = winHeight;
	multilineEllipsisVars.winWidth = winWidth;

	if (!el) {
		el = '.js-multiline-ellipsis';
	}

	jQuery(el).each(function(){
		var $target = jQuery(this);
		if ($target.is(':hidden')) return;

		var text = $target.attr('data-default-text');
		$target.text(text);
		var targetHeight = $target.height();
		var $clone = $target.clone();
		$clone.css({
			display : 'none',
			height: 'auto',
			maxHeight: 'none',
			overflow : 'visible',
			position : 'absolute',
			width: $target.innerWidth()
		});

		$target.after($clone);
		while((text.length > 0) && ($clone.height() > targetHeight)) {
			text = text.substr(0, text.length - 1);
			$clone.text(text + '...');
		}
		$target.text($clone.text());
		$clone.remove();
	});
};
var resizeMultilineEllipsis = function(){
	clearTimeout(multilineEllipsisVars.timer);
	multilineEllipsisVars.timer = setTimeout(setMultilineEllipsis, 100);
};
