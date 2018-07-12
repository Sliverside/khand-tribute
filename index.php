<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

function error404($message = 'Page introuvable') {
  header('HTTP/1.1 404 Not Found');
  include(ROOT.'/views/errors/404.php');
  return true;
}

function load_view($home = 'home') {
  ob_start();
  $path = ltrim($_SERVER['REQUEST_URI'], '/');
  $vue = ROOT.'/views/'.$path.'.php';
  if(empty(trim($path, '/')[0])) {
    include(ROOT.'/views/'.$home.'.php');
  }else if ($path = '/'.$home) {
    error404();
  }else if(strpos($path, '.')) {
    if(file_exists(ROOT.'/public'.$path)) {
      include(ROOT.'/public'.$path);
    }else {
      error404();
    }
  }else if(file_exists($vue)) {
    include($vue);
  }else {
    error404();
  }
  return ob_get_clean();
}

define('VIEW', load_view());
include ROOT.'/skins/default.php';
