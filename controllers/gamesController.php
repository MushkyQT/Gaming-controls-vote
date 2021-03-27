<?php

// Check if specific game requested via URL or post
if (isset($_POST['gameRequested']) || isset($_GET['gameRequested'])) {
    // If a game was clicked on, display game's page
    if (isset($_POST['gameRequested'])) {
        $gameRequested = $_POST['gameRequested'];
    } elseif (isset($_GET['gameRequested'])) {
        $gameRequested = $_GET['gameRequested'];
    }
    if ($gameRequestedData = getSpecificGameInfo($gameRequested)) {
        print templateGen("templates/specificGamePageTemplate.php", $gameRequestedData);
    } else {
        print "The requested game was not found.";
    }
} elseif (isset($_POST['searchForGame']) && $_POST['searchForGame'] != "") {
    // Handle navbar game search requests
    print templateGen("templates/gameSearchResultsTemplate.php", displaySearchResults($_POST['searchForGame']));
} else {
    // Otherwise, display popular games home page
    print templateGen("templates/popularGamesTemplate.php", getNinePopularGamesForHomePage());
}
