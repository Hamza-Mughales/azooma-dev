<!DOCTYPE html>
<html lang="en" <?= sys_lang() == "arabic" ? 'dir="rtl"' : "" ?>>


<!-- Mirrored from davur.dexignzone.com/dashboard/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Oct 2021 20:21:14 GMT -->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="description" content="Azooma - Restaurant" />
	<meta property="og:title" content="Azooma - Restaurant" />
	<meta property="og:description" content="Azooma - Restaurant" />
	<meta name="format-detection" content="telephone=no">
	<title><?= isset($title) ? $title : '' ?></title>
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("images/favicon_en.png") ?>">
	<?php if (sys_lang() != "arabic") { ?>
		<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
	<?php } ?>
	<script src="<?= base_url(js_path()) ?>/jquery-3.5.1.min.js"></script>
	<link href="<?= base_url(css_path()) ?>/animate.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css">
	<link href="<?= base_url(css_path()) ?>/scrollbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url(css_path()) ?>flag-icon.css">
	<link href="<?= base_url(css_path()) ?>/bootstrap.css" rel="stylesheet">
	<link href="<?= base_url(css_path()) ?>/style.css" rel="stylesheet">
	<link href="<?= base_url(css_path()) ?>/color-1.css" rel="stylesheet">
	<link href="<?= base_url(css_path()) ?>/responsive.css" rel="stylesheet">
	<link href="<?= base_url(css_path()) ?>/select2.min.css" rel="stylesheet">
	<link href="<?= base_url(css_path()) ?>/sweetalert2.css" rel="stylesheet">
	<link href="<?= base_url(css_path()) ?>/main_style.css" rel="stylesheet">
	<?php if (sys_lang() == "arabic") { ?>

		<link href="<?= base_url(css_path()) ?>/rtl.css" rel="stylesheet">

	<?php } ?>

	<script>
		var table_lang = {
			"sProcessing": "<?= lang('sProcessing') ?>",
			"sLengthMenu": " <?= lang('sLengthMenu') ?> ",
			"sZeroRecords": "<?= lang('sZeroRecords') ?> ",
			"sInfo": "<?= lang('sInfo') ?>",
			"sInfoEmpty": "<?= lang('sInfoEmpty') ?>",
			"sInfoFiltered": "<?= lang('sInfoFiltered') ?>",
			"sInfoPostFix": "",
			"sSearch": "<?= lang('sSearch') ?>",
			"sUrl": "",
			"oPaginate": {
				"sFirst": "<?= lang('sFirst') ?>",
				"sPrevious": "<?= lang('sPrevious') ?>",
				"sNext": "<?= lang('sNext') ?>",
				"sLast": "<?= lang('sLast') ?>"
			}
		};
	</script>
</head>