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

    $error = false;

    if($session->get('loginerror')) {
      $error = array('detail' => $session->get('loginerrordesc'));
      $session->delete('loginerror');
      $session->delete('loginerrordesc');
    }

    $template->display('header.php', array('title' => 'Log In'));
    $template->display('pages/login.php', array('error' => $error));
    $template->display('footer.php');
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

  }//logoutGET()

  public static function error404() {

  } //error404
}