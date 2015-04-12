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

	$('section.s2 .github a').on('mouseenter', function(e){
		$(this).find('use').attr('xlink:href', 'res/img/spritemap.svg#github')
	})
	.on('mouseleave', function(e){
		$(this).find('use').attr('xlink:href', 'res/img/spritemap.svg#github--link')
	});

	$('section.s2 .mantisbt a').on('mouseenter', function(e){
		$(this).find('use').attr('xlink:href', 'res/img/spritemap.svg#mantisbt')
	})
	.on('mouseleave', function(e){
		$(this).find('use').attr('xlink:href', 'res/img/spritemap.svg#mantisbt--link')
	});

});