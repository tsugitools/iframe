<?php
require_once "../config.php";

// The Tsugi PHP API Documentation is available at:
// http://do1.dr-chuck.com/tsugi/phpdoc/

use \Tsugi\Util\Net;
use \Tsugi\Util\U;
use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;
use \Tsugi\UI\SettingsForm;

// Allow this to just be launched as a naked URL w/o LTI
$LTI = LTIX::session_start();

// Handle the incoming post first
if ( $LINK->id && SettingsForm::handleSettingsPost() ) {
    header('Location: '.addSession('index.php') ) ;
    return;
}

// Get the url
$url = Settings::linkGet('url', false);
if ( ! $url ) $url = isset($_GET['url']) ? $_GET['url'] : false;
if ( ! $url ) $url = isset($_SESSION['url']) ? $_SESSION['url'] : false;
if ( $url ) $_SESSION['url'] = $url;
$grade = Settings::linkGet('grade', false);

// Students are just redirected
if ( ! $USER->instructor && $url ) {
    if ( $grade && $RESULT->id && $RESULT->grade < 1.0 ) {
        $RESULT->gradeSend(1.0, false);
    }
    header("Location: ".U::safe_href($url));
    return;
}

// Render view
$OUTPUT->header();
$OUTPUT->bodyStart();
$OUTPUT->topNav();
?>
<div class="container">
<?php

if ( $LTI->user && $LTI->user->instructor ) {
    echo "<p style='text-align:right;'>";
    if ( $CFG->launchactivity ) {
        echo('<a href="analytics" class="btn btn-default">Launches</a> ');
    }
    SettingsForm::button(false);
    echo("</p>");
    SettingsForm::start();
    SettingsForm::text('url','Please enter the URL.');
    SettingsForm::checkbox('grade','Give the student a grade when they launches this url.');
    SettingsForm::end();
    
    $OUTPUT->flashMessages();
}

if ( ! $url ) {
    echo("<p>Video has not yet been configured</p>\n");
    echo("</div>\n");
} else {
    echo("</div>\n");
    echo('<iframe src="'.U::safe_href($url));
    echo('" style="width:100%; height:600px;" frameborder="0" allowfullscreen></iframe>'."\n");

}
$OUTPUT->footerStart();
$OUTPUT->footerEnd();
