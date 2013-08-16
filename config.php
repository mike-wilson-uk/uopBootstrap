<?php

/**
 * Configuration for the Bootstrap theme
 *
 *
 * @package   Moodle Bootstrap theme
 * @copyright 2013 Bas Brands. www.sonsbeekmedia.nl
 * @authors Bas Brands, David Scotson
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$THEME->doctype = 'html5';
$THEME->yuicssmodules = array();
$THEME->name = 'bootstrap';
$THEME->parents = array('');
$THEME->sheets = array('moodle',
					   'override',
					   'dock'
					   );
$THEME->supportscssoptimisation = false;

$THEME->editor_sheets = array('editor');

$THEME->enable_dock = true;

$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$THEME->plugins_exclude_sheets = array(
    'block' => array(
        'settings',
        'navigation',
        'html'
    ),
    'gradereport' => array(
        'grader',
    ),
);

$THEME->layouts = array(
    'base' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    'standard' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    'course' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true),
    ),
    'coursecategory' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    'incourse' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    'frontpage' => array(
        'file' => 'front.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
         'options' => array('nonavbar'=>true),		 
    ),
    'admin' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    'mydashboard' => array(
        'file' => 'my.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true),
    ),
    'mypublic' => array(
        'file' => 'my.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    'login' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('langmenu'=>true),
        'options' => array('nonavbar'=>true, 'noheader'=>true),
    ),
    'popup' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'noblocks'=>true, 'nonavbar'=>true),
    ),
    'frametop' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true),
    ),
    'maintenance' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true),
    ),
    'embedded' => array(
        'theme' => 'canvas',
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true),
    ),
    'print' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>false, 'noblocks'=>true),
    ),
    'redirect' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>false, 'noblocks'=>true),
    ),
    'report' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'nocustommenu'=>true,
                           'nologinlinks'=>true, 'nocourseheaderfooter'=>true),
    ),
);

$THEME->csspostprocess = 'bootstrap_user_settings';

if (empty($THEME->settings->enablejquery)) {
    $THEME->javascripts = array(
        'bootstrapengine',
        'moodlebootstrap',
        'bootstrapcollapse',
        'bootstrapdropdown',
    );
}

if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8') || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7') ) {
    $THEME->javascripts[] = 'html5shiv';
}

