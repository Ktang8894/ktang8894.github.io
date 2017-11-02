$(document).ready(function(){
	var moved = false;
	$("#charFrameData").change(function(){
		if (moved == false) {
			moveToNav();
			moved = true;
		}
		characterNameAnim();
		tableLoadAnim();
		//getNewTable();
	});
});

function moveToNav(){
	$("#headerText").remove();
	$("#selectTeam").remove();
	$("#selectFrameData").remove();
	
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

function getTableString() {
	var str = "https://raw.githubusercontent.com/Ktang8894/ktang8894.github.io/master/MVCI%20Framedata%20Webapp/" + getCharacter() + ".csv";
	if (getCharacter() == "") {
		return "https://raw.githubusercontent.com/Ktang8894/ktang8894.github.io/master/MVCI%20Framedata%20Webapp/TestFrameData.csv"
	}
	return str;
}

//d3 Table
var tabulate = function (data,columns) {
	$("table").remove();
	var table = d3.select('#frameDataContainer').append('table')
		.classed("table table-striped", true);
	
	var thead = table.append('thead')			
	var tbody = table.append('tbody')
	
	thead.append('tr')
		.selectAll('th')
		.data(columns)
		.enter()
		.append('th')
		.text(function (d) { return d })

	var rows = tbody.selectAll('tr')
		.data(data)
		.enter()
		.append('tr')

	var cells = rows.selectAll('td')
		.data(function(row) {
			return columns.map(function (column) {
				return { column: column, value: row[column] }
			})
		})
		.enter()
		.append('td')
		.text(function (d) { return d.value })

	return table;
}

function getNewTable() {
	d3.csv(getTableString(), function (data) {
		var columns = ['Move Name','Input','Damage','Startup', 'Active', 'Recovery', 'Total', 'Block Advantage', 
		'Hit Advantage', 'Counterhit Advantage', 'Punishable by First Character', 'Punishable by Second Character']
		tabulate(data,columns)
	})
}