<?php

define('HOSTNAME', 'http://localhost/bpesa/');

session_start();

CLASS DB_Class {
  var $db;
  //Live site
   public function __construct() {
	  $this->db = mysql_connect ('localhost', 'root', 'dbacess') or die ("Unable to connect to Database Server");
    mysql_select_db ('bpesa', $this->db) or die ("Could not select database!");
  }
 
  public function query($sql) {
    $result = mysql_query ($sql, $this->db) or die ("Invalid query: " . mysql_error());
    return $result;
  }

  public function fetch($sql) {
     $data = array();
     $result = $this->query($sql);

     while($row = MYSQL_FETCH_ASSOC($result)) {
          $data[] = $row;
     }
          return $data;
   }

   public function getone($sql) {
   $result = $this->query($sql);

    if(MYSQL_NUM_ROWS($result) == 0)
      $value = false;
    else
      $value = MYSQL_RESULT($result, 0);
      return $value;
    }    
}
//Remove MS word formatting
function strip_word_html($courseDescription, $allowed_tags = '<b><i><sup><sub><em><strong><u><br><br /><p></p>') { 
  mb_regex_encoding('UTF-8'); 
  //replace MS special characters first 
  $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u'); 
  $replace = array('\'', '\'', '"', '"', '-'); 
  $courseDescription = preg_replace($search, $replace, $courseDescription); 
  //make sure _all_ html entities are converted to the plain ascii equivalents - it appears 
  //in some MS headers, some html entities are encoded and some aren't 
  $courseDescription = html_entity_decode($courseDescription, ENT_QUOTES, 'UTF-8'); 
  //try to strip out any C style comments first, since these, embedded in html comments, seem to 
  //prevent strip_tags from removing html comments (MS Word introduced combination) 
  if(mb_stripos($courseDescription, '/*') !== FALSE){ 
      $courseDescription = mb_eregi_replace('#/\*.*?\*/#s', '', $courseDescription, 'm'); 
  } 
  //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be 
  //'<1' becomes '< 1'(note: somewhat application specific) 
  $courseDescription = preg_replace(array('/<([0-9]+)/'), array('< $1'), $courseDescription); 
  $courseDescription = strip_tags($courseDescription, $allowed_tags); 
  //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one 
  $courseDescription = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $courseDescription); 
  //strip out inline css and simplify style tags 
  $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu'); 
  $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>'); 
  $courseDescription = preg_replace($search, $replace, $courseDescription); 
  //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears 
  //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains 
  //some MS Style Definitions - this last bit gets rid of any leftover comments */ 
  $num_matches = preg_match_all("/\<!--/u", $courseDescription, $matches); 
  if($num_matches){ 
        $courseDescription = preg_replace('/\<!--(.)*--\>/isu', '', $courseDescription); 
  }
  //$courseDescription = strip_tags($courseDescription);
  return $courseDescription; 
} 