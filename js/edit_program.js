var main = function(){
	$('.button-save').click(function(){
		var title = $('input[id=title]').first().attr('value');
		$('.title-input').attr("value", title);
		$('.main-form').submit();
	});
}

$(document).ready(main);