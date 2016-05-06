// JavaScript Document
$(function(){
	$('.country lable').click( function () { 
		$('.country .ok').removeClass("glyphicon glyphicon-ok");
		$(this).parent().find('span').addClass("glyphicon glyphicon-ok");
	}); 
});