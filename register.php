<?php

$REGISTER_LTI2 = array(
"name" => "Iframe",
"FontAwesome" => "fa-window-maximize",
"short_name" => "Iframe",
"description" => "This tool allows you to choose a link to a web page and allows
you to view analytics about the use of the web page from your course.
You can also trigger a grade to be sent to the learning system when the tool is
launched.",
    "messages" => array("launch", "launch_grade"),
 "privacy_level" => "anonymous",  // anonymous, name_only, public
    "license" => "Apache",
    "languages" => array(
        "English"
    ),
    "analytics" => array(
        "internal"
    ),
    "source_url" => "https://github.com/tsugitools/iframe",
    // For now Tsugi tools delegate this to /lti/store
    "placements" => array(
        /*
        "course_navigation", "homework_submission",
        "course_home_submission", "editor_button",
        "link_selection", "migration_selection", "resource_selection",
        "tool_configuration", "user_navigation"
        */
    ),
    "screen_shots" => array(
        "store/screen-01.png",
        "store/screen-02.png",
        "store/screen-03.png",
        "store/screen-analytics.png"
    )

);
