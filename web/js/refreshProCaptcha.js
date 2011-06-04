var state = "origin";
var intId = 0;
window.onload = function(){
	$("img").dblclick(function(){
		alert(state);
	});
	$("#refresh_wrap > *").click(function (){
		//alert($("#refreshImgWrap > *").attr("src"));
		if (state == "morewait") {}
		if (state == "origin" || state == "C" || state == "D"){
			state = "moreWait";
			refresh($("#refreshImgWrap > *").attr("src"));
			}
		});
	$("input").keyup(function (e) {
        swapAttr();
    });
    $("#Send").click(function (){
		switch (state){
			case 'origin':
			break;
			case 'morewait':
			break;
			case 'C':
			sendAnswer($("input").val());
			break;
			case 'D':
			break;
			case 'E':
			break;
			case 'J':
			break;
		}
});
}
function refresh(num){
	deleteOldPic(num);
	$("input").val("");
	$("#Send").html("Подождите");
}
function deleteOldPic(num){
	$.ajax({
	type: "POST",
	url: "templates/deletepic.php",
	data: "num="+num,
    success: function(data){
		state = "morewait";
		moreWait();
		//alert(data);
		getHash();
	}
});
}
function getHash(){
	$.ajax({
	type: "POST",
	url: "templates/gethash.php",
    success: function(data){
		//alert(data);
		setNewImg(data);
		$("#refImg").remove();
		$("#refresh_wrap > a").html("Еще");
		//$("input").attr("readonly","false");
		state = "origin";
		$("#Send").html("Для проверки введите значение показанной картинки");
	}
});
}
function setNewImg(newImg){
	$("#refreshImgWrap").html(newImg);
}
function moreWait(){
	$("#refresh_wrap > a").html("подожите");
	$("#refresh_wrap > a").append('<img id = "refImg"src="refresh.gif" alt="обновление"/>');
	//$("input").attr("readonly","true");
}
function origin(){
	$("#refresh_wrap > a").text = "Еще";
}
function swapAttr(){
	if(($("input").val() !="" && state =="origin")){
		state = "C";
		var buf = $("#Send").html();
		$("#Send").html($("#Send").attr("alt"));
		$("#Send").attr('alt',buf);
	}
	if($("input").val() == "" && state =="C")
	{
		state = "origin";
		var buf = $("#Send").html();
		$("#Send").html($("#Send").attr("alt"));
		$("#Send").attr("alt",buf);
	}
	if(state == "morewait"){
		$("input").val("");
	}
		//alert(state);
}
function sendAnswer(answer){
		$.ajax({
	type: "POST",
	url: "templates/check.php",
	data: "num="+answer,
    success: function(data){
		//alert(data);
		switch(data){
			case 'true':
			answerTrue();
			break;
			case 'false':
			answerFalse();
			break;
		}
	}
});}
function answerTrue(){
	state='E';
	$("#refresh_wrap > *").html("Поздравляюем, вы верно распознали картинку");
	$("#Send").html("Поздравляюем, вы верно распознали картинку");
}
function answerFalse(){
	state='J';
	var i = 5;
	$("#refresh_wrap > *").html("Не верно");
	intId = setInterval(function(){
		$("#Send").html("Отдохните "+i+" сек");
		i = i - 1;
		if (i == 0){
				clearInterval(intId);
				state = 'C';
				$("#refresh_wrap > *").click();
				$("#Send").attr('alt',"Отправить");
		}
	},1000);
}
