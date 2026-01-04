<?php

// IMPORTANT: Session configuration MUST come before anything else
// Set session configuration BEFORE session_start()
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', 3600); // 1 hour session lifetime
    session_set_cookie_params([
        'lifetime' => 3600, // 1 hour
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

define('ROOT', dirname(__DIR__) . "/");
define('HOME', './');
define('CONTROLLER', HOME . 'controller/');
define('CSS', HOME . 'public/assets/css/');
define('VENDOR', HOME . 'public/assets/vendor/');
define('JS', HOME . 'public/assets/js/');
define('IMG', HOME . 'public/assets/img/');



$modules = [CONTROLLER];
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));
//spl_autoload_register('spl_autoload', false);
function autoloader($class_name)
{
    require_once ROOT . 'controller/' . $class_name . '.php';
    //require_once ROOT.'models/'.$class_name.'.php';
}
spl_autoload_register('autoloader');


//useful functions
function readMore($content, $limit)
{
    $content = substr($content, 0, $limit);
    $content = substr($content, 0, strrpos($content, ' '));
    return $content . "...";
}

function getRand($len)
{
    $characters = "452&678a9efghi2&ijklm5678o0123&456789pqrstUVwxyzabcD01JKL";
    $string = "";
    for ($i = 0; $i < $len; $i++)
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    return $string;
}
function dateS($date)
{
    $convert = date("jS F Y", strtotime($date));
    return $convert;
}
function dateStr($date)
{
    $convert = date("jS F Y, h:i:a", strtotime($date));
    return $convert;
}
function create_square_image($original_file, $destination_file = NULL, $square_size = 100)
{

    if (isset($destination_file) and $destination_file != NULL) {
        if (!is_writable($destination_file)) {
            //echo '<p style="color:#FF0000">Oops, the destination path is not writable. Make that file or its parent folder wirtable.</p>';
        }
    }

    // get width and height of original image
    $imagedata = getimagesize($original_file);
    $original_width = $imagedata[0];
    $original_height = $imagedata[1];

    if ($original_width > $original_height) {
        $new_height = $square_size;
        $new_width = $new_height * ($original_width / $original_height);
    }
    if ($original_height > $original_width) {
        $new_width = $square_size;
        $new_height = $new_width * ($original_height / $original_width);
    }
    if ($original_height == $original_width) {
        $new_width = $square_size;
        $new_height = $square_size;
    }

    $new_width = round($new_width);
    $new_height = round($new_height);

    // load the image
    if (substr_count(strtolower($original_file), ".jpg") or substr_count(strtolower($original_file), ".jpeg")) {
        $original_image = imagecreatefromjpeg($original_file);
    }
    if (substr_count(strtolower($original_file), ".gif")) {
        $original_image = imagecreatefromgif($original_file);
    }
    if (substr_count(strtolower($original_file), ".png")) {
        $original_image = imagecreatefrompng($original_file);
    }

    $smaller_image = imagecreatetruecolor($new_width, $new_height);
    $square_image = imagecreatetruecolor($square_size, $square_size);

    imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

    if ($new_width > $new_height) {
        $difference = $new_width - $new_height;
        $half_difference = round($difference / 2);
        imagecopyresampled($square_image, $smaller_image, 0 - $half_difference + 1, 0, 0, 0, $square_size + $difference, $square_size, $new_width, $new_height);
    }
    if ($new_height > $new_width) {
        $difference = $new_height - $new_width;
        $half_difference = round($difference / 2);
        imagecopyresampled($square_image, $smaller_image, 0, 0 - $half_difference + 1, 0, 0, $square_size, $square_size + $difference, $new_width, $new_height);
    }
    if ($new_height == $new_width) {
        imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
    }


    // if no destination file was given then display a png
    if (!$destination_file) {
        imagepng($square_image, NULL, 9);
    }

    // save the smaller image FILE if destination file given
    if (substr_count(strtolower($destination_file), ".jpg")) {
        imagejpeg($square_image, $destination_file, 100);
    }
    if (substr_count(strtolower($destination_file), ".gif")) {
        imagegif($square_image, $destination_file);
    }
    if (substr_count(strtolower($destination_file), ".png")) {
        imagepng($square_image, $destination_file, 9);
    }

    imagedestroy($original_image);
    imagedestroy($smaller_image);
    imagedestroy($square_image);
}

$db = new Database();
$meta = new Meta();

// Check session timeout (1 hour of inactivity) - only if user is logged in
if (isset($_SESSION['userId'])) {
    if (isset($_SESSION['last_activity'])) {
        if (time() - $_SESSION['last_activity'] > 3600) { // 1 hour = 3600 seconds
            session_unset();
            session_destroy();
            // Redirect to login if on protected page
            if (basename($_SERVER['PHP_SELF']) !== 'index.php' && strpos($_SERVER['PHP_SELF'], 'employee') === false) {
                header('Location: ./signin.php');
                exit();
            }
        }
    }
    // Update last activity time for logged-in users
    $_SESSION['last_activity'] = time();
}

///functions
function addComment($author, $email, $comment, $id, $db)
{
    $insert = $db->query("INSERT INTO comment(news_id,author,email,description) VALUES('$id','$author','$email','$comment')");
    echo 1;
}
