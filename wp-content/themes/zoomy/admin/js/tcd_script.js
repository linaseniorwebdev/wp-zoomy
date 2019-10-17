jQuery(function($){

	// ローカライズメッセージ未設定時
	if (!window.TCD_MESSAGES) {
		TCD_MESSAGES = {
			ajaxSubmitSuccess: 'Settings Saved Successfully',
			ajaxSubmitError: 'Can not save data. Please try again.'
		};
	}

	// テーマオプション AJAX保存
	$('#tcd_theme_right').on('click', '.ajax_button', function() {
		var $button = $('.button-ml');
		$('#saveMessage').hide();
		$('#saving_data').show();
		if (window.tinyMCE) {
			tinyMCE.triggerSave(); // tinymceを利用しているフィールドのデータを保存
		}
		$('#tcd_theme_right form').ajaxSubmit({
			beforeSend: function() {
				$button.attr('disabled', true); // ボタンを無効化し、二重送信を防止
			},
			complete: function() {
				$button.attr('disabled', false); // ボタンを有効化し、再送信を許可
			},
			success: function(){
				$('#saving_data').hide();
				$('#saved_data').html('<div id="saveMessage" class="successModal"></div>');
				$('#saveMessage').append('<p>' + TCD_MESSAGES.ajaxSubmitSuccess + '</p>').show();
				setTimeout(function() {
					$('#saveMessage:not(:hidden, :animated)').fadeOut();
				}, 3000);
			},
			error: function() {
				$('#saving_data').hide();
				alert(TCD_MESSAGES.ajaxSubmitError);
			},
			timeout: 10000
		});
		return false;
	});
	$('#tcd_theme_option, #tcd_membership_option').on('click', '#saveMessage', function(){
		$('#saveMessage:not(:hidden, :animated)').fadeOut(300);
	});

	// アコーディオンの開閉
	$('.theme_option_field').on('click', '.theme_option_subbox_headline', function(){
		$(this).closest('.sub_box').toggleClass('active');
		return false;
	});

	// theme option tab
	$('#tcd_theme_option').cookieTab({
		tabMenuElm: '#theme_tab',
		tabPanelElm: '#tab-panel'
	});
	$('#tcd_membership_option').cookieTab({
		tabMenuElm: '#theme_tab',
		tabPanelElm: '#tab-panel'
	});

	// WordPress Color Picker
	$('.c-color-picker').wpColorPicker();

	// ロゴに画像を使うかテキストを使うか選択
	$('#header_logo_type_select :radio, #header_logo_type_select_mobile :radio').change(function(){
		var mobile = '';
		if ($(this).closest('#header_logo_type_select_mobile').length) {
			mobile = '_mobile';
		}
		if (this.checked) {
			if (this.value == 'yes') {
				$('.header_logo_text_area'+mobile).hide();
				$('.header_logo_image_area'+mobile).show();
			} else {
				$('.header_logo_text_area'+mobile).show();
				$('.header_logo_image_area'+mobile).hide();
			}
		}
	});
	$('#footer_logo_type_select :radio, #footer_logo_type_select_mobile :radio').change(function(){
		var mobile = '';
		if ($(this).closest('#footer_logo_type_select_mobile').length) {
			mobile = '_mobile';
		}
		if (this.checked) {
			if (this.value == 'yes') {
				$('.footer_logo_text_area'+mobile).hide();
				$('.footer_logo_image_area'+mobile).show();
			} else {
				$('.footer_logo_text_area'+mobile).show();
				$('.footer_logo_image_area'+mobile).hide();
			}
		}
	});

	// load color 2
	$('#js-load_icon').change(function() {
		if ('type2' === this.value) {
			$('.js-load_color2').show();
		} else {
			$('.js-load_color2').hide();
		}
	}).filter(':checked').trigger('change');

	// Googleマップ
	$('#gmap_marker_type_button_type2').click(function () {
		$('#gmap_marker_type2_area').show();
	});
	$('#gmap_marker_type_button_type1').click(function () {
		$('#gmap_marker_type2_area').hide();
	});
	$('#gmap_custom_marker_type_button_type1').click(function () {
		$('#gmap_custom_marker_type1_area').show();
		$('#gmap_custom_marker_type2_area').hide();
	});
	$('#gmap_custom_marker_type_button_type2').click(function () {
		$('#gmap_custom_marker_type1_area').hide();
		$('#gmap_custom_marker_type2_area').show();
	});

	// ロゴプレビュー
	if ($('[data-logo-width-input]').length) {
		var logoPreviewVars = [];

		// initialize
		$('[data-logo-width-input]').each(function(i){
			logoPreviewVars[i] = {};
			var lpObj = logoPreviewVars[i];
			lpObj.$preview = $(this);
			lpObj.$logo = $('<div class="slider_logo_preview-logo">');
			lpObj.$logoWidth = $($(this).attr('data-logo-width-input'));
			lpObj.$logoImg = $($(this).attr('data-logo-img'));
			lpObj.logoImgSrc = null;
			lpObj.logoImgSrcFirst = null;
			lpObj.$bgImg = null;
			lpObj.bgImgSrc = null;
			lpObj.$Overlay = $('<div class="slider_logo_preview-overlay"></div>');
			lpObj.$displayOverlay = $($(this).attr('data-display-overlay'));
			lpObj.$overlayColor = $($(this).attr('data-overlay-color'));
			lpObj.$overlayOpacity = $($(this).attr('data-overlay-opacity'));


			lpObj.$preview.html('').append(lpObj.$logo).append(lpObj.$Overlay);
			lpObj.$preview.closest('.slider_logo_preview-wrapper').hide();

			if (lpObj.$logoImg && lpObj.$logoImg.length) {
				lpObj.logoImgSrcFirst = lpObj.$logoImg.attr('src'); 
			}

			// logo dubble click to width reset
			lpObj.$logo.on('dblclick', function(){
				lpObj.$logoWidth.val(0);
				lpObj.$logo.width(lpObj.$logo.attr('data-origin-width'));
			});
		});

		// logo, bg change
		var logoPreviewChange = function(){
			for(var i = 0; i < logoPreviewVars.length; i++) {
				var lpObj = logoPreviewVars[i];
				var isChange = false;

				lpObj.$logoImg = $(lpObj.$preview.attr('data-logo-img'));
				lpObj.$bgImg = null;

				// data-bg-imgはカンマ区切りでの複数連動対応しているため順番に探す
				if (lpObj.$preview.attr('data-bg-img')) {
					var bgImgClasses = lpObj.$preview.attr('data-bg-img').split(',');
					$.each(bgImgClasses, function(i,v){
						if (!v) return;
						if (!lpObj.$bgImg && $(v).length) {
							lpObj.$bgImg = $(v);
						}
					});
				}

				// logo
				if (lpObj.$logoImg.length) {
					if (lpObj.logoImgSrc !== lpObj.$logoImg.attr('src')) {
						// サイズ取得するため読み込み完了を待つ
						if (lpObj.$logoImg.prop('complete') || lpObj.$logoImg.prop('readyState') || lpObj.$logoImg.prop('readyState') === 'complete') {
							isChange = true;

							lpObj.logoImgSrc = lpObj.$logoImg.attr('src'); 
							var img = new Image();
							img.src = lpObj.logoImgSrc;

							if (lpObj.$logo.hasClass('ui-resizable')) {
								lpObj.$logo.resizable('destroy');
							}
							lpObj.$logo.find('img').remove();
							lpObj.$logo.html('<img src="' + lpObj.logoImgSrc + '" alt="" />').attr('data-origin-width', img.width).append('<div class="slider_logo_preview-logo-border-e"></div><div class="slider_logo_preview-logo-border-n"></div><div class="slider_logo_preview-logo-border-s"></div><div class="slider_logo_preview-logo-border-w"></div></div>');

							// 初回は既存値
							if (lpObj.logoImgSrcFirst) {
								var logoWidth = parseInt(lpObj.$logoWidth.val(), 10);

								lpObj.logoImgSrcFirst = null;
								if (logoWidth > 0) {
									lpObj.$logo.width(logoWidth);
								} else {
									lpObj.$logo.width(img.width);
								}

							// 画像変更時はロゴ横幅リセット
							} else {
								lpObj.$logoWidth.val(0);
								lpObj.$logo.width(img.width);
							}

							// logo resizable
							lpObj.$logo.resizable({
								aspectRatio: true,
								distance: 5,
								handles: 'all',
								maxWidth: 1180,
								stop: function(event, ui) {
									// lpObj,iは変わっているため使えない
									$($(this).closest('[data-logo-width-input]').attr('data-logo-width-input')).val(parseInt(ui.size.width, 10));
								}
							});
						}
					}
				} else if (lpObj.bgImgSrc) {
					lpObj.logoImgSrc = null; 
					lpObj.$logo.html('');
					isChange = true;
				}

				// bg
				if (lpObj.$bgImg && lpObj.$bgImg.length) {
					if (lpObj.bgImgSrc !== lpObj.$bgImg.attr('src')) {
						lpObj.bgImgSrc = lpObj.$bgImg.attr('src'); 
						isChange = true;
					}
				} else if (lpObj.bgImgSrc) {
					lpObj.bgImgSrc = null; 
					isChange = true;
				}

				// overlay
				lpObj.$Overlay.removeAttr('style');
				if (lpObj.$displayOverlay.is(':checked')) {
					var overlayColor = lpObj.$overlayColor.val() || '';
					var overlayOpacity = parseFloat(lpObj.$overlayOpacity.val() || 0);
					if (overlayColor && overlayOpacity > 0) {
						var rgba = [];
						overlayColor = overlayColor.replace('#', '');
						if (overlayColor.length >= 6) {
							rgba.push(parseInt(overlayColor.substring(0,2), 16));
							rgba.push(parseInt(overlayColor.substring(2,4), 16));
							rgba.push(parseInt(overlayColor.substring(4,6), 16));
							rgba.push(overlayOpacity);
							lpObj.$Overlay.css('background-color', 'rgba(' + rgba.join(',') + ')');
						} else if (overlayColor.length >= 3) {
							rgba.push(parseInt(overlayColor.substring(0,1) + overlayColor.substring(0,1), 16));
							rgba.push(parseInt(overlayColor.substring(1,2) + overlayColor.substring(1,2), 16));
							rgba.push(parseInt(overlayColor.substring(2,3) + overlayColor.substring(2,3), 16));
							rgba.push(overlayOpacity);
							lpObj.$Overlay.css('background-color', 'rgba(' + rgba.join(',') + ')');
						}
					}
				}


				// 画像変更有
				if (isChange) {
					// 動画・Youtubeはダミー画像なので背景セットなし
					if (lpObj.$preview.hasClass('header_video_logo_preview')) {
						if (lpObj.logoImgSrc) {
							lpObj.$preview.closest('.slider_logo_preview-wrapper').show();
						} else {
							lpObj.$preview.closest('.slider_logo_preview-wrapper').hide();
						}
					} else {
						if (lpObj.logoImgSrc && lpObj.bgImgSrc) {
							lpObj.$preview.css('backgroundImage', 'url(' + lpObj.bgImgSrc + ')');
							lpObj.$preview.closest('.slider_logo_preview-wrapper').show();

						} else {
							lpObj.$preview.closest('.slider_logo_preview-wrapper').hide();
						}
					}
				}
			}
		};

		// 画像読み込み完了を待つ必要があるためSetInterval
		setInterval(logoPreviewChange, 500);

		// 画像削除ボタンは即時反映可能
		$('.cfmf-delete-img').on('click.logoPreviewChange', function(){
			setTimeout(logoPreviewChange, 30);
		});
	}

	// ラジオ・チェックボックス汎用表示切替
	$('[data-toggle]').filter(':radio, :checkbox').change(function() {
		if ($(this).attr('data-hide')) {
			$($(this).attr('data-hide')).hide();
		}
		if (this.checked) {
			$($(this).attr('data-toggle')).show();
		} else {
			$($(this).attr('data-toggle')).hide();
		}
	}).filter(':checked').trigger('change');
	$('[data-toggle-reverse]').filter(':radio, :checkbox').change(function() {
		if ($(this).attr('data-hide')) {
			$($(this).attr('data-hide')).hide();
		}
		if (this.checked) {
			$($(this).attr('data-toggle-reverse')).hide();
		} else {
			$($(this).attr('data-toggle-reverse')).show();
		}
	}).filter(':checked').trigger('change');
	$('[data-toggle-show]').filter(':radio, :checkbox').change(function() {
		if (this.checked) {
			$($(this).attr('data-toggle-show')).show();
		}
	}).filter(':checked').trigger('change');

	// チェックボックス 全チェック
	$('.checkboxes .button-checkall').click(function(event) {
		$(this).closest('.checkboxes').find(':checkbox').attr('checked', 'checked');
	});
	$('.checkboxes .button-uncheckall').click(function(event) {
		$(this).closest('.checkboxes').find(':checkbox').removeAttr('checked');
	});

	// custom field simple repeater add row
	$('.cf_simple_repeater_container a.button-add-row').click(function(){
		var clone = $(this).attr('data-clone');
		var $parent = $(this).closest('.cf_simple_repeater_container');
		if (clone && $parent.length) {
			$parent.find('table.cf_simple_repeater tbody').append(clone);
		}
		return false;
	});

	// custom field simple repeater delete row
	$('table.cf_simple_repeater').on('click', '.button-delete-row', function(){
		var del = true;
		var confirm_message = $(this).closest('table.cf_simple_repeater').attr('data-delete-confirm');
		if (confirm_message) {
			del = confirm(confirm_message);
		}
		if (del) {
			$(this).closest('tr').remove();
		}
		return false;
	});

	// custom field simple repeater sortable
	$('table.cf_simple_repeater-sortable tbody').sortable({
		helper: 'clone',
		forceHelperSize: true,
		forcePlaceholderSize: true,
		distance: 10,
		start: function(event, ui) {
			$(ui.placeholder).height($(ui.helper).height());
		}
	});

	// works repeater_gallery media_type
	$('.repeater_gallery').on('change', '.repeater_gallery-media_type-radios :radio', function(event) {
		if (this.checked) {
			var $cl = $(this).closest('.repeater-item');
			$cl.find('[class*="repeater_gallery-media_type--"]').hide();
			$cl.find('.repeater_gallery-media_type--' + this.value).show();
		}
	});
	$('.repeater_gallery-media_type-radios :radio:checked').trigger('change');

});
