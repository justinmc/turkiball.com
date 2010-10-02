<?php

include $_SERVER['DOCUMENT_ROOT'].'/board/SSI.php';	// Lets me use the function smf uses to format the time

// Pastes the requested newsitems in the given style.  0 is content, 1 is newsbar, 2 is archive
function entries ($id, $num, $style)
{
   $rows = getposts($id);
   $entries = count($rows);
   $count = $entries;
   while(($count > 0) && (($entries - $count) < $num))
   {
      $currentvalue = $rows[($count - 1)];
      $DATA = getdbpost($currentvalue);
      $category = ID_BOARDtoCat($DATA['ID_BOARD']);
      $filenum = array_search($currentvalue, $rows) + 1;
      
      // Content
      if ($style == 0)
      {  echo "      <h2><a class = \"lightbg\" href = \"http://www.turkiball.com/feed/" . $filenum . ".php\">" . $DATA['subject'] . "</a></h2>\n";
         echo "      <h3>Category: <a class = \"lightbg\" href = \"http://www.turkiball.com/feed/" . $category[1] . ".php\">" . $category[0] . "</a></h3>\n";
         echo "      <p style = \"text-indent: 0px;\">\n";
         echo $DATA['body'];
         echo "      </p>\n";
         echo "      <h3 style = \"text-align: left;\"><a class = \"lightbg\" href = \"http://www.turkiball.com/board/index.php/topic," . $DATA['ID_TOPIC'] . ".0.html\">Discussion (" . getreplies($DATA['ID_TOPIC']) . " comments)</a></a></h3>\n";
         echo "      <h3 style = \"text-align: right;\">Posted " . timeformat($DATA['posterTime']) . " by <a class = \"lightbg\" href = \"http://www.turkiball.com/feed/people/index.php?name=" . $DATA['posterName'] . "\">" . $DATA['posterName'] . "</a></h3>\n";
         echo "      <br><br><br>\n";
         echo "      <div class = \"contentline\"></div>\n";
      }
      // Newsbar
      elseif ($style == 1)
      {  echo "      <div class = \"newsitem\">\n";
         echo "         <a href = \"http://www.turkiball.com/feed/" . $category[1] . "/index.php\">\n";
         echo "            <img src = \"http://www.turkiball.com/images/cat" . $category[1] . "w.jpg\" alt = \"" . $category[0] . "\" width = \"150px\" height = \"30px\" border = \"0\" style = \"position: relative; top: -1px; left: -1px;\">\n";
         echo "         </a>\n";
         echo "         <h5>Posted " .  dateShrink(timeformat($DATA['posterTime'])) . "</h5>\n";
         echo "         <h4><a href = \"http://www.turkiball.com/feed/" . $filenum . ".php\">" . $DATA['subject'] . "</a></h4>\n";
         echo "         <h6>By <a href = \"http://www.turkiball.com/feed/people/index.php?name=" . $DATA['posterName'] . "\">" . $DATA['posterName'] . "</a></h6>\n";
         echo "      </div>\n";
      }
      // Archive
      elseif ($style == 2)
      {
         // Setup the table
         if ($count == $entries)
         {  echo "      <table height=\"87\" cellspacing=\"8\" cellpadding=\"4\" width=\"530\" border=\"0\">\n";
            echo "      <tbody>\n";
            echo "      <tr><td><b>Title</b></td>\n";
            echo "      <td><b>Category</b></td>\n";
            echo "      <td><b>Date</b></td>\n";
            echo "      <td><b>By</b></td></tr>\n";
            echo "      <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
         }

         echo "      <tr><td><a class = \"lightbg\" href = \"http://www.turkiball.com/feed/" . $filenum . ".php\"><b>" .  $DATA['subject'] . "</b></a></td>\n";
         echo "      <td><a class = \"lightbg\" href = \"http://www.turkiball.com/feed/" . $category[1] . ".php\"><b>" .  $category[0] . "</b></a></td>\n";
         echo "      <td><b>" .  dateShrink(timeformat($DATA['posterTime'])) . "</b></a></td>\n";
         echo "      <td><a class = \"lightbg\" href = \"http://www.turkiball.com/feed/people/index.php?name=" . $DATA['posterName'] . "\"><b>" . $DATA['posterName'] . "</b></td></tr>\n";
 
         // Close out the table
         if ($count == 1)
         {  echo "      </tbody>\n";
            echo "      </table>\n";
         }
      }
      else
         echo "Error: invalid $style parameter received\n";
               
      $count--;
   }
}

// Echoes links to all of the Guardian Sports members' profiles
function people()
{
   $members = getmembers(14);      
   $count = 0;
   while ($count < count($members))
   {  $currentvalue = getdbmember($members[$count]);
      echo "<a class = \"lightbg\" href = \"http://www.turkiball.com/feed/people/index.php?name=" . $currentvalue['memberName'] . "\">" . $currentvalue['memberName'] . "</a><br><br>\n";
      $count++;
   }
}

// Echoes all of the pictures in the images/pictures directory
function pictures()
{
   $dir = "http://www.turkiball.com/images/pictures/";

// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
        }
        closedir($dh);
    }
}


}

// Given an ID_BOARD, returns an array where 0 is the printable name of the category, and 1 is the linkable name
function ID_BOARDtoCat ($id)
{
   $idtocat = array(4 => "Events",
					     8 => "League News",
					     9 => "Turkiball News",
					    10 => "Other News");
					    
	$idtolink = array(4 => "events",
					      8 => "league",
					      9 => "turkiball",
					     10 => "other");
					 
   $result = array(0 => $idtocat[$id], 1 => $idtolink[$id]);

   return($result);
}

// Takes a date given by the timeformat fn and puts it in mm/dd/yy format
function dateShrink($date)
{
   $count = 0;
   $completion = 0;
   while($completion < 3)
   {
      if ($count > 100)
         $completion = 4;  
   
      if (substr($date, $count, 1) == ' ')
      {
         if ($completion == 0)
         {  $month = substr($date, 0, $count);
            $completion++;
         }
      }
      if (substr($date, $count, 1) == ',')
      {  
         if ($completion == 1)
            $day = substr($date, ($count - 2), 2);
         else
            $year = substr($date, ($count - 4), 4);
         $completion++;
      }
      
      $count++;
   }

   switch ($month)
   {  case "January":
         $wmonth = "01";
      break;
      case "February":
         $wmonth = "02";
      break;
      case "March":
         $wmonth = "03";
      break;
      case "April":
         $wmonth = "04";
      break;
      case "May":
         $wmonth = "05";
      break;
      case "June":
         $wmonth = "06";
      break;
      case "July":
         $wmonth = "07";
      break;
      case "August":
         $wmonth = "08";
      break;
      case "September":
         $wmonth = "09";
      break;
      case "October":
         $wmonth = "10";
      break;
      case "November":
         $wmonth = "11";
      break;
      case "December":
         $wmonth = "12";
      break;
   }

   $year = substr($year, 2, 2);
   
   $wdate = $wmonth . "/" . $day . "/" . $year;   
   
   return ($wdate);
}
 
function navbottom ($num, $where)																										// Pastes the nav buttons to the correct next/archive/prev
{																																					// where = 'News' for all categories, or the category you want
   $rows = getrows($where);
   
   if ($where == 'News')
   {  $filenewer = "index.php?post=" . ($num + 1);
      $fileolder = "index.php?post=" . ($num - 1);
      $filearchive = "archive.php";
   }
   else
   {  $filenewer = $where . "/" . ($num + 1) . ".php";
      $fileolder = $where . "/" . ($num - 1) . ".php";
      $filearchive = $where . "/archive.php";
   }
      
   $oldlink = "<p style = \"position: absolute; bottom: 0px; left: 0px;\">
               <a class = \"lightbg\" href = \"http://www.turkiball.com/feed/" . $fileolder . ".php\">Older Post</a></p>\n";
   $archivelink = "<p style = \"position: absolute; bottom: 0px; left: 240px;\">
                   <a class = \"lightbg\" href = \"http://www.turkiball.com/feed/" . $filearchive . ".php\">Archive</a></p>\n";
   $newlink = "<p style = \"position: absolute; bottom: 0px; right: 20px;\">
               <a class = \"lightbg\" href = \"http://www.turkiball.com/feed/" . $filenewer . ".php\">Newer Post</a></p>\n";
   
   if ($num == $rows)
   {  $newlink = "<!-- Newest -->";
   }
   elseif ($num == 1)
   {  $oldlink = "<!-- Oldest -->";
   }
  
   echo $oldlink;
   echo $archivelink;
   echo $newlink;
} 
   
         
function mysterysomething()
{         
   $Date = datechange($DATA['Date']);
   echo "<br><h6> Posted $Date </h6>\n";																				// Date
         
   echo "<br><br><br>\n";
   echo "</div>\n";
   
   $rows = getrows($cat);
   $num = $DATA['Number'];
      
   if ($num == 1)
   {
      $out = "<!-- No previous, this is the oldest post -->";
   }
   else
   {  $prevnum = $num - 1;
      $prev = "<a href = \"http://www.justinmccandless.com/index.php?entry=" . $prevnum . ".php\">Older Post</a>\n";
   }

   if ($num == $rows)
   {
      $out = "<!-- No next, this is the newest post -->";
   }
   else
   {  $nextnum = $num + 1;
      $next = "<a href = \"http://www.justinmccandless.com/index.php?entry=" . $nextnum . "\">Newer Post</a>\n";
   }      
      
   echo "<div class = \"footer\">\n";																					// Footer nav
   echo "<div class = \"prev\">\n";
   echo $prev;
   echo "</div>\n";
   echo "<div class = \"next\">\n";
   echo $next;
   echo "</div>\n";

   $wyear = substr($DATA['Date'],6,2);
   $wyear = "20" . $wyear;
      
   echo "<div class = \"footerline\">\n";																				// Footer Sig      
   echo "<h3> Justin McCandless, ";
   echo $wyear;
   echo " </h3>\n";
   echo "</div>\n";
}

function index ($num)																															// Master Function
{																																						// On the home page, does everything needed to paste in the entry
   $DATA = getdb($num);																															// Only differs from entry() in a few links
   
   echo "<h1> <a href = \"entries/"; 
   echo $DATA['Number'];
   echo ".php\"> "; 
   echo $DATA['Title']; 
   echo " </a> </h1>\n";
   echo "<font style = \"font-size: 11pt;\">Category: <a href = \"";
   echo decap($DATA['Category']);																						// Category
   echo "/index.php\">";
   echo $DATA['Category'];
   echo "</a></font><br><br>\n";																							// Title
   echo $DATA['Entry'];
   echo "\n";																													// Entry
         
   $Date = datechange($DATA['Date']);
   echo "<br><h6> Posted $Date </h6>\n";																				// Date
         
   echo "<br><br><br>\n";
   echo "</div>\n";
      
   $prev = getnavprevindex($DATA['Number']);      
   $next = getnavnext('all', $DATA['Number']);      
      
   echo "<div class = \"footer\">\n";																					// Footer nav
   echo "<div class = \"prev\">\n";
   echo $prev;
   echo "</div>\n";
   echo "<div class = \"next\">\n";
   echo $next;
   echo "</div>\n";

   $wyear = substr($DATA['Date'],6,2);
   $wyear = "20" . $wyear;
      
   echo "<div class = \"footerline\">\n";																				// Footer Sig      
   echo "<h3> Justin McCandless, ";
   echo $wyear;
   echo " </h3>\n";
   echo "</div>\n";
}

function entry ($num)																															// Master Function
{																																						// On entry pages, does everything needed to paste in the entry
   $DATA = getdb($num);
   
   echo "<h1> <a href = \""; 
   echo $DATA['Number'];
   echo ".php\"> "; 
   echo $DATA['Title']; 
   echo " </a> </h1>\n";
   echo "<font style = \"font-size: 11pt;\">Category: <a href = \"../";
   echo decap($DATA['Category']);																						// Category
   echo "/index.php\">";
   echo $DATA['Category'];
   echo "</a></font><br><br>\n";																							// Title
   echo $DATA['Entry'];
   echo "\n";																													// Entry
         
   $Date = datechange($DATA['Date']);
   echo "<br><h6> Posted $Date </h6>\n";																				// Date
         
   echo "<br><br><br>\n";
   echo "</div>\n";
      
   $prev = getnavprev($DATA['Number']);      
   $next = getnavnext('all', $DATA['Number']);      
      
   echo "<div class = \"footer\">\n";																					// Footer nav
   echo "<div class = \"prev\">\n";
   echo $prev;
   echo "</div>\n";
   echo "<div class = \"next\">\n";
   echo $next;
   echo "</div>\n";

   $wyear = substr($DATA['Date'],6,2);
   $wyear = "20" . $wyear;
      
   echo "<div class = \"footerline\">\n";																				// Footer Sig      
   echo "<h3> Justin McCandless, ";
   echo $wyear;
   echo " </h3>\n";
   echo "</div>\n";
}

function entrycat ($cat, $num)																							// Master Function
{																																	// On category entry pages, does everything needed to paste in the entry
 	$count = 0;																													// Given the category, and which entry is needed (1 = oldest, 2 = second oldest, etc.)
 	$found = 0;
 	while ($found != $num)
 	{
 	   $DATA = getdb($count);
 	   if ($DATA['Category'] == $cat)
 	   {  $found++;
 	   }
 	   $count++;
 	} 																																
   $count--;																													// Just to correct an off by one error

   $DATA = getdb($count);																										
   
   echo "<h1> <a href = \""; 
   echo $DATA['Number'];
   echo ".php\"> "; 
   echo $DATA['Title']; 
   echo " </a> </h1>\n";
   echo "<font style = \"font-size: 11pt;\">Category: <a href = \"../";
   echo decap($DATA['Category']);																						// Category
   echo "/index.php\">";
   echo $DATA['Category'];
   echo "</a></font><br><br>\n";																							// Title
   echo $DATA['Entry'];
   echo "\n";																													// Entry
         
   $Date = datechange($DATA['Date']);
   echo "<br><h6> Posted $Date </h6>\n";																				// Date
         
   echo "<br><br><br>\n";
   echo "</div>\n";
      
   $prev = getnavprev($num);      
   $next = getnavnext($cat, $num);      
      
   echo "<div class = \"footer\">\n";																					// Footer nav
   echo "<div class = \"prev\">\n";
   echo $prev;
   echo "</div>\n";
   echo "<div class = \"next\">\n";
   echo $next;
   echo "</div>\n";

   $wyear = substr($DATA['Date'],6,2);
   $wyear = "20" . $wyear;
      
   echo "<div class = \"footerline\">\n";																				// Footer Sig      
   echo "<h3> Justin McCandless, ";
   echo $wyear;
   echo " </h3>\n";
   echo "</div>\n";
}

function datechange ($machine)															// Takes a crazy machine made date stamp, returns a nice mm/dd/yy
{
   // Assuming I've given a date like: 	2009-08-04T18:00:00Z
   // I would then return:		08/04/09

   $yy = substr($machine, 2, 2);
   $mm = substr($machine, 5, 2);
   $dd = substr($machine, 8, 2); 

   $human = $mm . "/" . $dd . "/" . $yy;

   return($human);
}

function decap ($cat)																																// Makes the first letter of a category lowercase
{																																							// For the purpose of links
   switch ($cat)
   {  case "Life":
         $lcat = "life";
      break;
      case "Travel":
         $lcat = "travel";
      break;
      case "Solutions":
         $lcat = "solutions";
      break;
      case "Websites":
         $lcat = "websites";
      break;
      case "Technology":
         $lcat = "technology";
      break;
   }
   return ($lcat);
}

function getnews ($cat)																																// Gets the newest news items from a specific category or from all
{																																							// The passed in parameter cat can equal
   $row = getrows('all');																																	// all, Websites, Solutions, Technology, Travel, or Life
   $count = 0;
   while (($count < 8) && ($row > 0))														// Replace this with the number of news entries you want in the newsbar
   {  
      $DATA = getdb($row);
      if (($DATA['Category'] == $cat) || ($cat == "all"))
      { 
         echo $DATA['Date'];
         echo "\n";
         echo "<h2><a href = \"";
         echo $DATA['Address'];
         echo "\">";
         echo $DATA['Title'];
         echo "</a></h2><br>\n";
         echo "<div class = \"dividernews\"></div><br>\n";
         $count++;
      }      
      $row--;
   }
}

function getnavprev ($num)																						// Fills in the link at the bottom for previous
{
   if ($num == 1)
   {
      $out = "<!-- No previous, this is the oldest post -->";
   }
   else
   {  $prev = $num - 1;
      $out = "<a href = \"" . $prev . ".php\">Older Post</a>\n";
   }
   
   return ($out);
}

function getnavprevindex ($num)																				// Same as getnavprev but for index.php, not entries.
{
   $prev = $num - 1;
   $out = "<a href = \"/entries/" . $prev . ".php\">Older Post</a>\n";
   
   return ($out);
}

function getnavnext ($cat, $num)																						// Fills in the link at the bottom for next
{
   $rows = getrows($cat);
   if ($num == $rows)
   {
      $out = "<!-- No next, this is the newest post -->";
   }
   else
   {  $next = $num + 1;
      $out = "<a href = \"" . $next . ".php\">Newer Post</a>\n";
   }
   
   return ($out);
}

function getnewest ($cat)																						// Gets the newest post number for a given category
{																														// Currently unused...
   $found = 0;
   $count = getrows('all');
   while ($found == 0)
   {
      $DATA = getdb($count);
      if ($DATA['Category'] == $cat)
      {   $found = 1;
      }
      else
      {  $count--;
      }
   }
   return ($count);
}








?>