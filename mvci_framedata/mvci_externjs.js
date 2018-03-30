$(document).ready(function(){
	$("#mainContainer").fadeIn("slow");
	var moved = false;
	$("#charFrameData").change(function(){
		if (moved == false) {
			moveToNav();
			moved = true;
		}
		characterNameAnim();
		tableLoadAnim();
		getTable();
	});
	$("#charSelect1").change(function() {
		if (getCharacterVal() != "" && moved == true) {
			characterNameAnim();
			tableLoadAnim();
			getTable();
		}
	});
	$("#charSelect2").change(function() {
		if (getCharacterVal() != "" && moved == true) {
			characterNameAnim();
			tableLoadAnim();
			getTable();
		}
	});
});

function getTable(){
	var charSelect1 = $("#charSelect1").find(":selected").val();
	var charSelect2 = $("#charSelect2").find(":selected").val();
	angular.element($("#angularDiv")).scope().update(getCharacterVal(), charSelect1, charSelect2);
}

function listNames(){
	var names = [
		{"name":"Arthur","value":"Arthur"},
		{"name":"Black Panther","value":"BlackPanther"},
		{"name":"Captain America","value":"CaptainAmerica"},
		{"name":"Captain Marvel","value":"CaptainMarvel"},
		{"name":"Chris","value":"Chris"},
		{"name":"Chun-li","value":"ChunLi"},
		{"name":"Dante","value":"Dante"},
		{"name":"Doctor Strange","value":"DoctorStrange"},
		{"name":"Dormammu","value":"Dormammu"},
		{"name":"Firebrand","value":"Firebrand"},
		{"name":"Frank West","value":"FrankWest"},
		{"name":"Gamora","value":"Gamora"},
		{"name":"Ghost Rider","value":"GhostRider"},
		{"name":"Haggar","value":"Haggar"},
		{"name":"Hawkeye","value":"Hawkeye"},
		{"name":"Hulk","value":"Hulk"},
		{"name":"Iron Man","value":"IronMan"},
		{"name":"Jedah","value":"Jedah"},
		{"name":"Monster Hunter","value":"MonsterHunter"},
		{"name":"Morrigan","value":"Morrigan"},
		{"name":"Nemesis","value":"Nemesis"},
		{"name":"Nova","value":"Nova"},
		{"name":"Rocket Raccoon","value":"RocketRaccoon"},
		{"name":"Ryu","value":"Ryu"},
		{"name":"Sigma","value":"Sigma"},
		{"name":"Spencer","value":"Spencer"},
		{"name":"Spiderman","value":"Spiderman"},
		{"name":"Strider Hiryu","value":"StriderHiryu"},
		{"name":"Thanos","value":"Thanos"},
		{"name":"Thor","value":"Thor"},
		{"name":"Ultron","value":"Ultron"},
		{"name":"X","value":"X"},
		{"name":"Zero","value":"Zero"}
	];
	var charSelect1 = $("#charSelect1");
	var charSelect2 = $("#charSelect2");
	var charFrameData = $("#charFrameData");
	$.each(names, function() {
		charSelect1.append($("<option />").val(this.value).text(this.name));
		charSelect2.append($("<option />").val(this.value).text(this.name));
		charFrameData.append($("<option />").val(this.value).text(this.name));
	});
}

function moveToNav(){
	$("#headerText").remove();
	$("#selectTeam").remove();
	$("#selectFrameData").remove();
	$("#mySelect option[value='']").attr('selected', true)
	$("#charFrameData").appendTo("#charFD");
	$("#charSelect1").appendTo("#team");
	$("#charSelect2").appendTo("#team");
	$("select").addClass("navSelect");
	$("#charFrameData").addClass("charFrameData_nav");
	$("#charSelect1").addClass("charSelect1_nav");
	$("#charSelect2").addClass("charSelect2_nav");
	$("#siteNav").fadeOut("fast", function () {
		$("#siteNav").css("visibility", "visible");
	});
	$("#siteNav").fadeIn("fast");
	
	$("#mainContainer").animate({			
		padding: '24'
	});
}

function teamCharSelected(selectId1, selectId2) {
	if (document.getElementById(selectId1).value == document.getElementById(selectId2).value) {
		document.getElementById(selectId2).selectedIndex = 0;
	}
}

function getCharacter() {
	return $("#charFrameData").find(":selected").text();
}

function getCharacterVal() {
	return $("#charFrameData").find(":selected").val();
}

function characterNameAnim() {
	$("#selectedCharName").fadeOut("fast", function() {
			$("#selectedCharName").text(getCharacter());
			$("#selectedCharName").fadeIn("slow");
	});
}

function tableLoadAnim() {
	if (getCharacter() == "") {
		$("#frameDataContainer").fadeOut("fast");
	}
	else {
		$("#frameDataContainer").fadeOut("fast", function(){
			$("#frameDataContainer").fadeIn("slow");
		});
	}
}