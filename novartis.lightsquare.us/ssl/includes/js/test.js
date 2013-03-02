$(document).ready(function() {
	alert("Hello");

	$("a#test").zclip({
		path: "/images/ZeroClipboard.swf",
		copy: $("#test").text()
	});
	alert("Hello");
});
