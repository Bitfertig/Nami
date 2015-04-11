$(function(){
	$('.open-lightbox').on('click', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$('#lb').addClass('on');
		$('#'+id).addClass('on');
	});
	$('#lb').on('click', function(e){
		e.preventDefault();
		$('#lb').removeClass('on');
		$('.lb-content').removeClass('on');
	});
});