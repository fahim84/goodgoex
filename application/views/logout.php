<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log out</title>
</head>

<body>
<script>
		// remove remember me
		localStorage.removeItem("user_id");
		
		window.location.href='<?php echo base_url(); ?>';
</script>
</body>
</html>