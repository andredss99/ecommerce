<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Andredss\Page;
use \Andredss\PageAdmin;
use \Andredss\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {   
	$page = new Page();

	$page->setTpl("index");
});

$app->get('/admin', function() {
	User::verifyLogin();
	$page = new PageAdmin();

	$page->setTpl("index");
	var_dump($_SESSION);
});

$app->get('/admin/login', function() {
	$page = new PageAdmin([
		"header" => false,
		"footer" => false
	]);

	$page->setTpl("login");
});

$app->post('/admin/login', function() {
	User::login($_POST["login"], $_POST["password"]);

	header("location: /index.php/admin");
	exit;
});

$app->get('/admin/logout', function() {
	User::logout();
	
	header("location: /index.php/admin/login");
	exit;
});

$app->run();

?>