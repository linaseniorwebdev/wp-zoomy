jQuery(function($){

	var winWidth = $(window).innerWidth();
	$(window).on('resize', function(){
		winWidth = $(window).innerWidth();
		checkModalScrollbar();
	});

	/**
	 * ログイン待ちアクションのログイン後処理を保存する変数
	 */
	var waitLoginVars = { type: null };

	/**
	 * メンバーメニュードロップダウン
	 */
	var membermenuDropdownInit = function(){
		var $membermenu = $('#js-header .p-member-menu');
		if ($membermenu.length) {
			var hideMembermenuTimer;
			var clearHideMembermenuInterval = function() {
				if (winWidth >= 992 && $membermenu.length) {
					if (hideMembermenuTimer) {
						clearInterval(hideMembermenuTimer);
						hideMembermenuTimer = null;
					}
				}
			};

			$('#js-header').on('click', '#js-header-member-menu-mypage', function(){
				if (winWidth < 992 && $membermenu.length) {
					$('body').removeClass('show-sidemenu');
					$membermenu.toggleClass('is-active');
					return false;
				}
			}).on('mouseenter', '#js-header-member-menu-mypage', function(){
				if (winWidth >= 992 && $membermenu.length) {
					clearHideMembermenuInterval();
					$membermenu.addClass('is-active');
				}
			}).on('mouseenter', '.p-member-menu', function(){
				clearHideMembermenuInterval();
			}).on('mouseout', '#js-header-member-menu-mypage, .p-member-menu', function(){
				clearHideMembermenuInterval();
				if (winWidth >= 992 && $membermenu.length) {
					hideMembermenuTimer = setInterval(function() {
						if (!$('#js-header-member-menu-mypage').is(':hover') && !$membermenu.is(':hover')) {
							clearHideMembermenuInterval();
							$membermenu.removeClass('is-active');
						}
					}, 20);
				}
			});
		}
	};
	membermenuDropdownInit();

	/**
	 * ログインURLリンククリック
	 */
	$(document).on('click', 'a[href^="'+TCD_MEMBERSHIP.login_url+'"], [data-url^="'+TCD_MEMBERSHIP.login_url+'"]', function(){
		if (!$('body').hasClass('logged-in')) {
			showModalLogin();
		}
		return false;
	});

	/**
	 * 要ログインリンククリック
	 */
	$(document).on('click', '.js-require-login', function(){
		if (!$('body').hasClass('logged-in')) {
			if (this.href) {
				waitLoginVars = {
					type: 'redirect',
					url: this.href
				};
			} else if ($(this).attr('data-url')) {
				waitLoginVars = {
					type: 'redirect',
					url: $(this).attr('data-url')
				};
			}
			showModalLogin();
			return false;
		}
	});

	/**
	 * モーダルログイン表示
	 */
	var showModalLogin = function() {
		if (location.href.indexOf(TCD_MEMBERSHIP.login_url) > -1){
			return false;
		}

		var $modal = $('#js-modal-login');
		if (!$modal.length) {
			var redirect = TCD_MEMBERSHIP.login_url;
			if (redirect.indexOf('?') > -1) {
				redirect += '&';
			} else {
				redirect += '?';
			}
			redirect += 'redirect_to='+encodeURIComponent(location.protocol + "//" + location.host + location.pathname + location.search);
			location.href = redirect;
			return false;
		}

		$('.p-modal.is-active').removeClass('is-active');
		$modal.addClass('is-active');
		checkModalScrollbar();
	};

	/**
	 * モーダルログインフォーム ajax送信
	 */
	$('#js-modal-login #js-modal-login-form').submit(function(){
		var $modal = $('#js-modal-login');
		var $form = $('#js-modal-login-form');
		if ($form.hasClass('is-processing')) return false;

		$form.addClass('is-processing').find('.p-membership-form__error').remove();

		$(this).ajaxSubmit({
			success: function(data, textStatus, XMLHttpRequest) {
				$form.removeClass('is-processing');
				if (data.success) {
					$('body').addClass('logged-in');

					if (data.header_member_menu) {
						$('#js-header .p-header-member-menu').html(data.header_member_menu);
					}
					if (data.member_menu) {
						$('#js-header .p-member-menu').remove();
						$('#js-header .l-header__bar').after(data.member_menu);
						membermenuDropdownInit();
					}
					if (data.footer_bar) {
						var $footer_bar = $($.parseHTML(data.footer_bar));
						$('#js-footer-bar').html($footer_bar.html()).attr('class', $footer_bar.attr('class')).attr('style', $footer_bar.attr('style'));
						$(window).trigger('scroll');
					}

					switch(waitLoginVars.type) {
						case 'redirect':
							location.href = waitLoginVars.url;
							break;
						case 'follow':
							ajaxToggleFollow(waitLoginVars.$elem, waitLoginVars.user_id);
							break;
						case 'like':
							ajaxToggleLike(waitLoginVars.$elem, waitLoginVars.post_id);
							break;
						default:
							var redirect = $form.find('[name="redirect_to"]').val();
;
							if (redirect) {
								location.href = redirect;
							}
							break;
					}
					waitLoginVars = { type: null }
					$modal.removeClass('is-active');
				} else if (data.error_message) {
					$form.find('.p-membership-form__button').append('<p class="p-membership-form__error">'+data.error_message+'</p>');
				} else {
					$form.find('.p-membership-form__button').append('<p class="p-membership-form__error">'+TCD_MEMBERSHIP.ajax_error_message+'</p>');
				}
				checkModalScrollbar();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$form.removeClass('is-processing');
				$form.find('.p-membership-form__button').append('<p class="p-membership-form__error">'+TCD_MEMBERSHIP.ajax_error_message+'</p>');
				checkModalScrollbar();
			}
		});

		return false;
	});

	/**
	 * 会員登録URLクリック
	 */
	$(document).on('click', 'a[href^="'+TCD_MEMBERSHIP.registration_url+'"]', function(){
		if (!$('body').hasClass('logged-in')) {
			showModalRegistration();
		}
		return false;
	});

	/**
	 * モーダル仮会員登録表示
	 */
	var showModalRegistration = function() {
		if (location.href.indexOf(TCD_MEMBERSHIP.registration_url) > -1 && location.href.indexOf('registration_account') > -1 ){
			return false;
		}

		var $modal = $('#js-modal-registration');
		if (!$modal.length) {
			var redirect = TCD_MEMBERSHIP.registration_url;
			if (redirect.indexOf('?') > -1) {
				redirect += '&';
			} else {
				redirect += '?';
			}
			redirect += 'redirect_to='+encodeURIComponent(location.protocol + "//" + location.host + location.pathname + location.search);
			location.href = redirect;
			return false;
		}

		$('.p-modal.is-active').removeClass('is-active');
		var $modal = $('#js-modal-registration');
		switchFormContents('#js-modal-registration-form', 'input');
		$modal.addClass('is-active');
		checkModalScrollbar();
	};

	/**
	 * 仮会員登録フォーム
	 */
	// 送信
	$('#js-registration-form').submit(function(){
		if ($(this).hasClass('is-processing')) return false;
		$(this).addClass('is-processing');
	});
	// モーダルのみajax送信
	$('#js-modal-registration-form').submit(function(){
		var $modal = $(this).closest('.p-modal');
		var $form = $(this);
		if ($form.hasClass('is-processing')) return false;

		$form.addClass('is-processing').find('.p-membership-form__error').remove();

		$(this).ajaxSubmit({
			success: function(data, textStatus, XMLHttpRequest) {
				$form.removeClass('is-processing');
				if (data.success) {
					if (data.registration_complete_desc) {
						$form.find('.p-membership-form__complete .p-membership-form__body').html(data.registration_complete_desc);
					}
					switchFormContents($form, 'complete');
					$form.addClass('is-completed');
				} else if (data.error_message) {
					$form.find('.p-membership-form__input .p-membership-form__button').append('<p class="p-membership-form__error">'+data.error_message+'</p>');
				} else {
					$form.find('.p-membership-form__input .p-membership-form__button').append('<p class="p-membership-form__error">'+TCD_MEMBERSHIP.ajax_error_message+'</p>');
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$form.removeClass('is-processing');
				$form.find('.p-membership-form__input .p-membership-form__button').append('<p class="p-membership-form__error">'+TCD_MEMBERSHIP.ajax_error_message+'</p>');
			}
		});

		return false;
	});

	/**
	 * 本会員登録・アカウント作成フォーム
	 */
	// html5バリデーションを走らせるためフォームsubmitで確認画面表示
	$('#js-registration-account-form').on('submit.confirm', function(){
		var confirm = createConfirmContents(this);
		if (confirm) {
			var $form = $(this);
			$form.find('.p-membership-form__confirm .p-membership-form__body').html(confirm);
			switchFormContents($form, 'confirm');
		}
		return false;
	});
	// 戻る
	$('#js-registration-account-form .js-back-button').click(function(){
		var $form = $(this).closest('form');
		switchFormContents($form, 'input');
		return false;
	});
	// 送信
	$('#js-registration-account-form .js-submit-button').click(function(){
		var $form = $(this).closest('form');
		if ($form.hasClass('is-processing')) return false;

		$form.addClass('is-processing').find('.p-membership-form__error').remove();

		// 確認処理を外してフォーム送信
		$form.off('submit.confirm').trigger('submit');
	});

	/**
	 * その他フォームの重複送信対策
	 */
	$('form.js-membership-form--normal').on('submit.processing', function(){
		if ($(this).hasClass('is-processing')) return false;
		$(this).addClass('is-processing');
	});

	/**
	 * 生年月日確認対策
	 */
	if ($('.p-membership-form__table-birthday .birthday-hidden').length) {
		$('.p-membership-form__table-birthday select').change(function(){
			var $cl = $(this).closest('.p-membership-form__table-birthday');
			var $hidden = $cl.find('.birthday-hidden');
			var year = $cl.find('.birthday-year').val();
			var month = $cl.find('.birthday-month').val();
			var day = $cl.find('.birthday-day').val();
			var birthday = '';

			if (!year && month && day) {
				birthday = $hidden.attr('data-format-md');
				birthday = birthday.replace('m', month);
				birthday = birthday.replace('d', day);
			} else if (year || month || day) {
				birthday = $hidden.attr('data-format-ymd');
				birthday = birthday.replace('y', year);
				birthday = birthday.replace('m', month);
				birthday = birthday.replace('d', day);
			}
			$hidden.val(birthday);
		});
		$('.p-membership-form__table-birthday .birthday-year').trigger('change');
	}

	/**
	 * フォロークリック
	 */
	$(document).on('click', '.js-toggle-follow', function(){
		var user_id = $(this).attr('data-user-id');
		if (!user_id) return false;
		if ($(this).hasClass('is-ajaxing')) return false;

		// 未ログインの場合はモーダルログイン表示
		if (!$('body').hasClass('logged-in')) {
			waitLoginVars = {
				type: 'follow',
				user_id: user_id,
				$elem: $(this)
			};
			showModalLogin();
			return false;
		}

		ajaxToggleFollow($(this), user_id);

		return false;
	});

	/**
	 * フォローajax
	 */
	var ajaxToggleFollow = function(el, user_id) {
		$(el).addClass('is-ajaxing');
		$.ajax({
			url: TCD_MEMBERSHIP.ajax_url,
			type: 'POST',
			data: {
				action: 'toggle_follow',
				user_id: user_id
			},
			success: function(data, textStatus, XMLHttpRequest) {
				$(el).removeClass('is-ajaxing');
				if (data.result == 'added') {
					$(el).addClass('p-button-following').removeClass('p-button-follow').html(data.text);
				} else if (data.result == 'removed') {
					$(el).addClass('p-button-follow').removeClass('p-button-following').html(data.text);
				} else if (data.message) {
					showModalAlert(data.message);
				} else {
					showModalAlert(TCD_MEMBERSHIP.ajax_error_message);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$(el).removeClass('is-ajaxing');
				showModalAlert(TCD_MEMBERSHIP.ajax_error_message);
			}
		});
	};

	/**
	 * いいねクリック
	 */
	$(document).on('click', '.js-toggle-like', function(){
		var self = this;
		var post_id = $(this).attr('data-post-id');
		if (!post_id) return false;
		if ($(this).hasClass('is-ajaxing')) return false;

		// 未ログインの場合はモーダルログイン表示
		if (!$('body').hasClass('logged-in')) {
			waitLoginVars = {
				type: 'like',
				post_id: post_id,
				$elem: $(this)
			};
			showModalLogin();
			return false;
		}

		ajaxToggleLike($(this), post_id)
		return false;
	});

	/**
	 * いいねajax
	 */
	var ajaxToggleLike = function(el, post_id) {
		$(el).addClass('is-ajaxing');
		$.ajax({
			url: TCD_MEMBERSHIP.ajax_url,
			type: 'POST',
			data: {
				action: 'toggle_like',
				post_id: post_id
			},
			success: function(data, textStatus, XMLHttpRequest) {
				$(el).removeClass('is-ajaxing');
				if (data.result == 'added') {
					$(el).addClass('p-icon-liked').removeClass('p-icon-like').html(data.likes_number);
				} else if (data.result == 'removed') {
					$(el).addClass('p-icon-like').removeClass('p-icon-liked').html(data.likes_number);
				} else if (data.message) {
					showModalAlert(data.message);
				} else {
					showModalAlert(TCD_MEMBERSHIP.ajax_error_message);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$(el).removeClass('is-ajaxing');
				showModalAlert(TCD_MEMBERSHIP.ajax_error_message);
			}
		});
	};

	/**
	 * 報告するクリック
	 */
	$('.js-report-button').on('click', function(){
		// 未ログインの場合はモーダルログイン表示
		if (!$('body').hasClass('logged-in')) {
			waitLoginVars = {
				type: 'report'
			};
			showModalLogin();
			return false;
		}

		$('.p-modal.is-active').removeClass('is-active');

		var $modal = $('#js-modal-report');
		var $form = $('#js-modal-report-form');

		switchFormContents($form, 'input');
		$modal.addClass('is-active');
		checkModalScrollbar();

		return false;
	});

	/**
	 * モーダル報告するフォーム
	 */
	// html5バリデーションを走らせるためフォームsubmitで確認画面表示
	$('#js-modal-report-form').on('submit.confirm', function(){
		var confirm = createConfirmContents(this);
		if (confirm) {
			var $form = $(this);
			$form.find('.p-membership-form__confirm .p-membership-form__body').html(confirm);
			switchFormContents($form, 'confirm');
			checkModalScrollbar();
		}
		return false;
	});
	// 戻る
	$('#js-modal-report .js-back-button').click(function(){
		var $form = $('#js-modal-report-form');
		switchFormContents($form, 'input');
		checkModalScrollbar();
		return false;
	});
	// ajax送信
	$('#js-modal-report .js-submit-button').click(function(){
		var $modal = $('#js-modal-report');
		var $form = $('#js-modal-report-form');
		if ($form.hasClass('is-ajaxing')) return false;

		$form.addClass('is-processing').find('.p-membership-form__error').remove();

		$.ajax({
			url: TCD_MEMBERSHIP.ajax_url,
			type: 'POST',
			data: {
				action: 'report_post',
				post_id: $form.find('[name="post_id"]').val(),
				report_comment: $form.find('[name="report_comment"]').val()
			},
			success: function(data, textStatus, XMLHttpRequest) {
				$form.removeClass('is-processing');

				if (data.success) {
					switchFormContents($form, 'complete');
					$form.trigger('reset');
				} else if (data.error_message) {
						$form.find('.p-membership-form__input .p-membership-form__button').append('<p class="p-membership-form__error">'+data.error_message+'</p>');
					switchFormContents($form, 'input');
				} else {
					$form.find('.p-membership-form__input .p-membership-form__button').append('<p class="p-membership-form__error">'+TCD_MEMBERSHIP.ajax_error_message+'</p>');
					switchFormContents($form, 'input');
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$form.removeClass('is-processing');
				$form.find('.p-membership-form__input .p-membership-form__button').append('<p class="p-membership-form__error">'+TCD_MEMBERSHIP.ajax_error_message+'</p>');
				switchFormContents($form, 'input');
			}
		});

		return false;
	});

	/**
	 * フォーム表示項目切り替え
	 */
	var switchFormContents = function(form, show) {
		if (show === 'input') {
			$(form).removeClass('is-confirm').removeClass('is-complete').addClass('is-input');
		} else if (show === 'confirm') {
			$(form).removeClass('is-input').removeClass('is-complete').addClass('is-confirm');
		} else if (show === 'complete') {
			$(form).removeClass('is-input').removeClass('is-confirm').addClass('is-complete');
		} else {
			return false;
		}
		checkModalScrollbar();
	};

	/**
	 * フォーム入力内容確認html生成
	 */
	var createConfirmContents = function(form) {
		var html = '';

		$(form).find('[data-confirm-label]:input').each(function(){
			if ($(this).is(':radio, :checkbox')) {
				if ($(this).is(':checked')) {
					html += '<tr><th>'+$(this).attr('data-confirm-label')+'</th><td>'+$(this).closest('label').text()+'</td></tr>'
				}
			} else if ($(this).is('textarea')) {
				html += '<tr><th>'+$(this).attr('data-confirm-label')+'</th><td>'+$(this).val().replace('\n', '<br>')+'</td></tr>'
			} else {
					html += '<tr><th>'+$(this).attr('data-confirm-label')+'</th><td>'+$(this).val()+'</td></tr>'
			}
		});

		if (html) {
			html = '<table class="p-membership-form__table p-membership-form__table-confirm">'+html+'</table>';
		}

		return html;
	};

	/**
	 * モーダル 閉じる
	 */
	$(document).on('click', '.p-modal .p-modal__close', function(event){
		if (!$(this).closest('.p-modal').find('.is-processing').length) {
			$(this).closest('.p-modal').removeClass('is-active');
		}
		return false;
	}).on('click', '.p-modal .p-modal__contents', function(event){
		event.stopPropagation();
	}).on('click', '.p-modal', function(event){
		if (!$(this).closest('.p-modal').find('.is-processing').length && !$(this).hasClass('.p-modal--disable-mask-click-close')) {
			$(this).removeClass('is-active');
		}
	});

	/**
	 * 汎用削除確認モーダル表示
	 */
	var waitDeleteConfirmVars = { type: null };
	$('form.js-delete-confirm').on('submit', function(){
		if ($(this).hasClass('is-processing')) return false;
	});
	$('form.js-delete-confirm').on('submit.deleteConfirm', function(){
		if ($(this).hasClass('is-processing')) return false;

		waitDeleteConfirmVars = {
			action: 'submit',
			$elem: $(this)
		};

		$('.p-modal.is-active').removeClass('is-active');
		$('#js-modal-delete-confirm').addClass('is-active');
		return false;
	});
	$(document).on('click.deleteConfirm', 'a.js-delete-confirm', function(){
		waitDeleteConfirmVars = {
			action: 'click',
			$elem: $(this)
		};
		return false;
	});
	// cancel
	$('#js-modal-delete-confirm .js-cancel-button').on('click', function(){
		$('#js-modal-delete-confirm').removeClass('is-active');
		return false;
	});
	// delete
	$('#js-modal-delete-confirm .js-submit-button').on('click', function(){
		if (waitDeleteConfirmVars.action === 'submit') {
			$('#js-modal-delete-confirm-form').addClass('is-processing');
			waitDeleteConfirmVars.$elem.off('submit.deleteConfirm').trigger('submit').addClass('is-processing');
		} else if (waitDeleteConfirmVars.action === 'click') {
			$('#js-modal-delete-confirm-form').addClass('is-processing');
			waitDeleteConfirmVars.$elem.off('click.deleteConfirm').trigger('click');
		} else {
			$('#js-modal-delete-confirm').removeClass('is-active');
		}
		return false;
	});

	/**
	 * モーダルスクロールバー有無チェック
	 */
	var checkModalScrollbar = function() {
		if ($('body').hasClass('is-wp-mobile-device')) return false;
		var $modal = $('.p-modal.is-active');
		var $modalContents = $modal.find('.p-modal__contents:visible');
		var modalInner = $modal.find('.p-modal__contents__inner:visible').get(0);
		if (!modalInner || !$modalContents.length) return false;
		if (modalInner.scrollHeight > $modalContents.height()) {
			$modal.addClass('has-scrollbar');
		} else {
			$modal.removeClass('has-scrollbar');
		}
	};

	/**
	 * モーダルアラート表示
	 */
	var showModalAlert = function(msg) {
		if (!msg) return false;

		var $modalAlert = $('#js-modal-alert');
		if (!$modalAlert.length) {
			var html = '<div id="js-modal-alert" class="p-modal p-modal--alert">';
			html += '<div class="p-modal__contents">';
			html += '<div class="p-modal__contents__inner">';
			html += '<div class="p-modal__body p-body"></div>';
			html += '<button class="p-modal__close">&#xe91a;</button></div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			$modalAlert = $(html).appendTo('body');
		}

		$('.p-modal.is-active').removeClass('is-active');
		$modalAlert.find('.p-modal__body').html(msg);
		$modalAlert.addClass('is-active');
	};

	// モーダルアラート自動表示
	if (TCD_MEMBERSHIP.auto_modal_alert_message) {
		$(document).on('js-initialized-after', function(){
			showModalAlert(TCD_MEMBERSHIP.auto_modal_alert_message);
		});
	}

	/**
	 * ブラウザ戻る対策
	 * 参考 http://mugen00.moo.jp/web/jquery/beforeunload
	 */
	if (TCD_MEMBERSHIP.browser_back_alert_messege) {
		(function(b) {
			var c = function() {
				this.initialize();
			};
			c.prototype = {
				initialize: function() {
					history.replaceState('beforeunload', null, null);
					history.pushState(null, null, null);
					b(window).on('popstate', b.proxy(this.popstate, this));
				},
				popstate: function(e) {
					if (e.originalEvent.state === 'beforeunload') {
						showModalAlert(TCD_MEMBERSHIP.browser_back_alert_messege);
					}
				},
			};
			new c();
		})(jQuery);
	}

	/**
	 * プレビュー確認画面でのリンククリック対策
	 */
	if (TCD_MEMBERSHIP.confirm_page_leave) {
		$('a').on('click', function(){
			return confirm(TCD_MEMBERSHIP.confirm_page_leave);
		});
	}


});
