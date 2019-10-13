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

$app->get('/admin/users', function() {
	User::verifyLogin();
	
	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users" => $users
	));
});

$app->get('/admin/users/create', function() {
	User::verifyLogin();
	
	$page = new PageAdmin();

	$page->setTpl("users-create");
});

//Delete user
$app->get('/admin/users/:iduser/delete', function($iduser) {
	User::verifyLogin();

	$user = new User();
	$user->get((int)$iduser);

	$user->delete();

	header("location: /index.php/admin/users");
	exit;
});

//Update user
$app->get('/admin/users/:iduser', function($iduser){ 
	User::verifyLogin();
  
	$user = new User();
	$user->get((int)$iduser);

	$user->get((int)$iduser);
  
	$page = new PageAdmin();
  
	$page ->setTpl("users-update", array(
		 "user"=>$user->getValues()
	 ));
  
 });

//Create user
$app->post('/admin/users/create', function() {
	User::verifyLogin();

	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;
	$user->setData($_POST);
	$user->save();

	header("location: /index.php/admin/users");
	exit;
});

$app->post('/admin/users/:iduser', function($iduser) {
	User::verifyLogin();

	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;
	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->update();

	header("location: /index.php/admin/users");
	exit;
});

$app->run();

?>