$(function() {
	'use strict'
	const ps = new PerfectScrollbar('#ChatList', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	const ps2 = new PerfectScrollbar('#ChatList2', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	const ps1 = new PerfectScrollbar('#ChatBody', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});
	
	$('[data-toggle="tooltip"]').tooltip();
	
});