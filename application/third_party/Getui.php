<?php
/**
 *
 * Getui.php
 * @author  : Skiychan <dev@skiy.net>
 * @link    : http://www.skiy.net
 * @created : 5/4/16
 * @modified:
 * @version : 0.0.1
 */


require( dirname(__FILE__) . '/Getui/IGt.Push.php');

class Getui {
  

    public function __construct() {}

    //打开链接  
    function IGtLinkTemplateDemo($title,$content,$linkUrl){
        $template =  new IGtLinkTemplate();
        $template ->set_appId(APPID);                  //应用appid
        $template ->set_appkey(APPKEY);                //应用appkey
        $template ->set_title($title);       //通知栏标题
        $template ->set_text($content);        //通知栏内容
        $template->set_logo("");                       //通知栏logo
        $template->set_logoURL("");                    //通知栏logo链接
        $template ->set_isRing(true);                  //是否响铃
        $template ->set_isVibrate(true);               //是否震动
        $template ->set_isClearable(true);             //通知栏是否可清除
        $template ->set_url($linkUrl); //打开连接地址
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
        return $template;
    }
    //打开应用
    function IGtNotificationTemplateDemo($title,$content){
        $template =  new IGtNotificationTemplate();
        $template->set_appId(APPID);                   //应用appid
        $template->set_appkey(APPKEY);                 //应用appkey
        $template->set_transmissionType(1);            //透传消息类型
        $template->set_transmissionContent("");//透传内容
        $template->set_title($title);                  //通知栏标题
        $template->set_text($content);     //通知栏内容
        $template->set_logo("");                       //通知栏logo
        $template->set_logoURL("");                    //通知栏logo链接
        $template->set_isRing(true);                   //是否响铃
        $template->set_isVibrate(true);                //是否震动
        $template->set_isClearable(true);              //通知栏是否可清除

        return $template;
    }
    //下载应用
    function IGtNotyPopLoadTemplateDemo($title,$content,$appname,$apptitle,$appinfo,$applink){
        $template =  new IGtNotyPopLoadTemplate();
        $template ->set_appId(APPID);   //应用appid
        $template ->set_appkey(APPKEY); //应用appkey
        //通知栏
        $template ->set_notyTitle($title);                 //通知栏标题
        $template ->set_notyContent($content); //通知栏内容
        $template ->set_notyIcon("");                      //通知栏logo
        $template ->set_isBelled(true);                    //是否响铃
        $template ->set_isVibrationed(true);               //是否震动
        $template ->set_isCleared(true);                   //通知栏是否可清除
        //弹框
        $template ->set_popTitle($appname);   //弹框标题
        $template ->set_popContent($appinfo); //弹框内容
        $template ->set_popImage("");           //弹框图片
        $template ->set_popButton1("下载");     //左键
        $template ->set_popButton2("取消");     //右键
        //下载
        $template ->set_loadIcon("");           //弹框图片
        $template ->set_loadTitle($apptitle);
        $template ->set_loadUrl($applink);
        $template ->set_isAutoInstall(false);
        $template ->set_isActived(true);
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
        return $template;
    }

    // 透传消息
    function IGtTransmissionTemplateDemo($content){
        $template =  new IGtTransmissionTemplate();
        //应用appid
        $template->set_appId(APPID);
        //应用appkey
        $template->set_appkey(APPKEY);
        //透传消息类型
        $template->set_transmissionType(2);
        //透传内容
        $template->set_transmissionContent($content);
        //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
        //这是老方法，新方法参见iOS模板说明(PHP)*/
        //$template->set_pushInfo("actionLocKey","badge","message",
        //"sound","payload","locKey","locArgs","launchImage");
        //          APN高级推送
        return $template;
    }


    function IosIGtTransmissionTemplateDemo($content){
        $template =  new IGtTransmissionTemplate();
        $template->set_appId(APPID);//应用appid
        $template->set_appkey(APPKEY);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent($content);//透传内容
        //    APN高级推送
        $apn = new IGtAPNPayload();
        $alertmsg=new DictionaryAlertMsg();
        $cont = json_decode($content,true);
        $alertmsg->body=$cont['title'];
        //   iOS8.2 支持
        $alertmsg->title=$cont['title'];
       

        $apn->alertMsg=$alertmsg;
        $apn->badge=1;
        $apn->sound="";
        $apn->add_customMsg("payload",$content);
        // $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);

        return $template;
    }

}