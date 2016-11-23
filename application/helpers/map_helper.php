<?php

function GetLatitude($str,$para){
    $url="http://restapi.amap.com/v3/geocode/geo?address=".$str."&output=json&key=".$para;
    $content = file_get_contents($url);
    $arr = json_decode($content,true);
    $data = array(
        "err_code" => $arr['infocode'],//错误编码，如出现错误可去高德地图查询原因
        "address" => $arr['geocodes']['0']['formatted_address'],
        "province" => $arr['geocodes']['0']['province'],
        "city" => $arr['geocodes']['0']['city'],
        "district" => $arr['geocodes']['0']['district'],
        "township" => $arr['geocodes']['0']['township'],
        "street" => $arr['geocodes']['0']['street'],
        "citycode" => $arr['geocodes']['0']['citycode'],
        "number" => $arr['geocodes']['0']['number'],
        "adcode" => $arr['geocodes']['0']['adcode'],
        "location" => $arr['geocodes']['0']['location'],
        "level" => $arr['geocodes']['0']['level']   //数据匹配的层级
    );
    //var_dump($data);
    return $data;
    //测试OK
}
/*高德地图根据经纬度查地点，范围radius=500*/
function GetRealgeo($str,$para){
    $url="http://restapi.amap.com/v3/geocode/regeo?output=json&location=".$str."&key=".$para."&radius=500&extensions=base";

    $content = file_get_contents($url);
    $arr = json_decode($content,true);

    $data = array(
        "err_code" => $arr['infocode'], //错误编码，如出现错误可去高德地图查询原因
        "address" => $arr['regeocode']['formatted_address'],
        "country" => $arr['regeocode']['addressComponent']['country'],
        "province" => $arr['regeocode']['addressComponent']['province'],
        "city" => $arr['regeocode']['addressComponent']['city'],
        "district" => $arr['regeocode']['addressComponent']['district'],
        "township" => $arr['regeocode']['addressComponent']['township'],
        "citycode" => $arr['regeocode']['addressComponent']['citycode'],
        "adcode" => $arr['regeocode']['addressComponent']['adcode']

    );
    return $data;
    //测试OK
}


/*高德路径规划
TYPE说明：1、步行；2、公交；3、驾车；4、距离测量
一般情况下使用者无须传入$type=4的参数，对于每一个类型的返回数据都包含路径的距离，可直接调用
*/

function GetRouting($from,$to,$para,$type){
    $str = "origin=".$from."&destination=".$to."&key=".$para."&output=json";
    $str2 = "origins=".$from."&destination=".$to."&key=".$para."&output=json";
    if(isset($type)){
        switch($type){
            case 1:
                //步行路线规划,测试OK
                $url = "http://restapi.amap.com/v3/direction/walking?".$str;
                $content = file_get_contents($url);
                $arr = json_decode($content,true);

                /*步行距离和时间,由于步行只有一种方式故不再用接口请求步行的距离和时间
                $url2 = "http://restapi.amap.com/v3/distance?".$str2."&type=1";
                $content2 = file_get_contents($url2);
                $arr2 = json_decode($content2,true);
*/
                $steps = array();
                foreach($arr as $list=>$value){
                    if(is_array($value)){
                        foreach($value as $newlist=>$v){
                            $steps[] = $v;
                        }

                    }

                }
                $temp = array("err_code" =>$arr['infocode'],
                    "distance" =>$steps['2']['0']['distance'],
                    "duration" =>$steps['2']['0']['duration']
                );
                $data = $temp+$steps;

                break;
            case 2:
                //公交路线规划，测试ok
                $str1 = GetRealgeo($from,$para);  //根据经纬度查询城市编码
                $citycode = $str1['citycode'];
                $url = "http://restapi.amap.com/v3/direction/transit/integrated?".$str."&city=".$citycode;
                $content = file_get_contents($url);
                $arr = json_decode($content,true);
                //公交距离和时间
                $url2 = "http://restapi.amap.com/v3/distance?".$str2."&type=2";
                $content2 = file_get_contents($url2);
                $arr2 = json_decode($content2,true);

                $data = array();
                break;
            case 3:
                //驾车线路规划，测试ok
                $url = "http://restapi.amap.com/v3/direction/driving?".$str;
                $content = file_get_contents($url);
                $arr = json_decode($content,true);
                //开车距离和时间
                $url2 = "http://restapi.amap.com/v3/distance?".$str2."&type=1";
                $content2 = file_get_contents($url2);
                $arr2 = json_decode($content2,true);

                $data = array();
                break;
            case 4:
                //测量起点与终点的直线距离与预计时间
                $url2 = "http://restapi.amap.com/v3/distance?origins=".$from."&destination=".$to."&key=".$para."&output=json&type=0";
                $content2 = file_get_contents($url2);
                $arr2 = json_decode($content2,true);
                $data = array(
                    "err_code2" =>$arr2['infocode'],
                    "distance" =>$arr2['results']['0']['distance'], //距离 单位：米
                    "duration" =>$arr2['results']['0']['duration']  //预计耗时	 单位：秒
                );
                break;
        }
    }

    return $data;

}


?>