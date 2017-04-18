(($) ->
	$.fn.bs_right_now = () ->
		
		data = { action: 'bs_right_now' }
		
		$this = $ this

		$.post ajaxurl, data, (r) ->
			$this.find('#bs-right-now-loading').slideUp 400, ->
				$this.find('#bs-right-now-container').html(r).slideDown(500)

)(jQuery)
