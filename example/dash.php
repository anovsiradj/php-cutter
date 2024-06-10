<!doctype html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $page_title ?></title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

	<style>
		html,
		body {
			overflow-x: hidden;
			/* Prevent scroll on narrow devices */
		}

		body {
			padding-top: 70px;
		}

		footer {
			padding: 30px 0;
		}

		/*
		 * Off Canvas
		 * --------------------------------------------------
		 */
		@media screen and (max-width: 767px) {
			.row-offcanvas {
				position: relative;
				-webkit-transition: all .25s ease-out;
				-o-transition: all .25s ease-out;
				transition: all .25s ease-out;
			}

			.row-offcanvas-right {
				right: 0;
			}

			.row-offcanvas-left {
				left: 0;
			}

			.row-offcanvas-right .sidebar-offcanvas {
				right: -50%;
				/* 6 columns */
			}

			.row-offcanvas-left .sidebar-offcanvas {
				left: -50%;
				/* 6 columns */
			}

			.row-offcanvas-right.active {
				right: 50%;
				/* 6 columns */
			}

			.row-offcanvas-left.active {
				left: 50%;
				/* 6 columns */
			}

			.sidebar-offcanvas {
				position: absolute;
				top: 0;
				width: 50%;
				/* 6 columns */
			}
		}
	</style>

	<?php $cutter->section('css') ?>
</head>

<body>
	<?php $cutter->load($cutter->path('/dash_header')) ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-9">
				<h1><?= $page_title ?></h1>

				<?php $cutter->section('content') ?>
			</div>

			<div class="col-sm-3">
				<?php $cutter->load($cutter->path('/dash_sidebar')) ?>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
	<?php $cutter->section('js') ?>
</body>

</html>