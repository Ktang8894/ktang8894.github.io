function charSelected(selectId1, selectId2) {
	if (document.getElementById(selectId1).value == document.getElementById(selectId2).value) {
		document.getElementById(selectId2).selectedIndex = 0;
	}
}
