<?php
include 'includes/config.inc.php';

secureSession();

?>
<head>
<title>Homepage</title>	
<script src="<?php echo SITE_BASE; ?>/includes/js/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="styles/styles.css"></link>
</head>
<body>
<?php
include 'includes/nav.inc.php';
?>
Welcome 
<?php echo $_SESSION['full_name']; ?>
to the homepage!!

</body>
