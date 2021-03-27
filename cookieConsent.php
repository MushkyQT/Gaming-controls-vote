<?php

if (isset($_POST['cookiesAccepted']) && $_POST['cookiesAccepted'] == "true") {
    setcookie('cookiesAccepted', true, time() + 86400 * 30);
} else {
    echo "Fail";
}
