function onResize(){

	if($(document).width()>880)
	{
		$('#nav-icon').hide();
		$('nav ul').removeClass('sideNav');
	}
	else
	{
		$('nav ul').addClass('sideNav');
		$('#nav-icon').fadeIn();
	}

}

function notify(){

	$('.notif').animate({
		'right':'0px'
	},500);

	setTimeout(function(){
		$('.notif').animate({
			'right':'-500px'
		},500);
	}, 5000);

}

$(document).ready(function(){

	onResize();

	$('#nav-icon').click(function(){

		$(this).toggleClass('open');

		$('ul.sideNav').toggleClass('show');

		$('.smooth').toggleClass('show');

		$('ul.sideNav.show').animate({
			'height':'353px'
		},300);

		$('ul.sideNav:not(.show)').animate({
			'height':'0'
		},300);

	});

	$('#left').children().mousedown(function(){

		$('#right').children('.preview').remove();

	});

	$('#right,#left').bind('DOMNodeInserted DOMNodeRemoved',function(){

		var points = 0;

		$('#right').children().each(function(){
			points += parseInt($(this).attr('data-points'));
		});

		if(points > 10)
		{
			$('span.current').addClass('max');
		}
		else
		{
			$('span.current.max').removeClass('max');
		}

		$('span.current').text(points);

	});

	$('input[name="reinit"]').click(function(e){
		e.preventDefault();
		location.reload();
	});

	$('input[name="choixcompo"]').click(function(e){

		e.preventDefault();

		compo = new Array();

		$('#right').children().each(function(){
			compo.push($(this).attr('id'));
		});

		var input = $("<input>")
			.attr("type", "hidden")
			.attr("name", "compo").val(JSON.stringify(compo));

		$('form#inscription').append($(input));

		$('form#inscription').submit();

	});

});

$(window).resize(function(){
	onResize();
});