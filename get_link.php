<?php
    // $subject = 'Hello "Everybody", welcome to "freetuts.net"';
    // preg_match('/"(.+?)"/', $subject, $matches);
    // echo '<pre>';
    // print_r($matches);
    // echo '</pre>';
    $s = '(https://static.hinhcuatui.net/images/icon_bg.png';
    echo substr($s,1,strlen($s) - 1)."<br>";
     $url = 'http://static.hinhcuatui.net/css/layout_style.css';
    function urlLooper($url,$n){
       
        //echo $url;
        $urlArray = array();
       ///khuc nay tuong tu file_get_contents  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        ////////////////////
        //$regex='|<a.*?href="(.*?)"|';
       // $regex="|url.*?('(.*?)')|";
        //$regex="|url('(.*?)')|";
        //$regex="|^url('(.*?)')$|";
        //$regex='|url.*?("(.*?)")|';
        $regex= "/url(.+?)[)]/";
        //$regex='|url.*?("(.*?)")|';
        preg_match_all($regex,$result,$parts);
        //print_r($parts);
        $links=$parts[1];
		echo count($links)."- ".$n."<br>";
        if(count($links) == 0 && $n < 5){
            $n ++;
            urlLooper($url,$n);
        }
       // print_r($parts);
        foreach($links as $link){
            array_push($urlArray, $link);
        }
        curl_close($ch);
        foreach($urlArray as $value){
            echo $value."<br>";
            if(strlen(strstr($value, '"')) > 0 || strlen(strstr($value, "'")) > 0){
                echo "có dấu nháy đôi hoặc đơn <br>";
            }
            else
                echo "không có nháy <br>";
        }
    }
urlLooper($url,0);
?>