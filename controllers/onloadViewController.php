<?php

// Display navbar
$navBarStatus = array();
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] = true) {
    $navBarStatus["login"] = '<span class="pr-3 text-white">' . $_SESSION['username'] . '</span><button type="submit" name="signOut" class="btn lightOrange signOutBtn mr-3">Sign Out</button>';
} else {
    $navBarStatus["login"] = '<div class="form-group"><input type="text" placeholder="Username" class="form-control" name="username"></div><div class="form-group"><input type="password" placeholder="Password" class="form-control mx-1" name="password"></div><button type="submit" class="btn lightOrange signInBtn mr-3" name="signIn">Sign In</button><button type="submit" class="btn lightOrange signUpBtn" name="signUp">Sign Up</button>';
}
print templateGen("templates/navBarTemplate.php", $navBarStatus);

// If sign up requested, display sign up page
if (isset($_POST['signUp'])) {
    print templateGen("templates/signUpTemplate.php", $signUpData);
} else {
    // Otherwise, load gamesController
    include_once("controllers/gamesController.php");
}

// If cookies not consented to, display cookie consent div
if (!isset($_COOKIE['cookiesAccepted'])) {
    $cookieConsentData = array();
    print templateGen("templates/cookieConsentTemplate.php", $cookieConsentData);
}
