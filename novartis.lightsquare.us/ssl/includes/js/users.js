$(document).ready(function() {
	$(".toggleHidden").hover(
		function() {
			$(this).find("a.hidden-options").css('display', 'inline');
		},
		function() {
			$(this).find("a.hidden-options").css('display', 'none');
		}
	);

	$("#usersubmit").click(function(event) {
		if($("#password").val() != $("#password_confirmed").val()) {
			event.preventDefault();
			alert("Passwords do not match");
			$("#password").select();
		}
	});

	$(".delete_user").click(function(event) {
		var answer = confirm("Are you sure you wish to delete this user?");

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
