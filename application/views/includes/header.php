<!DOCTYPE html>
<html lang= "en">
<head>
	<meta charset="utf-8">
	<title>TRIMS</title>
	<link href="<?= base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url()?>assets/css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Libre+Franklin:300" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url()?>assets/css/style.css">	
	<link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.min.css" >
	<link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap-theme.min.css">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="<?= base_url()?>assets/js/validation.js"></script>
	<script src="<?= base_url()?>assets/js/result.js"></script>
	<script src="<?= base_url()?>assets/js/dashboard.js"></script>
	<script src="<?= base_url()?>assets/js/template.js"></script>
	<script src="<?= base_url()?>assets/js/event.js"></script>
	<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/js/shortcut.js"></script>
</head>
<body>
<div class="wrapper">
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container">
	   <a class="navbar-brand" href="<?php if($this->session->userdata('user_id') !== FALSE){ echo site_url('menu');} else {echo site_url('/');}?>">TRIMS</a>
	   <?php
			if($this->session->userdata('user_id') == TRUE) {
				echo '<ul class="nav navbar-nav navbar-right">
					   <li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$this->session->userdata("username").'</a></li>
					   <li><a href="'.site_url("dashboard/logout").'"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
				   </ul>';
			}
	   ?>
	  </div>
	</nav>
