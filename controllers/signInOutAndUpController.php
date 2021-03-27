<?php

// Execute sign out
if (isset($_POST['signOut'])) {
    session_unset();
}

// Execute sign in
if (isset($_POST['signIn'])) {
    if (isset($_POST['username']) && $_POST['username'] != "" && isset($_POST['password']) && $_POST['password'] != "") {
        print logMeIn($_POST['username'], $_POST['password']);
    } else {
        print "One or more fields missing from login, please try again.";
    }
}

// Execute sign up
$signUpData = array();
if (isset($_POST['signMeUp'])) {
    $_POST['signUp'] = "";

    if (isset($_POST['signUpUsername']) && $_POST['signUpUsername'] != "" && isset($_POST['signUpEmail']) && $_POST['signUpEmail'] != "" && isset($_POST['signUpPassword']) && $_POST['signUpPassword'] != "" && isset($_POST['signUpPasswordConfirm']) && $_POST['signUpPasswordConfirm'] != "") {
        if ($_POST['signUpPassword'] == $_POST['signUpPasswordConfirm']) {
            print signMeUp($_POST['signUpUsername'], $_POST['signUpPassword'], $_POST['signUpPasswordConfirm'], $_POST['signUpEmail']);
        } else {
            print "Passwords do not match, please try again carefully.";
        }
    } else {
        print "One or more fields missing, please try again.";
    }
}

// Verify email
if (isset($_GET['email'])) {
    if ($_GET['email'] != "" && isset($_GET['hash']) && $_GET['hash'] != "") {
        $verifyEmail = $_GET['email'];
        $verifyHash = $_GET['hash'];
        print verifyEmail($verifyEmail, $verifyHash);
        //CLEAR URL
        echo '<script type="text/javascript">window.history.pushState({}, document.title, "/" + "Keyboard_vs_Controller/");</script>';
    } else {
        return "Invalid verification link, please try again.";
    }
}
