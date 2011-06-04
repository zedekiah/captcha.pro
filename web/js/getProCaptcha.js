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
});}
