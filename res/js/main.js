$(function(){

	// Demolink
	$('#demologinlink').on('click', function(e){
		e.preventDefault();

		$('#demologinform').trigger('submit');
	});


	// Resize
	/*var $tdellipsis = $('.table-styled .td-ellipsis');
	$tdellipsis.each(function(k,v){
		$(this)
	});
	$(window).on('load resize', function(e){

		// Tabelle
		$tdellipsis.each(function(k,v){
			var w = $(this).parent('td').width();
			//$(this).css('width', w);
			console.log(w);
		});

	});*/



});

