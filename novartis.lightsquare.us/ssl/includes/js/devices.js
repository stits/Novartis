$(document).ready(function() {
        $(".toggleHidden").hover(
                function() {
                        $(this).find("a.hidden-options").css('display', 'inline');
                },
                function() {
                        $(this).find("a.hidden-options").css('display', 'none');
                }
        );

	$(".delete_device").click(function(event) {
                var answer = confirm("Are you sure you wish to delete this device?");

                return(answer);
        });

	if($("#inputSuccess").val() == "Y") {
		$.gritter.add({
			title: 'Update Successful',
			text:  'Your device has been updated successfully',
			image: 'images/check.png',
			sticky: false,
			time:  5000
		});
	}
});
