<?php
define('DOCROOT', substr(str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__), 0, -1));
require_once (DOCROOT. '/query.php');
?>

<!DOCTYPE html>
<html>
<body>
<hr>
<h1>[<?php echo $countOnline?>] active customers</h1>
<hr>
</body>
</html>