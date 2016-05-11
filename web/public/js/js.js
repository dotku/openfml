// JavaScript Document
$(function(){
	$('.country lable').click( function () { 
		$('.country .ok').removeClass("glyphicon glyphicon-ok");
		$(this).parent().find('span').addClass("glyphicon glyphicon-ok");
	}); 
	$('.navbar-right li:first-of-type').click(function(){
		$('.navbar-right').hide();
		$('.keep-center').hide(1000);
		$('.curtain').show();
		$('.search-wrap').show();
		$('.glyphicon-remove').show();
		$('.search-wrap aside').show(1000);
	});
	$('.glyphicon-remove').click(function(){
		$('.navbar-right').show();
		$('.keep-center').show(1000);
		$('.search-wrap').hide();
		$('.glyphicon-remove').hide();
		$('.search-wrap aside').hide(1000);
	});
});