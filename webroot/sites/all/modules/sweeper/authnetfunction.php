<?

// Before working with this sample code, please be sure to read the accompanying Readme.txt file.
// It contains important information regarding the appropriate use of and conditions for this
// sample code. Also, please pay particular attention to the comments included in each individual
// code file, as they will assist you in the unique and correct implementation of this code on
// your specific platform.
//
// Copyright 2007 Authorize.Net Corp.


//Function to send XML request via curl
function send_request_via_curl($host,$path,$content)
{
   $posturl = "https://" . $host . $path;
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $posturl);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
   curl_setopt($ch, CURLOPT_HEADER, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   $response = curl_exec($ch);
   return $response;
}
	
//Function to parse Authorize.net response
function parse_return($content)
{
   $refId = substring_between($content,'<refId>','</refId>');
   $resultCode = substring_between($content,'<resultCode>','</resultCode>');
   $code = substring_between($content,'<code>','</code>');
   $text = substring_between($content,'<text>','</text>');
   $subscriptionId = substring_between($content,'<subscriptionId>','</subscriptionId>');
   return array ($refId, $resultCode, $code, $text, $subscriptionId);
}

//Helper function for parsing response
function substring_between($haystack,$start,$end) 
{
   if (strpos($haystack,$start) === false || strpos($haystack,$end) === false) 
   {
      return false;
   } 
   else 
   {
      $start_position = strpos($haystack,$start)+strlen($start);
      $end_position = strpos($haystack,$end);
      return substr($haystack,$start_position,$end_position-$start_position);
   }
}

?>
