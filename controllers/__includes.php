<?php

$files = glob(dirname(__FILE__) . '/*.php');
foreach($files as $f) {
  require_once($f);
}
