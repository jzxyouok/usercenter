<!DOCTYPE html>
<html>
<head>
<title>城市服务</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />
<meta charset="utf-8" />
<style type="text/css">
    html, body { color:#222; font-family:Microsoft YaHei, Helvitica, Verdana, Tohoma, Arial, san-serif; margin:0; padding: 0; text-decoration: none; }
    img { border:0; }
    ul { list-style: none outside none; margin:0; padding: 0; }
    body {
        background-color:#eee; 
    }
    body .mainmenu:after { clear: both; content: " "; display: block; }

    body .mainmenu li{ 
        float:left;
        margin-left: 2.5%;
        margin-top: 2.5%;
        width: 30%;  
        border-radius:3px; 
        overflow:hidden;
    }

    body .mainmenu li a{ display:block;  color:#FFF;   text-align:center }
    body .mainmenu li a b{ 
        display:block; height:80px;
    }
    body .mainmenu li a img{ 
        margin: 15px auto 15px;
        width: 50px;
        height: 50px;
    }

    body .mainmenu li a span{ display:block; height:30px; line-height:30px;background-color:#FFF; color: #999; font-size:14px; }

    body .mainmenu li:nth-child(8n+1) {background-color:#36A1DB}
    body .mainmenu li:nth-child(8n+2) {background-color:#678ce1}
    body .mainmenu li:nth-child(8n+3) {background-color:#8c67df}
    body .mainmenu li:nth-child(8n+4) {background-color:#84d018}
    body .mainmenu li:nth-child(8n+5) {background-color:#14c760}
    body .mainmenu li:nth-child(8n+6) {background-color:#f3b613}
    body .mainmenu li:nth-child(8n+7) {background-color:#ff8a4a}
    body .mainmenu li:nth-child(8n+8) {background-color:#fc5366}
</style>
</head>

<body>
    <ul class="mainmenu">

        <?php if(!empty($list)){foreach($list as $k=>$item){ ?>
            <li><a href="<?php echo $item['url'] ?>"  target="_blank"><b><?php if($item['icon']){ ?><img height="50" src="<?php echo Tool::show_img($item['icon']) ?>"><?php } ?></b><span><?php echo $item['name'] ?></span></a></li>
        <?php }} ?>
        <?php if(!empty($data)){foreach($data as $k=>$item){ ?>
        <?php }} ?>

    </ul>
</body>
</html>