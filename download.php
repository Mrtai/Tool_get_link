<?php 
//The resource that we want to download.

	$fileUrl = 'https://static.hinhcuatui.net/images/icon_bg.png';
	check_link($fileUrl);
	
	//The path & filename to save to.
	$saveTo = 'logo.png';

	//Open file handler.
	$fp = fopen($saveTo, 'w+');

	//If $fp is FALSE, something went wrong.
	if($fp === false){
	    throw new Exception('Could not open: ' . $saveTo);
	}

	//Create a cURL handle.
	$ch = curl_init($fileUrl);

	//Pass our file handle to cURL.
	curl_setopt($ch, CURLOPT_FILE, $fp);

	//Timeout if the file doesn't download after 20 seconds.
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);

	//Execute the request.
	$test = curl_exec($ch);

    if($test){
    	echo "thanh conh";
    	$k = true;
    }
    else{ //echo "that bai";
		if (strlen(strstr($url, "https://")) > 0) {
    			$url = str_replace("https://", "http://", $url);
    			
  			}
  			if (strlen(strstr($url, "http://")) > 0) {
    			$url = str_replace("http://", "https://", $url);
    			
  			}
  			echo "link lỗi";
  			return false;
    }

	//If there was an error, throw an Exception
	if(curl_errno($ch)){
	    throw new Exception(curl_error($ch));
	}

	//Get the HTTP status code.
	$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	//Close the cURL handler.
	curl_close($ch);

	if($statusCode == 200){
	    echo 'Downloaded!';
	} else{
	    echo "Status Code: " . $statusCode;
	}
 ?>