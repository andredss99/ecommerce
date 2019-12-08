<?php

use \Andredss\PageAdmin;
use \Andredss\Model\User;
use \Andredss\Model\Category;

$app->get("/admin/categories", function() {
	User::verifyLogin();

	$categories = Category::listAll();
	
	$page = new PageAdmin();

	$page->setTpl("categories", [
		'categories' => $categories
	]);
});

$app->get("/admin/categories/create", function() {
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("categories-create");
});

$app->post("/admin/categories/create", function() {
	User::verifyLogin();

	$category = new Category();
	$category->setData($_POST);
	$category->save();

	header("location: /index.php/admin/categories");
	exit;
});

$app->get("/admin/categories/:idcategory/delete", function($idcategory) {
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);
	$category->delete();

	header("location: /index.php/admin/categories");
	exit;
});

$app->get("/admin/categories/:idcategory", function($idcategory) {
	User::verifyLogin();
	
	$category = new Category();
	$category->get((int)$idcategory);
	
	$page = new PageAdmin();

	$page->setTpl("categories-update", [
		'category' => $category->getValues()
	]);
});

$app->post("/admin/categories/:idcategory", function($idcategory) {
	User::verifyLogin();
	
	$category = new Category();
	$category->get((int)$idcategory);

	$category->setData($_POST);
	$category->save();

	header("location: /index.php/admin/categories");
	exit;
});