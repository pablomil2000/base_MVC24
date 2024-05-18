<?php
session_start();

//  --  Controllers
require_once ("./controllers/template.controller.php"); //* Template load controller
require_once ("./controllers/route.controller.php"); //* Route controller
require_once ("./controllers/crud.controller.php"); //* CRUD controller

require_once ("./controllers/category.controller.php");


//  --  Modules
require_once ("./models/conexion.model.php"); //* Connection to the data origin
require_once ("./models/crud.model.php"); //* CRUD model


//  --  Load template
$tempalteCtrl = new TemplateController('./views/layouts/', 'template');
$GLOBALS['RouteCtrl'] = new RouteCtrl();

$tempalteCtrl->load();