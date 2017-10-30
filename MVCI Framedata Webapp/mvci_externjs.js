$(document).ready(function(){
	$("#charFrameData").change(function(){
		mainModuleAnim();
		characterNameAnim();
		tableLoadAnim();
		getNewTable();
	});
	
	
});

/*This needs to be heavily revised, and have the left edge of the 
window used as a reference point instead of hardcoded units */
function transformToBanner() {
	$("select").css("z-index", "1");
	$("#mainContainer").removeClass("container").addClass("containerTop");
	
	$("#headerText").animate({
		right: '820px'
	});
	$("#selectTeam").animate({
		top: '-30px',
		right: '510px'
	});
	$("#charSelect1").animate({
		top: '-58px',
		right: '217px'
	});
	$("#charSelect2").animate({
		top: '-58px',
		right: '217px'
	});
	$("#selectFrameData").animate({
		top: '-85px',
		left: '180px'
	});
	$("#charFrameData").animate({
		top: '-113px',
		left: '450px'
	});
}

$(window).scroll(function() {
	if ($(window).scrollTop() != 0) {	
		transformToBanner();
	}
});

function mainModuleAnim() {
	$("#headerText").animate({
		fontSize: '30px',
		margin: '5'
	});
	$("h2").animate({
		fontSize: '20px',
		margin: '5'
	});
	$("#mainContainer").animate({			
		padding: '0'
	});
	$("select").animate({
		width: '150px'
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
		var columns = ['Move Name','Input','Damage','Startup', 'Active', 'Recovery', 'Block Advantage', 
		'Hit Advantage', 'Counterhit Advantage', 'Punishable by First Character', 'Punishable by Second Character']
		tabulate(data,columns)
	})
}