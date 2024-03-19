/** @format */

function toggleVisibility(element) {
	// Hide all elements first
	document.getElementById('user-data').style.display = 'none';
	document.getElementById('adminlogs').style.display = 'none';
	document.getElementById('banlogs').style.display = 'none';
	document.getElementById('ticketlogs').style.display = 'none';

	// Show the selected element
	document.getElementById(element).style.display = 'block';
}

document.onload = toggleVisibility('user-data');
