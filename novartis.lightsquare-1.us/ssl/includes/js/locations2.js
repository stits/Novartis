$(document).ready(function() {
        $("#locationsubmit").click(function(event) {
                if($("#name").val() == "" ||
                   $("#city").val() == "" ||
                   $("#stateSelect").val() == "") {
                        $.gritter.add({
                                title: "Error",
                                text:  "Missing required information",
                                image: "images/error.png",
                                sticky: false,
                                time: 5000
                        });

                        event.preventDefault();
                }
        });
});
