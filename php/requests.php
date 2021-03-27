<?php

$apiKey = "RAWG.IO_API_KEY";

function logMeIn($username, $password)
{
    global $connection;
    $cleanUsername = mysqli_real_escape_string($connection, $username);
    $cleanPassword = mysqli_real_escape_string($connection, $password);

    $request = "SELECT `password`, `verified` FROM `users` WHERE `username` = '" . $cleanUsername . "'";
    $result = mysqli_query($connection, $request);
    if (!mysqli_num_rows($result)) {
        return "No account found for " . $cleanUsername . ". Try again.";
    } else {
        $row = mysqli_fetch_array($result);
        if ($row['password'] == (md5($cleanPassword) . md5("kbvm_salt"))) {
            if (!$row['verified']) {
                return "Your e-mail address still needs to be validated, please check your inbox and spam folder.";
            } else {
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
            }
        } else {
            return "Incorrect password for " . $cleanUsername . ". Try again.";
        }
    }
}

function signMeUp($username, $password, $passwordConfirm, $email)
{
    global $connection;
    $cleanUsername = mysqli_real_escape_string($connection, $username);
    $cleanPassword = mysqli_real_escape_string($connection, $password);
    $cleanPasswordConfirm = mysqli_real_escape_string($connection, $passwordConfirm);
    $cleanEmail = mysqli_real_escape_string($connection, $email);

    $request = "SELECT `username`, `email` FROM `users` WHERE `username` = '" . $cleanUsername . "' OR `email` = '" . $cleanEmail . "'";
    $result = mysqli_query($connection, $request);
    if (mysqli_num_rows($result)) {
        // User or email already exists
        $row = mysqli_fetch_array($result);
        if ($row['username'] == $cleanUsername) {
            return "Username '" . $cleanUsername . "' already registered, please try something else.";
        } elseif ($row['email'] == $cleanEmail) {
            return "E-mail address " . $cleanEmail . " already registered, please try something else.";
        }
    } else {
        // Register account into DB
        $emailHash = md5(rand(0, 1000));
        $saltedPass = md5($cleanPassword) . md5("kbvm_salt");
        $request = "INSERT INTO `users` (`username`, `password`, `email`, `email_hash`) VALUES ('" . $cleanUsername . "', '" . $saltedPass . "', '" . $cleanEmail . "', '" . $emailHash . "')";
        if ($result = mysqli_query($connection, $request)) {
            unset($_POST['signUp']);
            // Send verification email
            $emailMetaData = array(
                "subject" => "Keyboard vs. Controller Verification Link",
                "message" => "Thank you for signing up to Keyboard vs. Controller. Your account must be verified before you can log-in. To do so, simply click on the following link: https://www.cmelki.cf/kbvm/?verify=&email=" . $email . "&hash=" . $emailHash,
                "fromName" => "KBvM",
                "error" => "<br>Uh oh, verification email failed to send. Please create a new account or contact us.",
                "success" => "<br>Verification link sent to " . $email,
            );
            print sendMail($email, $emailMetaData);
            return "Successfully signed up user " . $username . " with e-mail " . $email . "! You must verify your e-mail before signing in.";
        } else {
            return "Failed to create account, please try again.";
        }
    }
}

function verifyEmail($email, $hash)
{
    global $connection;
    $cleanEmail = mysqli_real_escape_string($connection, $email);
    $request = "SELECT `verified`, `email_hash`, `username` FROM `users` WHERE `email` = '" . $cleanEmail . "'";
    $result = mysqli_query($connection, $request);
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_array($result);
        if ($hash == $row['email_hash'] && $row['verified'] == false) {
            $verifiedUser = $row['username'];
            $request = "UPDATE `users` SET `verified` = '1' WHERE `users`.`email` = '" . $cleanEmail . "'";
            if ($result = mysqli_query($connection, $request)) {
                // Send email to notify validation
                $emailMetaData = array(
                    "subject" => "Keyboard vs. Controller Account Verified!",
                    "message" => "Hey " . $verifiedUser . ", your Karot account is now verified! You can log in at https://www.cmelki.cf/kbvm/",
                    "fromName" => "KBvM",
                    "error" => "<br>Uh oh, failed to send confirmation email. Your account should still be verified.",
                    "success" => "<br>Verified! Confirmation sent to " . $email,
                );
                print sendMail($email, $emailMetaData);
                return $verifiedUser . ", your email is now verified! Please log-in.";
            } else {
                return "Verification failed. Please try again.";
            }
        } else {
            return "Invalid hash or account already verified. Try again or log-in.";
        }
    } else {
        return "No account found for this email address. Please try again.";
    }
}

function getNinePopularGamesForHomePage()
{
    global $apiKey;
    $nineMostPopularGamesThisMonth = json_decode(file_get_contents("https://api.rawg.io/api/games?dates=2020-09-01%2C2020-10-24&page_size=9&platforms=4&ordering=-added&key=" . $apiKey), true);
    $gamesReadyForCardArray = array();
    foreach ($nineMostPopularGamesThisMonth["results"] as $game) {
        $gamesReadyForCardArray[] = $game;
    }
    return $gamesReadyForCardArray;
}

function addNewGameToDB($gameToAdd)
{
    // STILL NEED TO ADD LOOP OR SOMETHING FOR PLATFORMS
    // AND non bg-img
    global $connection;
    extract($gameToAdd);
    $request = "INSERT INTO `games` (`name`, `game_api_id`, `description`, `bg_img`, `release_date`, `platforms`, `img`) VALUES ('" . $name . "', '" . $id . "', '" . $description . "', '" . $background_image . "', '" . $released . "', '" . "pc" . "', '" . "other_img" . "')";
    if (mysqli_query($connection, $request)) {
        return true;
    } else {
        return false;
    }
}

function getSpecificGameInfo($game_api_id_or_slug)
{
    global $apiKey;
    if (($gameRequestURL = @file_get_contents("https://api.rawg.io/api/games/" . $game_api_id_or_slug . "?key=" . $apiKey)) === false) {
        // GAME NOT FOUND ERROR HANDLING
        return false;
    } else {
        // GAME FOUND 
        global $connection;
        $gameFoundData = json_decode($gameRequestURL, true);
        // Check if game is already present in `games` table
        $request = "SELECT `id` FROM `games` WHERE `game_api_id` = " . $gameFoundData["id"];
        $result = mysqli_query($connection, $request);
        if (mysqli_num_rows($result)) {
            // If game exists in DB, return game data to controller
            return $gameFoundData;
        } else {
            // If game not found in DB, create an entry for it, then return game data to controller
            if (addNewGameToDB($gameFoundData) === true) {
                return $gameFoundData;
            }
        }
    }
}

function displaySearchResults($gameSearchInput)
{
    global $apiKey;
    $gameSearchInputNoSpaces = str_replace(" ", "%20", $gameSearchInput);
    if (($gameSearchURL = @file_get_contents("https://api.rawg.io/api/games?search=" . $gameSearchInputNoSpaces . "&platforms=4&key=" . $apiKey)) === false) {
        // Search query failed
        return "fail";
    } else {
        // Search query results handling
        if ($gameSearchData = json_decode($gameSearchURL, true)) {
            $gameSearchResults = array();
            foreach ($gameSearchData["results"] as $gameSearchResult) {
                // Only list games that were 'added' at least 15 times to tidy results
                if ($gameSearchResult["added"] > 15) {
                    $gameSearchResults[] = $gameSearchResult;
                }
            }
            return $gameSearchResults;
        } else {
            return "fail";
        }
    }
}
