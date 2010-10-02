<?php 

// This file contains all of the low level functions that deal directly with the databases, ect.      
      
// Database Data //

$smfserver = "mysql2561int.domain.com";
$smfusername = "u1064984_tbsmf";
$smfpassword = "klein284.iogom";
$smfdb = "db1064984_turkiball_smf";

$server = "mysql2561int.domain.com";
$username = "u1064984_turki";
$password = "ldbdin473:klaonm";
$db = "db1064984_turkiball";
$tableP = "stats_Players";																								// Player Stats Table
$tableT = "stats_Team";																								// Team Stats Table
$tableN = "News";																								// News Table
$tableS = "Season"	;																								// Season table, with schedule info
$tablePS = "PSeason";																								// Post Season table, tournament

// Functions //

function getdb ($index, $table)																								// Accesses the database, given table at given row
{
   global $smfserver, $smfusername, $smfpassword, $smfdb;
   
   $con = mysql_connect($smfserver, $smfusername, $smfpassword);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db($smfdb);
   
   $QUERY = mysql_query("SELECT * FROM $table WHERE Index = '$index'");
   $DATA = mysql_fetch_array($QUERY);

   mysql_close($con);
   
   return ($DATA);
}

// Accesses the database, given table at given row
function getdbturk ($index, $table)
{
   global $server, $username, $password, $db;
   
   $con = mysql_connect($server, $username, $password);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db($db);
   
   $QUERY = mysql_query("SELECT * FROM $table WHERE `Index` = $index");
   $DATA = mysql_fetch_array($QUERY);

   mysql_close($con);

   return ($DATA);
}

// Returns $DATA for the given ID_MSG in the smf_messages table
function getdbpost ($id)
{
   global $smfserver, $smfusername, $smfpassword, $smfdb;

   $con = mysql_connect($smfserver, $smfusername, $smfpassword);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db($smfdb);
   
   $QUERY = mysql_query("SELECT * FROM smf_messages WHERE ID_MSG = $id");
   $DATA = mysql_fetch_array($QUERY);
   
   mysql_close($con);
   
   return ($DATA);
}

// Returns $DATA for the given ID_MEMBER in the smf_members table
function getdbmember ($id)
{
   global $smfserver, $smfusername, $smfpassword, $smfdb;

   $con = mysql_connect($smfserver, $smfusername, $smfpassword);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db($smfdb);
   
   $QUERY = mysql_query("SELECT * FROM smf_members WHERE ID_MEMBER = $id");
   $DATA = mysql_fetch_array($QUERY);
   
   mysql_close($con);
   
   return ($DATA);
}

// Guardian Sports ID_GROUP = 14
// Returns an array with the ID_MEMBER for all members whose ID_GROUP or additionalGroups is the given value
// The oldest will have a key of 0, the newest will have the highest number
function getmembers($group)
{
   global $smfserver, $smfusername, $smfpassword, $smfdb;
   
   $rows = getrows('smf_members');

   $con = mysql_connect($smfserver, $smfusername, $smfpassword);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db($smfdb);
   
   $count = 1; // Because ID_MEMBER starts at 1, not 0
   $found = 0;
   $output = array(0 => 'false');
   while ($count <= $rows)
   {
      $QUERY = mysql_query("SELECT * FROM smf_members WHERE ID_MEMBER = $count");
      $DATA = mysql_fetch_array($QUERY);

      if ((($DATA['ID_GROUP'] == $group) || (strpos($DATA['additionalGroups'], $group) == '0')) && ($DATA['ID_MEMBER']))
      {  $output[$found] = $count;   
         $found++;
      }
   
      $count++;   
   }
   
   mysql_close($con);
   
   return ($output);
}

// Events: ID_BOARD = 4
// League News: ID_BOARD = 8
// Turkiball News: ID_BOARD = 9
// Other News: ID_BOARD = 10
// All of the Above: ID_BOARD = 0
// Returns an array of the ID_MSG for each thread with the given ID_BOARD in the smf_messages table
// The oldest will have a key of 0, the newest will have the highest number
function getposts($id)
{
   global $smfserver, $smfusername, $smfpassword, $smfdb;

   $rows = getrows('smf_messages');
   // The plus three is because there are some skipped ID_MSG's, so it wasn't looking at the highest numbers
   $rows = $rows + 3;

   $con = mysql_connect($smfserver, $smfusername, $smfpassword);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db($smfdb);
   
   $count = 0;
   $found = 0;
   $output = array(0 => 'false');
   while ($count <= $rows)
   {
      $QUERY = mysql_query("SELECT * FROM smf_messages WHERE ID_MSG = $count");
      $DATA = mysql_fetch_array($QUERY);
    
      // So... that if statement means if we're at the id we want, or, if $id is 0 and we're at any news post at all.  AND we're looking at a real post with an ID_MSG. Got it?
      if ((($DATA['ID_BOARD'] == $id) || (($id == 0) && (($DATA['ID_BOARD'] == 4) || ($DATA['ID_BOARD'] == 8) || ($DATA['ID_BOARD'] == 9) || ($DATA['ID_BOARD'] == 10 )))) && ($DATA['ID_MSG']))
      {  
         // Keeps out all of the replies!  Only threads themselves.
         if (!strpos(('indexrestopper' . $DATA['subject']), 'Re:'))
         {  $output[$found] = $DATA['ID_MSG'];   
            $found++;
         }
      }
   
      $count++;   
   }

   mysql_close($con);
   
   return ($output);
}

// Returns the number of replies to a thread given its ID_TOPIC
function getreplies($id)
{
   global $smfserver, $smfusername, $smfpassword, $smfdb;

   $rows = getrows('smf_messages');
   // The plus three is because there are some skipped ID_MSG's, so it wasn't looking at the highest numbers
   $rows = $rows + 3;

   $con = mysql_connect($smfserver, $smfusername, $smfpassword);
   if (!$con)
      die('Could not connect: ' . mysql_error());
      
   mysql_select_db($smfdb);
   
   $count = 0;
   $found = 0;
   while ($count <= $rows)
   {
      $QUERY = mysql_query("SELECT * FROM smf_messages WHERE ID_MSG = $count");
      $DATA = mysql_fetch_array($QUERY);
    
      if (($DATA['ID_TOPIC'] == $id) && ($DATA['ID_MSG']))   
         $found++;
   
      $count++;   
   }
   
   mysql_close($con);
   
   // Because the algorithm above counted the thread itself, and we need only replies
   $found--;

   return ($found);
}

// Returns the number of rows in the given table
function getrows ($where)
{
   global $smfserver, $smfusername, $smfpassword, $smfdb;

   $con = mysql_connect($smfserver, $smfusername, $smfpassword);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db("db1064984_turkiball_smf");
      
   $QUERY = mysql_query("SELECT * FROM $where");   
   $rows = 0;
   $rows = mysql_num_rows($QUERY);

   mysql_close($con);
   
   return ($rows);
}

// Returns the number of rows in the given table
function getrowsturk ($where)
{
   global $server, $username, $password, $db;

   $con = mysql_connect($server, $username, $password);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db("db1064984_turkiball");
      
   $QUERY = mysql_query("SELECT * FROM $where");   
   $rows = 0;
   $rows = mysql_num_rows($QUERY);

   mysql_close($con);
   
   return ($rows);
}

// SMF API function!
// Format a time to make it look purdy.
function smf_formatTime($logTime)
{
	global $smf_user_info, $smf_settings;

	// Offset the time - but we can't have a negative date!
	$time = max($logTime * 3600, 0);

	// Format some in caps, and then any other characters..
	return strftime(strtr(!empty($smf_user_info['timeFormat']) ? $smf_user_info['timeFormat'] : $smf_settings['time_format'], array('%a' => ucwords(strftime('%a', $time)), '%A' => ucwords(strftime('%A', $time)), '%b' => ucwords(strftime('%b', $time)), '%B' => ucwords(strftime('%B', $time)))), $time);
}
      
function getname ($filename)																						// Returns the filename, minus any directory stuff and minus the extension
{
   $pos = strlen($filename);
      
   $pos = $pos - 4;																					// Get past .php
   $end = $pos;
      
   while (substr($filename, $pos, 1) != "/")
   {  $pos--;
   }
   $pos++;																								// Jump back on other side of the slash
      
   $filename = substr($filename, $pos, ($end - $pos));
      
   return ($filename); 
}           

function removehtml($text)																																// Removes all html tags from the input
{																																								// Used for the newsbar, where we don't want big headings, etc.
   $text = "&nbsp;" . $text;																			// Prevents the whole html at first character returning a 0 problem.   
   $gow = 1;
   while ($gow)
   {
      $gof = 1;   
      $here = strpos($text, "<");
      if (!$here)
      {  $gow = 0;
         $gof = 0;
      }
      for ($i = $here; (($gof) && ($i < strlen($text))); $i++)
      {
         if (substr($text, $i, 1) == '>')
         {
            $text = substr($text, 0, $here) . substr($text, ($i + 1), strlen($text));
            $gof = 0;
         }
         else
         {  $gof = 1;
         }
      }
   }
   return($text);
}

function echoContent($filename)
{
   global $server, $username, $password, $db;

   $con = mysql_connect($server, $username, $password);
   if (!$con)
   {
      die('Could not connect: ' . mysql_error());
   }

   mysql_select_db($db);

   $QUERY = mysql_query("SELECT * FROM Content WHERE Address = '$filename'");

   $DATA = mysql_fetch_array($QUERY);
   echo $DATA['Content'] . "\n\n";

   mysql_close($con);
}

// Returns 1 if $param exists in the given $column in the given $table, 0 otherwise
// Turkiball db only
function doesItExist($table, $column, $param)
{
   global $server, $username, $password, $db;

   $con = mysql_connect($server, $username, $password);
   if (!$con)
      die('Could not connect: ' . mysql_error());

   mysql_select_db($db);

   $QUERY = mysql_query("SELECT * FROM $table WHERE $column = '$param'");
   $DATA = mysql_fetch_array($QUERY);
   
   mysql_close($con);   
   
   if (!$DATA)
      return 0;

   return 1;
}

// Given a post of $ID_MSG, returns next newest post of given $ID_BOARD
// As in the getposts fn, if $ID_BOARD is 0, all news types will be returned
function getNext($ID_MSG, $ID_BOARD)
{
   $choices = getposts($ID_BOARD);

   $count = 0;
   while ($choices[$count] != $ID_MSG)
      $count++;

   // Will return 0 if no next exists
   return $choices[$count];

}









?>