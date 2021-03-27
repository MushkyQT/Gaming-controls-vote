$(document).ready(function () {
    // On document load, fade in cookieConsent div and close btn functionality
    $(".cookieConsent").fadeIn("slow");
    $(".closeCookies").click(function () {
        $(".cookieConsent").fadeOut("fast");
    });

    // AJAX call to cookieConsent.php if cookies are accepted
    $(".acceptCookies").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "cookieConsent.php",
            type: "post",
            data: {
                cookiesAccepted: "true",
            },
            success: function (response) {
                if (response == "Fail") {
                    alert("Failed to accept cookies. Try again.");
                } else {
                    $(".cookieConsent").fadeOut("fast");
                }
            },
        });
    });

    // Catch vote button clicks
    $(".gameVoteBtn").click(function () {
        alert("Voted for " + $(this).val());
    });
});
