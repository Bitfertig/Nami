$(function(){

	$('#demologinlink').on('click', function(e){
		e.preventDefault();

		$('#demologinform').trigger('submit');
	});


});

