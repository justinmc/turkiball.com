<?php

require("functions_news.php");
include("functions_db.php");

function head($where)
{
   $version = "3.0";
   $keywords = "Turkiball, sport, sports, Guardian Sports";
   if ($where == 0)
      $title = "Turkiball - Home";
   elseif ($where == 1)
      $title = "Turkiball - The Feed";
   elseif ($where == 2)
      $title = "Turkiball - The League";
   else
      echo "Error: invalid $where parameter passed.\n";

   echo "<meta name=\"keywords\" content=\"" . $keywords . "\">\n\n";
   echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n\n";
   echo "<!-- Favicon link -->\n";
   echo "<link REL=\"SHORTCUT ICON\" HREF=\"http://www.turkiball.com/images/favicon.ico\">\n\n";
   echo "<!-- CSS link -->\n";
   echo "<link rel = 'stylesheet' type = \"text/css\" href = \"http://www.turkiball.com/beta/style.css\">\n\n";
   echo "<script type=\"text/javascript\" src=\"http://www.turkiball.com/scripts/functions.js\"></script>\n\n";
   echo "<title>" . $title . "</title>\n\n";
}

function title()
{
   echo "<br>\n";
   echo "<div class = \"all\">\n\n";
   echo "   <div class = \"alltop\"></div>\n";
   echo "   <div class = \"titlebar\">\n";
   echo "      <div class = \"title\">\n";
   echo "         <a href = \"http://www.turkiball.com/index.php\">\n";
   echo "         <img src = \"http://www.turkiball.com/images/titleinv.jpg\" border = \"0\" alt = \"Title\">\n";
   echo "         </a>\n";
   echo "      </div>\n";
   echo "   </div>\n";
}

// Echoes the newsbar, given $where we're at.
// 0 is home, 1 is feed, 2 is league, 3 is board
function newsbar($where)
{
/*
   $feed = "";
   $league = "";
   $board = "";
   if ($where == 0)
      $home = " class = \"active\""; // Currently $home is unused
   elseif ($where == 1)
      $feed = " class = \"active\"";
   elseif ($where == 2)
      $league = " class = \"active\"";
   elseif ($where == 3)
      $board = " class = \"active\"";
   else
      echo "Error: invalid $where parameter passed.\n";
*/
   echo "   <div class = \"news\">\n";
/*
   echo "      <ul class = \"newslink\"><li" . $board . "><a href = \"http://www.turkiball.com/board\">The Board</a></ul>\n";
   echo "      <br><br><br>\n";
   echo "      <ul class = \"newslink\"><li" . $league . "><a href = \"http://www.turkiball.com/league\">The League</a></ul>\n";
   echo "      <br><br><br>\n";
   echo "      <ul class = \"newslink\"><li" . $feed . "><a href = \"http://www.guardiansportsalliance.com\">Guardian Sports</a></ul>\n";   
   echo "      <br><br><br>\n";
   echo "      <div class = \"newsline\"></div>\n";

   entries(0, 4, 1);
*/      
   echo "      <br><br>\n";
   echo "      <div class = \"advert\">\n";
   
   echo "         <script type=\"text/javascript\"><!--\n";
   echo "         google_ad_client = \"pub-4995961092121508\";\n";
   echo "         /* 120x600 Skyscraper */\n";
   echo "         google_ad_slot = \"0720030849\";\n";
   echo "         google_ad_width = 120;\n";
   echo "         google_ad_height = 600;\n";
   echo "         //-->\n";
   echo "         </script>\n";
   echo "         <script type=\"text/javascript\"\n";
   echo "         src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">\n";
   echo "         </script>\n";   
   
//   echo "         <a href = \"http://www.turkiball.com\">\n"; 
//   echo "         <img src = \"http://www.turkiball.com/images/advert2.jpg\" alt = \"turkiball\" border = \"0\">\n";
//   echo "         </a>\n";
   echo "         <h3 style = \"position: relative; top: -10px; color: #ffffff;\">Advertisement</h3>\n";      
   echo "      </div>\n";
   echo "   </div>\n";   
}

function navbarleft ()
{
   echo "   <div class = \"navleft\">\n";
   
   echo "         <div class = \"box\">\n";
   echo "            Stuff<br><br>\n";
   echo "            <ul class = \"navbutton\"><li><a href = \"http://www.turkiball.com/beta/index.php\">Home</a></ul><br><br>\n";
   echo "            <ul class = \"navbutton\"><li><a href = \"http://www.turkiball.com/beta/sport.php\">The Sport</a></ul><br><br>\n";
   echo "            <ul class = \"navbutton\"><li><a href = \"http://www.turkiball.com/beta/rules.php\">The Rules</a></ul><br><br>\n";
   echo "            <ul class = \"navbutton\"><li><a href = \"http://www.turkiball.com/beta/more.php\">More</a></ul><br><br>\n";
   echo "            <br>\n";
   echo "         </div>\n";
   
   echo "         <div class = \"box\">\n";
   echo "            Links<br><br>\n";
   echo "            <ul class = \"navbutton\"><li><a href = \"http://www.guardiansportsalliance.com\">Guardian Sports</a></ul><br><br>\n";
   echo "            <ul class = \"navbutton\"><li><a href = \"http://www.guardiansportsalliance.com/board\">The Forum</a></ul><br><br>\n";
   echo "            <br>\n";
   echo "         </div>\n";
   
   echo "      </div>\n";
}

// echoes the main content.  type, amount, and style go to entries, filename is for echoContent
function content ($where, $type, $amount, $style, $filename)
{
   if (strpos($filename, 'index'))
   {  $title = "HOME";
      $link = "index";
   }
   if (strpos($filename, 'sport'))
   {  $title = "THE SPORT";
      $link = "sport";
   }
   if (strpos($filename, 'rules'))
   {  $title = "THE RULES";
      $link = "rules";
   }
   if (strpos($filename, 'more'))
   {  $title = "MORE TURKIBALL";
      $link = "more";
   }
      
   echo "   <div class = \"content\">\n";
   echo "      <div class = \"spacer\"></div>\n";
   echo "      <h1><a class = \"lightbg\" href = \"http://www.turkiball.com/" . $link . ".php\">" . $title . "</a></h1>\n";
   echo "      <br>\n";
   echo "      <div class = \"contentline\"></div>\n";

   echoContent($filename);
 
   entries($type, $amount, $style);
   
   if (strpos($filename, 'people') && !strpos($filename, '?'))
      people();
   elseif (strpos($filename, 'pictures'))
      pictures();

   echo "      <br><br><br><br><br><br><br><br><br>\n";
   echo "   </div>\n";
}

function bottom($ID_MSG)
{
   echo "    <div class = \"sitefooter\">\n";
   echo "       <img src = \"http://www.turkiball.com/images/evofsportbig.jpg\" alt = \"The Evolution of Sport\" style = \"position: relative; top: 10px;\"> <br>\n";
   echo "       <h3>\n";
   echo "       &copy; 2010 Guardian Sports, Ann Arbor, MI<br>\n";
   echo "       <a class = \"lightbg\" href = \"mailto: contact@turkiball.com\">contact@turkiball.com</a>\n";
   echo "       </h3>\n";
   echo "    </div>\n";
   echo "    <div class = \"allbottom\">\n";
   echo "      <ul class = \"navbottom\">\n";
   
   if (strpos($filename, 'events'))
   {  $id = 4;
      $cat = "events";
   }
   elseif (strpos($filename, 'league'))
   {  $id = 8;
      $cat = "league";
   }
   elseif (strpos($filename, 'other'))
   {  $id = 10;
      $cat = "other";
   }
   elseif (strpos($filename, 'turkiball') > 20)
   {  $id = 9;
      $cat = "turkiball";
   }
   else
   {  $id = 0;
      $cat = "";
   }
   
   echo "      </ul>\n";    
   echo "    </div>\n\n";
       
   echo "</div>\n\n";
}

// Updates the pages and the member's profiles.  Passing a 1 for $what gives pages, a 2 gives profiles
function update($stage, $what)
{  
   // Select the profile to edit
   if ($stage == 1)
   {
      if ($what == 1)
      {
         echo "<p>Which page do you want to edit?</p><br><br>\n";
      
         echo "<form method = \"post\" action = \"index.php?num=2\">\n";
         echo "<table cellspacing=\"1\" cellpadding=\"2\" width=\"604\" border=\"1\">\n";
      
         $rows = getrowsturk('Content');      
         $count = 0;
         while ($count < $rows)
         {
            $DATA = getdbturk($count, 'Content');
            // Skips over the profile pages
            if (!strpos($DATA['Address'], 'people/index.php?'))
            {
               echo "<tr>\n";
               echo "<td>" . $DATA['Address'] . "</td>\n";
               echo "<td><input type = \"radio\" value = \"" . $DATA['Address'] . "\" name = \"id\"></td>\n";
               echo "</tr>\n";
            }
            $count++;
         }
      }
      else
      {
         echo "<p>Which member's profile do you want to edit?</p><br><br>\n";
      
         echo "<form method = \"post\" action = \"index.php?num=2\">\n";
         echo "<table cellspacing=\"1\" cellpadding=\"2\" width=\"504\" border=\"1\">\n";
      
         $members = getmembers(14);      
         $count = 0;
         while ($count < count($members))
         {
            $currentvalue = getdbmember($members[$count]);
            echo "<tr>\n";
            echo "<td>" . $currentvalue['memberName'] . "</td>\n";
            echo "<td><input type = \"radio\" value = \"" . $currentvalue['memberName'] . "\" name = \"id\"></td>\n";
            echo "</tr>\n";
            $count++;
         }
      }
      
      echo "</tbody>\n";
      echo "</table>\n";
      echo "<br><br><br>\n";
      echo "<input type = \"submit\" value = \"Edit\">\n";
      echo "</form>\n";
      echo "<br><br><br><br><br>\n";
   }
   
   // Edit the profile
   elseif ($stage == 2)
   {
      $filename = $_REQUEST["id"];
      if ($what == 2)
         $filename = "http://www.turkiball.com/feed/people/index.php?name=" . $filename;
      
      echo "<p>\n";
      if ($what == 1)
         echo "Edit the web page here:<br>\n";
      else
         echo "Edit the profile here:<br>\n";
      echo "</p>\n";
      echo "<br><br>\n";
      echo "<form method = \"post\" action = \"index.php?num=3\">\n";
      echo "<textarea id=\"editor1\" name=\"editor1\" rows=\"10\" cols=\"80\">";
      echoContent($filename);
      echo "</textarea>\n";
      // Replace that textarea with CKEditor
      echo "<script type=\"text/javascript\">\n";
      echo "var editor = CKEDITOR.replace( 'editor1' );\n";
	   echo "CKFinder.SetupCKEditor( editor, '/ckfinder/' ) ;\n";
	
	//   echo "CKEDITOR.replace( 'editor1' );\n";
	//   echo "CKFinder.SetupCKEditor( editor, '../../ckfinder/' ) ;\n";
	   echo "</script>";
	   
	   echo "<input type = \"hidden\" name = \"Address\" value = \"" . $filename . "\" />\n";
	   echo "<br><br><br>\n";
      echo "<input type = \"submit\" value = \"Submit\">\n";
      echo "</form>\n";
      echo "<br><br><br><br><br>\n";
   }
   
   // Update the database
   elseif ($stage == 3)
   {
      $html = $_POST["editor1"];
      
//      $apost = "'";
//      $apostcom = "\\'";
//      $html = str_replace($apost,$apostcom,$html);																				// Fixes the murderous apostrophe error by escaping apostrophes
      $Address = $_POST["Address"];
      $index = getrowsturk('Content');
      $new = doesItExist('Content', 'Address', $Address);
      
      $con = mysql_connect("mysql2561int.domain.com", "u1064984_turki", "ldbdin473:klaonm");
      if (!$con)
         die('Could not connect: ' . mysql_error());

      mysql_select_db("db1064984_turkiball");
      
      // If true, we're updating a profile
      if($new)
         mysql_query("UPDATE `Content` SET Content = '$html' WHERE Address = '$Address'");

      // We're creating a new entry in the db
     else
     {  mysql_query("INSERT INTO `Content` (`Index`, `Address`, `Content`) VALUES ('$index', '$Address', '$html');");        
     }
      
      mysql_close($con);
      
      if ($what == 1)
         echo "<h3> You're web page update was received. </h3><br><br><br><br>";
      else
         echo "<h3> You're profile update was received. </h3><br><br><br><br>";
   }
}

?>

