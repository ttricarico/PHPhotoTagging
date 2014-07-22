<?php
session_start();
date_default_timezone_set('America/New_York');

require_once('./yaplib/Yap.php');
require_once('./settings.php');
require_once('./controllers/__includes.php');

//set up YapLib modules
$route = yap('YapRouter');
$users = yap('YapUsers');
$session = yap('YapSession');

$template = yap('YapTemplate');
$template->setDirectory(realpath(dirname(__FILE__).'/templates'));

$mysql = yap('YapMySQL');
$mysql->activate($settings['dbname'], $settings['dbserver'], $settings['dbuser'], $settings['dbpass']); // start mysql connection (found in settings.php);


/** log in and log out **/
$route->get('/login', array('PageManager', 'loginGET'));
$route->post('/login', array('PageManager', 'loginPOST'));
$route->get('/logout', array('PageManager', 'logoutGET'));

/** main dashboard **/
$route->get('/', array('PageManager', 'mainPage'));

/** picture stuff **/
$route->get('/photo', array('PhotoManager', 'listAll'));
$route->get('/photo/(\w+)', array('PhotoManager', 'showPhoto'));
$route->get('/photo/(\w+)/tag', array('PhotoManager', 'tagPhotoGET'));
$route->post('/photo/(\w+)/tag', array('PhotoManager', 'tagPhotoPOST'));
$route->get('/photo/(\w+)/edit', array('PhotoManager', 'editPhotoGET'));
$route->post('/photo/(\w+)/edit', array('PhotoManager', 'editPhotoPOST'));
$route->get('/photo/(\w+)/delete', array('PhotoManager', 'deletePhotoGET'));
$route->post('/photo/(\w+)/delete', array('PhotoManager', 'deletePhotoPOST'));
$route->post('/photo/(\w+)/comment', array('PhotoManager', 'addCommentPOST'));

//future - put albums

/** upload functions **/
$route->get('/photo/upload', array('PhotoManager', 'uploadPhotoGET'));
$route->post('/photo/upload', array('PhotoManager', 'uploadPhotoPOST'));

/** 404 page **/
$route->get('.*', array('PageManager', 'error404'));
$route->post('.*', array('PageManager', 'error404'));

/** run the routing table **/
//if not logged in, send to login screen
if(!$session->get('loggedin') && $_REQUEST['__route__'] !== '/login') {
  header('Location: '.baseurl().'/login');
  die();
}
//otherwise, just run

$route->run();
