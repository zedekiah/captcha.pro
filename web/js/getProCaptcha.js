var state = "A";
var intId = 0;
var nameRefresh = '.refresh';
var hash = $("input[name='captcha_hash']");
var captchaImage = $("img[alt='captcha']");

window.onload = function(){
//$(document).ready(function() {
	sendAnswer("http://procaptcha/captcha/getCaptcha");
}

function sendAnswer(url){
		$.ajax({
	type: "GET",
	url: url,
    success: function(data){
		$("#procaptcha_container").html(data);
	}
});
	$(nameRefresh).live("click",function(){
		clickHandler();
	});
}
function clickHandler(){
	//alert("It's Alive");
	refreshCaptcha("http://procaptcha/captcha/getImage");
}
function refreshCaptcha(url){
$.ajax({
	type: "GET",
	url: url,
    success: function(data){
	//alert(data);
	//alert($("input[name='captcha_hash']").attr("name"));
	$("img[alt='captcha']").attr("src","/images/captcha/"+data+".png");
	$("input[name='captcha_hash']").attr("value",data);
	}
});
}
