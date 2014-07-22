<?php

$settings = array(
  'baseurl' => 'http://path.to/your/directory',
  'dbname'  => '',
  'dbserver'=> '',
  'dbuser'  => '',
  'dbpass'  => ''
);

/** create users **/
$users = yap('YapUsers');
$users->addUser(/*username*/, /*password*/);

/** do not edit below this line **/

function baseurl() {
  global $settings;
  return $settings['baseurl'];
}
function basepath() {
  return realpath(dirname(__FILE__));
}
