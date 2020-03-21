<?php
require_once "../config.php";

// The Tsugi PHP API Documentation is available at:
// http://do1.dr-chuck.com/tsugi/phpdoc/

use \Tsugi\Util\Net;
use \Tsugi\Util\U;
use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;
use \Tsugi\UI\SettingsForm;

$LTI = LTIX::requireData();

// Handle the incoming post first
if ( $LTI->link && $LTI->link->id && SettingsForm::handleSettingsPost() ) {
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
    if ( $grade && $RESULT && $RESULT->id && $RESULT->grade < 1.0 ) {
        $RESULT->gradeSend(1.0, false);
    }
    header("Location: ".U::safe_href($url));
    return;
}

$menu = false;
if ( $LTI->link && $LTI->user && $LTI->user->instructor ) {
    $menu = new \Tsugi\UI\MenuSet();
    if ( $CFG->launchactivity ) {
        $menu->addRight(__('Launches'), 'analytics');
    }
    $menu->addRight(__('Settings'), '#', /* push */ false, SettingsForm::attr());
}
// Render view
$OUTPUT->header();
$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);
?>
<?php

if ( $LTI->link && $LTI->user && $LTI->user->instructor ) {
    SettingsForm::start();
    SettingsForm::text('url','Please enter the URL.');
    SettingsForm::checkbox('grade','Give the student a grade when they launch this url.');
    echo("<p>");
    echo(__("If you are entering a YouTube URL, make sure that is an 'embeddable' URL."));
    echo("</p>");
    SettingsForm::end();
    
    $OUTPUT->flashMessages();
}

if ( ! $url ) {
    echo("<p>iFrame url has not yet been configured</p>\n");
} else {
    echo("</div>\n");
    echo('<iframe src="'.U::safe_href($url));
    echo('" style="width:100%; height:600px;" frameborder="0" allowfullscreen></iframe>'."\n");

}
$OUTPUT->footerStart();
$OUTPUT->footerEnd();
