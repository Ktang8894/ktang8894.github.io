function mainModuleAnim() {
	$("#header").animate({
		fontSize: '30px',
		margin: '5'
	});
	$("h2").animate({
		fontSize: '20px',
		margin: '5'
	});
	$(".mainContainer").animate({			
		padding: '0'
	});
	$("select").animate({
		width: '150px'
	});
}

function charSelected(selectId1, selectId2) {
	if (document.getElementById(selectId1).value == document.getElementById(selectId2).value) {
		document.getElementById(selectId2).selectedIndex = 0;
	}
}

function characterNameAnim() {
	$("#selectedCharName").fadeOut("fast", function() {
			var charName = $("#charFrameData").find(":selected").text();
			$("#selectedCharName").text(charName);
			$("#selectedCharName").fadeIn("slow");
	});
}

function tableLoadAnim() {
	if ($("#charFrameData").find(":selected").text() == "") {
		$("#frameDataContainer").fadeOut("fast");
	}
	else {
		$("#frameDataContainer").fadeOut("fast", function(){
			$("#frameDataContainer").slideDown("slow");
		});
	}
}