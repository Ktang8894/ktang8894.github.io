$(document).ready(function(){
		$("#charFrameData").change(function(){
			mainModuleAnim();
			characterNameAnim();
			tableLoadAnim();
		});
});

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

//d3 Script
var tabulate = function (data,columns) {
  var table = d3.select('#frameDataContainer').append('table')
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

d3.csv("TestFrameData.csv",function (data) {
	var columns = ['Move Name','Input','Damage','Startup', 'Active', 'Recovery', 'Block Advantage', 
	'Hit Advantage', 'Counterhit Advantage', 'Punishable by First Character', 'Punishable by Second Character']
  tabulate(data,columns)
})