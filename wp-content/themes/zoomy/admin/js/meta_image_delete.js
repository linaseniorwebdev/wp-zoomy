jQuery(function($){

	// カスタムフィールド 画像削除
	$('.meta_image_field .delete-button').on('click', function() {
		if ($(this).attr('data-meta-key')) {
			var $cl = $(this).closest('.meta_image_field');
			$cl.append('<input type="hidden" name="delete-meta-image-'+$(this).attr('data-meta-key')+'" value="1">');
			$(this).addClass('hidden');
			$cl.find('.preview_field').remove();
		}
	});

	// ユーザープロフィール 画像削除
	$('.user_profile_image_field .delete-button').on('click', function() {
		if ($(this).attr('data-meta-key')) {
			var $cl = $(this).closest('.user_profile_image_field');
			$cl.append('<input type="hidden" name="delete-meta-image-'+$(this).attr('data-meta-key')+'" value="1">');
			$(this).addClass('hidden');
			$cl.find('.preview_field').remove();
		}
	});

});
