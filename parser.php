<?php
function parseLog($log) {
 $handle = fopen($log, "r");

 $uid = 0;
 if ($handle) {

  while (!feof($handle)) {
   $buffer = fgets($handle, 4096);

   unset($match);

   if (preg_match("/^Updated,(.+)/", $buffer, $match)) {
	$status['updated'] = $match[1];
   }

   if (preg_match("/^(.+),(\d+\.\d+\.\d+\.\d+\:\d+),(\d+),(\d+),(.+)$/", $buffer, $match)) {
	if ($match[1] <> "Common Name") {
	 $cn = $match[1];

	 $userlookup[$match[2]] = $uid;
	 $status['users'][$uid]['CommonName'] = $match[1];
	 $status['users'][$uid]['RealAddress'] = $match[2];
	 $status['users'][$uid]['BytesReceived'] = sizeformat($match[3]);
	 $status['users'][$uid]['BytesSent'] = sizeformat($match[4]);
	 $status['users'][$uid]['Since'] = $match[5];
	 $uid++;
	}
   }


   if (preg_match("/^(\d+\.\d+\.\d+\.\d+),(.+),(\d+\.\d+\.\d+\.\d+\:\d+),(.+)$/", $buffer, $match)) {
	if ($match[1] <> "Virtual Address") {
	 $address = $match[3];

	 $uid = $userlookup[$address];

	 $status['users'][$uid]['VirtualAddress'] = $match[1];
	 $status['users'][$uid]['LastRef'] = $match[4];
	}
   }

  }

  fclose($handle);

  return ($status);
 }
}

function sizeformat($bytesize) {
 $i = 0;
 while (abs($bytesize) >= 1024) {
  $bytesize = $bytesize / 1024;
  $i++;
  if ($i == 4) break;
 }

 $units = array("Bytes", "KB", "MB", "GB", "TB");
 $newsize = round($bytesize, 2);
 return ("$newsize $units[$i]");
}

