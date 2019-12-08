<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Andredss\Page;
use \Andredss\PageAdmin;
use \Andredss\Model\User;
use \Andredss\Model\Category;

$app = new Slim();

$app->config('debug', true);

require_once("site.php");
require_once("admin.php");
require_once("admin-users.php");
require_once("admin-categories.php");
require_once("admin-products.php");

$app->run();

?>