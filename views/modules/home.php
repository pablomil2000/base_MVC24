<?php

// Todo: Compoent code here

$category = new CategoryController('categorias');
$categories = $category->getAll();

// var_dump($categories);


require_once ("./views/partials/home.view.php");