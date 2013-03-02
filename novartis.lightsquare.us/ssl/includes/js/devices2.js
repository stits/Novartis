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

	$("#updateSubmit").click(function(event) {
		var ipsub = $("#deviceIP").val().split(".");
		var invalid = 0;

		for(var i=0;i<ipsub.length;i++) {
			var sub = parseInt(ipsub[i]);

			if((isNaN(sub)) || (sub < 0) || (sub > 255)) {
				invalid = 1;
			}
		}

		if(invalid) {
			$.gritter.add({
				title:  'Invalid IP',
				text:   'An invalid IP address has been specified',
				image:  'images/error.png',
				sticky: false,
				time:   5000
			});

			$("#deviceIP").addClass("error_input");

			event.preventDefault();
		}

		event.preventDefault();
	});

	alert("Hello");

});
