<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo AppHelper::instance()->cfg->rootUrl; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page->title; ?> | <?php echo AppHelper::instance()->cfg->title; ?></title>
<?php foreach($scripts as $script){ ?>
	<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<?php foreach($styles as $style){ ?>
	<link rel="stylesheet" href="<?php echo $style; ?>" type="text/css" />
<?php } ?>
</head>
<body>
	<?php echo $content; ?>
</body>
</html>