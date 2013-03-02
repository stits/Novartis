$(document).ready(function() {
	$(".toggleHidden").hover(
		function() {
			$(this).find("a.hidden-options").css('display', 'inline');
		},
		function() {
			$(this).find("a.hidden-options").css('display', 'none');
		}
	);

	$(".delete_location").click(function(event) {
		var answer = confirm("Are you sure you wish to delete this location?\n" +
				"CAUTION!!! All devices associated to this location will be deleted as well.");

		return(answer);
	});

	if($("#gritter")) {
		$.gritter.add({
			title: "Success!",
			text:  $("#gritter").text(),
			image: 'images/check.png',
			sticky: false,
			time: 5000
		});
	}
});
