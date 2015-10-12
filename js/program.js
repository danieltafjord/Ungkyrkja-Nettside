var main = function(){
	$('.event-panel').click(function(){
		//Highlight the clicked element
		if($(this).hasClass('panel-primary')){
			$('.event-panel').removeClass('panel-primary').addClass('panel-default');
			$('.btn-edit').addClass('hidden');
		}
		else{
			$('.event-panel').removeClass('panel-primary').addClass('panel-default');
			$(this).removeClass('panel-default').addClass('panel-primary');
			$('.btn-edit').addClass('hidden');
			$('.btn-edit', this).removeClass('hidden');
		}
		
		//show the edit button in the clicked element

	});
	$('.btn-edit').click(function(){
		var url = window.location.href;
		var id = $(this).closest('div[id]').attr('id');
		url = 'edit_program.php' + "?id=" + id;		
		//Redirect to the edit-program page
		window.location.assign(url);
	})
}

$(document).ready(main);