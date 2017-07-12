(function($) {
	$('button[data-target="_blank"]').click(function(){//dung class
		var url = $(this).attr('data-href');
		var win = window.open(url, $(this).attr('data-target'));
  		win.focus();
	});
	$( ".your-birthday" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '1945:'+(new Date).getFullYear()
    });
   var rel = $('#lead-type').find('option:selected').attr('rel');
	if(rel != undefined){
		$('#redirect_nonce').val(rel);
	}
	$('#lead-type').on('change', function(){
		rel = $('option:selected', this).attr('rel');
		$('#redirect_nonce').val(rel);
	});
})(jQuery);