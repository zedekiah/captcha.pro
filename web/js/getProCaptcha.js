window.onload = function(){
	sendAnswer("procaptcha/captcha/getCaptcha");
}
function sendAnswer(url){
		$.ajax({
	type: "POST",
	url: url,
    success: function(data){
		$("#procaptcha_container").html(data);
	}
});}
