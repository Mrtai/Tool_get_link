<?php
    if(!file_exists('E:/xampp/htdocs/'.$_POST["name_web"]))
        mkdir('E:/xampp/htdocs/'.$_POST["name_web"],0700);
    if(!file_exists('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_font"])){
        mkdir('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_font"]);
    }
    if(!file_exists('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_images"])){
        mkdir('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_images"]);
        $path_images= 'E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_images"];
    }
    //$type =$_POST["type_get"] ;
    if(!file_exists('E:/xampp/htdocs/'.$_POST["name_web"].'/index.php')){
        $fp = @fopen('E:/xampp/htdocs/'.$_POST["name_web"].'/index.php', "w+");
        if (!$fp) {
                echo 'Mở file không thành công';
            }
            else
            {
                $data = file_get_contents($_POST["url_web"]);
                fwrite($fp, $data);
                 fclose($fp);
            }
    }
   // echo "Loại : ".$type;
    function url_css($url,$n){//tìm n lần vd:https://s.vnecdn.net/vnexpress/restruct/c/v79/v2/pc/general.css
        echo 'đọc file css'.'= '.$url."<br>";
        $path_fonts= 'E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_font"];
        $path_images= 'E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_images"];
        $urlArray = array();
       ///khuc nay tuong tu file_get_contents  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        //Định dạng regex
        $regex= "/url(.+?)[)]/";
        preg_match_all($regex,$result,$parts);
        $links=$parts[1];
        echo count($links)."<br>";
         if(count($links) == 0 && $n < 5){
            $n++;
            url_css($url,$n);//đệ quy tìm lại 5 lần
        }
        foreach($links as $link){
            array_push($urlArray, $link);
        }
        curl_close($ch);

        foreach($urlArray as $value){
            echo "value = ".$value."<br>";

            $e=explode('/',$value);

             //echo "value 55 = ".$value."<br>";
             foreach ($e as $v) {
                 if(strcmp("fonts",$v) == 0 || strcmp("font",$v)== 0 ){
                    $type = "fonts";
                    break;
                 }
                 if(strcmp("images",$v)== 0 ||strcmp("image",$v)== 0  ){
                     $type = "images";
                     break;
                 }
             }
             //Kiểm tra trong link có dấu nháy
             if(strlen(strstr($value, '"')) > 0 || strlen(strstr($value, "'")) > 0){
                $l1 = 2;
            }
            else
                $l1 = 1;
            //cuối
            if(strlen(strstr($value, "?")) > 0){

                $t= explode('?',$value);
                $file_url = $t[0];
                $l= strlen($t[0]);
                $l2= $l-1;
            }
            else if(strlen(strstr($value, '"')) > 0 || strlen(strstr($value, "'")) > 0){
                $file_url = $value;
                $l = strlen($value);
                $l2= $l-3;
            }
            else{
                $file_url = $value;
                $l = strlen($value);
                $l2= $l-1;
            }
            
           
            //echo  $file_url;
           echo "type = ".$type."<br>";
            if(strcmp("fonts",$type) == 0){ 
                $data =(substr($file_url,$l1,$l2));
                echo "-------------------".$data."link font <br>";
                Dowload($data,$path_fonts);
            }
            else if(strcmp("images",$type) == 0){
                $data =(substr($file_url,$l1,$l2));
                echo "vao";
                echo $data."<br>";
                Dowload($data,$path_images);
            }
        }
    }
    function Dowload($fileUrl,$filepath){

        //The resource that we want to download.

        //The path & filename to save to.
        echo $fileUrl."link download <br>";
        $saveTo = $filepath."/".basename($fileUrl);
        echo $saveTo." sve <br>";
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
                echo "thanh cong";
                $k = true;
        }
        else{ //echo "that bai";
            if (strlen(strstr($fileUrl, "https://")) > 0) {
                $fileUrl = str_replace("https://", "http://", $fileUrl);
                $ch = curl_init($fileUrl);

                //Pass our file handle to cURL.
                curl_setopt($ch, CURLOPT_FILE, $fp);

                //Timeout if the file doesn't download after 20 seconds.
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);

                //Execute the request.
                $test = curl_exec($ch);
                if($test){
                    $k = true;
                }
                else
                    $k = false;
            }
            else if (strlen(strstr($fileUrl, "http://")) > 0) {
                $fileUrl = str_replace("http://", "https://", $fileUrl);
                $ch = curl_init($fileUrl);

                //Pass our file handle to cURL.
                curl_setopt($ch, CURLOPT_FILE, $fp);

                //Timeout if the file doesn't download after 20 seconds.
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);

                //Execute the request.
                $test = curl_exec($ch);
                if($test){
                    $k = true;
                }
                else
                    $k = false;
            }
            else
            {
                //$fileUrl = $_POST["url_web"].'/'.$fileUrl;
                echo "vào them tên miền <br>";
                $fileUrl = str_replace("../", $_POST["url_web"].'/', $fileUrl);
                $ch = curl_init($fileUrl);

                //Pass our file handle to cURL.
                curl_setopt($ch, CURLOPT_FILE, $fp);

                //Timeout if the file doesn't download after 20 seconds.
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);

                //Execute the request.
                $test = curl_exec($ch);
                if($test){
                    $k = true;
                }
                else
                    $k = false;
            }

        }
        if($k){
             //If there was an error, throw an Exception
             if(curl_errno($ch)){
                throw new Exception(curl_error($ch));
                return;
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
        }
    }
    function urlLooper($url,$type){

        $urlArray = array();
       ///khuc nay tuong tu file_get_contents  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if(strcmp($type,"CSS")==0){
            $regex='|<link rel="stylesheet" type="text/css" .*?href="(.*?)"|';
            if(!file_exists('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_css"]))
                mkdir('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_css"]);
        }
        else{
            $regex='|<script src=.*?"(.*?)"|';
            if(!file_exists('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_js"]))
                mkdir('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_js"]);
        }
       	//echo $regex;
         // $regex='|<a.*?href="(.*?)"|';
        preg_match_all($regex,$result,$parts);
        $links=$parts[1];
		echo count($links)."<br>";
        foreach($links as $link){
            array_push($urlArray, $link);
        }
        curl_close($ch);
        foreach($urlArray as $value){
            if (strlen(strstr($value, "https://")) < 0){
                $value = $url.'/'.$value;
            } 
            
			echo '<a href="'.$value.'" target="_blank" >'.$value.'</a>'."<br>";
            //  $e=explode('/',$value);
            // $namefile = end($e);
            $namefile = basename($value);
            $is_exist= false;
            if(strcmp($type,"CSS")==0 && !file_exists('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_css"].'/'.$namefile)){
                $fp = @fopen('E:/xampp/htdocs/'.$_POST["name_web"].'/css/'.$namefile, "w+");
                $is_exist = true;
            }
            else if(strcmp($type,"JS")==0 &&!file_exists('E:/xampp/htdocs/'.$_POST["name_web"].'/'.$_POST["name_js"].'/'.$namefile)){
                $fp = @fopen('E:/xampp/htdocs/'.$_POST["name_web"].'/js/'.$namefile, "w+");
                $is_exist = true;
            }
              
            // Kiểm tra file mở thành công không
            if($is_exist){
                if (!$fp) {
                    echo 'Mở file không thành công';
                }
                else 
                {
                    if(strlen(strstr($value, "https://")) > 0 || strlen(strstr($value, "http://"))> 0)
                        $data = file_get_contents($value);
                    else
                    {
                        $value = $_POST["url_web"]."".$value;
                        echo "link css  =".$value."<br>";
                        $data = file_get_contents($value);
                    }
                    
                    if(strcmp($type,"CSS")==0 )
                        url_css($value,0);
                    fwrite($fp, $data);
                    fclose($fp);
                }
            }
            
        }
    }
$url = $_POST["url_web"];
urlLooper($url,"CSS");
urlLooper($url,"JS");
//url_css("http://gialong.com/css/style1.css");
//Dowload("http://static.hinhcuatui.net/images/icon_add_images.jpg","E:/xampp/htdocs/vidu5/images");
//url_css("http://static.hinhcuatui.net/css/font-awesome-4.6.3/css/font-awesome.min.css");


?>
