<?php
require_once('../board/SSI.php');
$_SESSION['login_url'] = 'http://www.turkiball.com/board' . $_SERVER['PHP_SELF'];
$_SESSION['logout_url'] = 'http://www.turkiball.com' . $_SERVER['PHP_SELF'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<?php

   include $_SERVER['DOCUMENT_ROOT'].'/scripts/functions_page.php';

   $filename = "http://www.turkiball.com" . $_SERVER["PHP_SELF"];
   // Removes the slash if there is one
   if (substr($filename, (strlen($filename) - 1), 1) == '/')
   {  $filename = substr($filename, 0, (strlen($filename) - 1));
   }

   head(0); // Means we're in home

?>																								

</head>

<body>

<?php

   title();
   
   newsbar(0); // Means we're in home
   
   navbarleft();
   
   content(0, 0, 0, 0, $filename); // in home, filename for echoContent, rest for the fn entries
   
   bottom();

?>			

</body>

</html>