<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"D:\phpstudy\PHPTutorial\WWW\shequshop\public/../application/admin\view\report\index.html";i:1562750907;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="/easyweb/assets/libs/jquery/jquery-3.2.1.min.js"></script>
  <title>Title</title>
</head>
<body>
<div>1</div>
<script>


  ws = new WebSocket("wss://sq.zxrhyc.cn:2346");
  ws.onopen = function() {
    alert("连接成功")
    ws.send('1:23423');
    alert("给服务端发送一个字符串：sfdasd");
  };

  ws.onmessage = function(e) {
    ss=e.data
    array = ss.split(":");
    if(array[0] == 1){
      console.log(e.data)
      alert("收到服务端的消息：" + array[1]);
    }

  };
</script>
</body>
</html>