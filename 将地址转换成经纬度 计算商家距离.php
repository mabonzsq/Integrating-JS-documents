    //距离查询
       $addrid = D('Useraddr')->find($addr_id);
       $oaddr = $addrid['addr'];    //用户地址
       $shop = D('Eleorder')->where(array('order_id' => $order_id))->select();
       $shopid = $shop[0]['shop_id'];   // 商家id
       $ele = D('Ele')->find($shopid);
       $slat = $ele['lat'];
       $slng = $ele['lng'];
    header("Content-type:text/html;charset=utf-8");  
    // 百度地理编码服务  
    $ak="TgHGH8L6u3PMQMGwMKmWsgzAFHvk3WDy";  
    $output="json";  
    $callback="showLocation";  
    $address= $oaddr;
    $url="https://api.map.baidu.com/geocoder/v2/?callback=renderOption&output=json&address=$address&ak=TgHGH8L6u3PMQMGwMKmWsgzAFHvk3WDy";
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        $result = curl_exec($ch);  
        curl_close($ch);  
      //  dump($result);

        preg_match('/.*?\((.*?)\)/',$result,$data);  
        $res=json_decode($data[1],true);
   // dump($res);
    // echo "<pre>";  
    // print_r($res); 
    if($res['status']==0){  
        // 经纬度  
        $olng=$res['result']['location']['lng'];  
        $olat=$res['result']['location']['lat'];  
        // echo $olng;
        // echo $olat;
      
    }else{  
        exit("请填写正确的位置信息！");  
    }  
     $juli = getDistance($olat, $olng, $slat, $slng);