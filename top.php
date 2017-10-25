<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP-Mysql</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body onload="script();">
    <div>
        <nav class="navbar navbar-default navigation-clean">
            <div class="container">
                <div class="navbar-header"><p class="navbar-brand">Course management </p>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li id="index" role="presentation"><a href="index.php">Main page </a></li>
                        <li id="add" role="presentation"><a href="add.php">Add new course</a></li>
                        <li id="list" role="presentation"><a href="list.php">List all courses</a></li>
                        <li id="search" role="presentation"><a href="search.php">Search</a></li>
                        <li id="settings" role="presentation"><a href="settings.php">Settings</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
<?php require_once "addClass.php" ?>
<?php session_start(); ?>