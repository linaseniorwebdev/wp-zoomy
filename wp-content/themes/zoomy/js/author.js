jQuery(function($){

	var $authorList = $('#js-author__list');
	var currentPage = 1;
	var authorListCache = {};
	var tabsInitialOffsetTop = 0;
	var ajaxloading = false;
	var ajaxInfiniteScrolling = false;

	var winWidth = window.innerWidth || $('body').width();
	$(window).on('resize', function(){
		winWidth = window.innerWidth || $('body').width();

		tabsInitialOffsetTop = $authorList.offset().top;
	});

	/**
	 * ボーダーなしヘッダーバー
	 */
	if ($('.p-author__header_image').length) {
		$('.p-header__bar').addClass('u-no-border');
	}

	/**
	 * 投稿者リスト取得
	 */
	var get_author_list = function(listType, nextpage, scrollTo) {
		if (!listType) return false;
		var userId = $authorList.attr('data-user-id');
		if (!userId) return false;

		var page = 1;
		if (nextpage) {
			page = currentPage + 1;
		}

		if (scrollTo) {
			var toScrollTop;
			if (winWidth < 992) {
				toScrollTop = tabsInitialOffsetTop - 90;
			} else {
				toScrollTop = tabsInitialOffsetTop - 80;
			}
			if ($(window).scrollTop() > toScrollTop) {
				$(window).scrollTop(toScrollTop);
			}
		}

		if (page == 1) {
			$('.p-author__list-tab.max-paged').removeClass('max-paged');
		}

		if (!authorListCache[listType]) {
			authorListCache[listType] = {};
		} else {
			if (authorListCache[listType][page]) {
				render_author_list(authorListCache[listType][page], page);
				currentPage = page;
				return;
			}
		}

		if (page == 1) {
			$authorList.html('').addClass('ajax-loading');
		} else {
			$authorList.addClass('ajax-infinite-loading');
		}

		ajaxloading = true;
		$.ajax({
			url: TCD_FUNCTIONS.ajax_url,
			type: 'GET',
			data: {
				action: 'get_author_list',
				list_type: listType,
				user_id: userId,
				paged: page
			}
		}).success(function(data, textStatus, XMLHttpRequest) {
			render_author_list(data, page);
			authorListCache[listType][page] = data;
			currentPage = page;
			ajaxloading = false;
			ajaxInfiniteScrolling = false;
		}).error(function(XMLHttpRequest, textStatus, errorThrown) {
			$authorList.removeClass('ajax-loading').removeClass('ajax-infinite-loading').append('<p class="p-author__list-error">' + TCD_FUNCTIONS.ajax_error_message + '</p>');
			ajaxloading = false;
			ajaxInfiniteScrolling = false;
		});
	};

	/**
	 * 投稿者リストフェードイン表示
	 */
	var render_author_list = function(data, page){
		var $data = $($.parseHTML(data));
		if (page == 1) {
			$data.find('.p-author__list-item').addClass('fadein').css('opacity', 0);
			$authorList.removeClass('ajax-loading').html($data);
		} else {
			$data.filter('.p-author__list-item').addClass('fadein').css('opacity', 0);
			$authorList.removeClass('ajax-infinite-loading').find('.p-author__list__inner').append($data);
			$(window).trigger('scroll');
		}

		// 複数行対応3点リーダー
		var $multilineEllipsis = $data.find('.js-multiline-ellipsis');
		if ($multilineEllipsis.length) {
			initMultilineEllipsis($multilineEllipsis);
		}

		// object-fit: cover未対応ブラウザ対策
		$(window).trigger('resize.object_fit_cover');

		$authorList.find('.fadein').each(function(i){
			$(this).removeClass('fadein').delay((i+1) * 300).animate({opacity: 1}, 500);
		});
	};

	/**
	 * タブクリック
	 */
	$('.p-author__list-tab').click(function(){
		if ($(this).hasClass('is-active') || ajaxloading) return false;
		$(this).siblings('.is-active').removeClass('is-active');
		$(this).addClass('is-active');
		get_author_list($(this).attr('data-list-type'), false, true);
		return false;
	});

	/**
	 * 無限スクロール
	 */
	$(window).scroll(function(){
		if (ajaxloading || ajaxInfiniteScrolling) return;

		var $activeTab = $('.p-author__list-tab.is-active');
		if ($activeTab.hasClass('max-paged')) return;

		var st = $(window).scrollTop();
		var wh = window.innerHeight || $(window).innerHeight();
		var alt = $authorList.offset().top;
		var alh = $authorList.height();
		if (st + wh * 0.8 >= alt + alh && st + wh * 0.2 <= alt + alh ) {
			var maxPage = $activeTab.attr('data-max-page');
			if (currentPage + 1 > maxPage) {
				$activeTab.addClass('max-paged');
			} else {
				ajaxInfiniteScrolling = true;
				get_author_list($activeTab.attr('data-list-type'), true, false);
				if (currentPage + 1 >= maxPage) {
					$activeTab.addClass('max-paged');
				}
			}
		}
	});

	/**
	 * ロード時処理
	 */
	$(document).on('js-initialized-after', function(){
		tabsInitialOffsetTop = $authorList.offset().top - $('.p-author__list-tabs').height();
		get_author_list($('.p-author__list-tab.is-active').attr('data-list-type'), false, false);

		/**
		 * タブfixed表示
		 */
		$(window).scroll(function(){
			var st = $(window).scrollTop();
			if (st > tabsInitialOffsetTop - 150) {
				var t = $('.p-author__list-tabs').height();
				var h = $authorList.innerHeight();
				if (winWidth > 600) {
					t += $('#wpadminbar').height();
				}
				if ($('.l-header__bar').css('position') === 'fixed') {
					t += $('.l-header__bar').height();
				}
				if (st > tabsInitialOffsetTop - t && st < tabsInitialOffsetTop - t + h - 150) {
					$('body').addClass('is-author__list-tabs-fixed');
				} else if ($('body').hasClass('is-author__list-tabs-fixed')) {
					$('body').removeClass('is-author__list-tabs-fixed');
				}
			} else if ($('body').hasClass('is-author__list-tabs-fixed')) {
				$('body').removeClass('is-author__list-tabs-fixed');
			}
		});
	});

});
