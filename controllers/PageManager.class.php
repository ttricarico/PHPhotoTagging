<?php

class PageManager {

  public static function mainPage() {
    global $mysql, $session, $template;

    $template->display('header.php', array('title' => 'Main Page'));
    $template->display('pages/MainPage.php');
    $template->display('footer.php');
  } //mainPage()

  /** login and logout functions **/
  public static function loginGET() {
    global $mysql, $session, $template;

    //if already logged in, skip to dashboard
    if($session->get('loggedin')) {
      header('Location: '.baseurl().'/');
      die();
    }

    $error = false;

    if($session->get('loginerror')) {
      $error = array('detail' => $session->get('loginerrordesc'));
      $session->delete('loginerror');
      $session->delete('loginerrordesc');
    }

    $template->display('pages/login.php', array('error' => $error));
  } //loginGET()

  public static function loginPOST() {
    global $session, $template;

    $users = yap('YapUsers');

    if($users->login($_POST['user'], $_POST['pass'])) {
      $session->set('loggedin', true);
      $session->set('user', $_POST['user']);
      $session->set('logintime', time());
      header('Location: '.baseurl().'/');
    }
    else {
      $session->set('loginerror', true);
      $session->set('loginerrordesc', 'incorrectinfo');
      header('Location: '.baseurl().'/login');
    }

  }//loginPOST()

  public static function logoutGET() {
    session_destroy();

    header('Location: '.baseurl().'/login');
  }//logoutGET()

  public static function error404() {
    echo "<h1>404</h1>";
  } //error404

  /** upload functions **/
  public static function uploadPhotoGET() {
    global $session, $template, $mysql;
    $template->display('header.php', array('title' => 'Main Page',
                                           'addlscripts' => array(baseurl().'/js/uploading.js')
                                          )
                      );
    $template->display('pages/PhotoUpload.php');
    $template->display('footer.php');
  }

  public static function uploadPhotoPOST() {

  }
}
