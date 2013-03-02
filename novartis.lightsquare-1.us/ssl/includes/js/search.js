$(document).ready(function() {
	if($("#citySelect").val() != "") {
		$('#searchRadioCity').prop('checked', true);
	}

	else if($("#stateSelect").val() != "") {
		$('#searchRadioState').prop('checked', true);
	}

	else if($('#locationSelect').val() != "") {
		$('#searchRadioLocation').prop('checked', true);
	}

	else {
		 $('#citySelect')[0].options[1].selected = true;
	}

	$('#searchRadioCity').change(function() {
		$('#stateSelect')[0].options[0].selected = true;
		$('#locationSelect')[0].options[0].selected = true;
		$('#citySelect')[0].options[1].selected = true;
	});

	$('#searchRadioState').change(function() {
		$('#citySelect')[0].options[0].selected = true;
		$('#locationSelect')[0].options[0].selected = true;
		$('#stateSelect')[0].options[1].selected = true;
	});

	$('#searchRadioLocation').change(function() {
		$('#citySelect')[0].options[0].selected = true;
		$('#stateSelect')[0].options[0].selected = true;
		$('#locationSelect')[0].options[1].selected = true;
	});

	$('#citySelect').change(function() {
		$('#searchRadioCity').prop('checked', true);
		$('#stateSelect')[0].options[0].selected = true;
		$('#locationSelect')[0].options[0].selected = true;
	});

	$('#stateSelect').change(function() {
		$('#searchRadioState').prop('checked', true);
		$('#citySelect')[0].options[0].selected = true;
		$('#locationSelect')[0].options[0].selected = true;
	});

	$('#locationSelect').change(function() {
		$('#searchRadioLocation').prop('checked', true);
		$('#citySelect')[0].options[0].selected = true;
		$('#stateSelect')[0].options[0].selected = true;
	});

	$('#computersCheck').click(function() {
		if($('#webcamCheck').is(':checked') == false) {
			$('#webcamCheck').prop('checked', true);
		}
	});

	$('#webcamCheck').click(function() {
		if($('#computersCheck').is(':checked') == false) {
			$('#computersCheck').prop('checked', true);
		}
	});

	$(".smb").zclip({
		path: "/images/ZeroClipboard.swf",
		copy: function() {
			return($(this).children("a").attr("href"));
		},
		afterCopy: function(event) {
			$.gritter.add({
				title: 'Copied to clipboard',
				text:  'Paste into either the address bar or windows explorer',
				image: 'images/clipboard.png',
				sticky: false,
				time:  5000
			});

			event.preventDefault;
		}
	});
});
