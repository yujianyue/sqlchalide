<?php
//禁止将本系统用于非法目的!
//请保留作者信息:yujianyue, 15058593138@qq.com 可反馈错误不提供指导
//沟通请注明:查立得PHP+mysql通用已有数据表查询系统2024版19查搜模式合1 V2.0

//error_reporting(0); //关闭报错：去行首双斜杠
//header('Content-type:text/html;charset = utf-8');//如乱码：去行首双斜杠
/*
查立得PHP+mysql通用已有数据表查询系统2024版19查搜模式合1 V2.0
代码更新请关注公众号:查立得 或百度:查立得 或gitee:https://gitee.com/chalide/chalide
一般网站站长/程序员/计算机熟练者自用,快速用于已有数据表的查询或搜索。
或者自己会数据库导入mysql的用户一次性导入后使用本系统；或计算机爱好者学习。
单文件不压缩不到20KB实现19查搜模式,每个模式均通用Mysql单表(灵活字段和查询条件)。
可以多输入框都数对,一个输入框查多列,选择条件之一查单列,多输入框输过的都符合...
支持等于/包含/开头/结尾/空格分开多关键词。可自定义验证码和网页主色。
支持指定输入框输入提示功能(注意非必要不开启);查询结果指定字段排序。
不保证绝对安全,如果正式用途请自行加入安全代码或开启网络防火墙等。
支持隐藏指定多列;支持查询结果指定字段排序;支持分页与页码设置;支持最大页数限定。
支持字段别名设置;极小页面让你低带宽实现高并发;代码量极小方便二开与安全分析。
推荐环境:宝塔/护卫神/主流虚拟主机 PHP5.4-7.3/mysql5.6 环境
性能优化:查询条件字段索引(不优化则适合30万以内数据查搜);开启opcache缓存
输入提示功能:高频查询不建议开启;非等于输入内容模式 或 万用查分模式不建议开启;
*/

//以下参数：1-6;11-15;21-26;31-34 19模式选一
$de = []; 
$de["ztai"] = "33"; 			//修改查询模式(19模式选一:详情readme.html);0关闭;
$de["isese"] = "4CAF50";			//hex 16进制颜色色号 无#
$de["title"] = "宣平县立女子中学资料搜索系统";	//站点标题
$de["idesc"] = "desc.txt"; 		//说明文字所在文件
$de["itiao"] = "号段";		//查询条件:填字段(列标题);多条件+号隔开 +城市
$de["ihide"] = "id+排名";		//隐藏列:填字段(列标题);多条件+号隔开
$de["tishi"] = "号段";		//查询条件输入框带提示字段;多条件+号隔开
$de["paixu"] = "号段+区号";		//可排序列:填字段(列标题);多条件+号隔开
$de["isyzm"] = "0";			//验证码:是1否0
$de["itips"] = "Y";			//浏览器判断:是Y否N
$de["mpage"] = "10";			//每页显示数量:大于该数字显示分页
$de["xpage"] = "20";			//最大展示页数防止数据全显示
$de["xtips"] = "20";			//提示最大显示数量
$de["copyr"] = "查立得";			//底部文字
$de["copyu"] = "https://chalide.cn/";	//底部链接

$db = []; 
$db["dbhost"] = "localhost";		//数据库地址本地localhost
$db["dbuser"] = "ip_chalide_cn";	//数据库账号,非root权限
$db["dbpass"] = "KhTwyCGTAR4THxRK";	//数据库密码
$db["dbname"] = "ip_chalide_cn";	//数据库名称,一般同dbuser
$db["dbport"] = "3306";		//数据库端口号
$db["dbcode"] = "UTF8";		//数据库编码
$db["biao"] = "phone_location";	//表名称

$du = []; 
//字段和重定义名称保持唯一不重复:一行一组增加字段请自行复制
//$du["na"] = "字段1";		//示范:重定义字段名称:用于英文字段显示为中文别名
//$du["lp"] = "字段2";		//示范:重定义字段名称:用于英文字段显示为中文别名
$du["号段"] = "手机号段";		//重定义字段名称:用于英文字段显示为中文别名

/*------没有把握不要修改后面代码------*/
$zt["0"]="关闭查询";
$zt["1"]="单输入框查多字段等于";
$zt["2"]="单输入框查多字段包含";
$zt["3"]="单输入框查多字段开头";
$zt["4"]="单输入框查多字段结尾";
$zt["5"]="单输入框查多字段空格分开多关键词包含";
$zt["6"]="多输入框查多字段都输对(万用查分)";
$zt["11"]="单输入框多条件选一等于";
$zt["12"]="单输入框多条件选一包含";
$zt["13"]="单输入框多条件选一开头";
$zt["14"]="单输入框多条件选一结尾";
$zt["15"]="单输入框多条件选一多空格分开关键词包含";
$zt["21"]="单输入框查多字段等于2";
$zt["22"]="单输入框查多字段包含2";
$zt["23"]="单输入框查多字段开头2";
$zt["24"]="单输入框查多字段结尾2";
$zt["25"]="单输入框查多字段空格分开多关键词都包含";
$zt["31"]="多输入框查对应字段输过的都等于";
$zt["32"]="多输入框查对应字段输过的都包含";
$zt["33"]="多输入框查对应字段输过的都开头";
$zt["34"]="多输入框查对应字段输过的都结尾";
$zt["36"]="多输入框都输对(不区分大小写)";
$zt["51"]="大文本框批量查询"; //建议条件索引的单条件
foreach ($de as $ti=>$val) $$ti = $val; //调用
if($ztai<1){aw("出错信息:","该查询暂停访问!"); exit();}
//以下一行测试/演示专用 指定网址
if(stristr($_SERVER['HTTP_HOST'],"chalide.cn")) $ztai = (isset($_GET["z"]))?addslashes($_GET["z"]):$ztai;
if($ztai=="5"){ $ztai="25";} //模式5重定义为25
$fu = "<br><button onclick=\"me()\">返回</button>";
session_start();
if(!isset($_SESSION['aiyaha'])) $_SESSION['aiyaha']=date("YmdH").uniqid();
$uid = $_SESSION['aiyaha'];
function sn(){
$usrent = $_SERVER['HTTP_USER_AGENT']; $zt="";
if($usrent==""){
 $zt = "请使用常规浏览器[空UA]";
}elseif(preg_match_all('/(\\\x[a-zA-Z0-9_]{1,4}){2,4}/', $usrent)){
 $zt = "请使用常规浏览器[疑似攻击代码]";
}elseif(preg_match_all('/(spider|bot|crawler|robot)/i', $usrent)){
 $zt = "请使用常规浏览器[疑似蜘蛛爬虫]";
}elseif(preg_match_all('/(curl|requests|robot|python|urllib3|pantest)/i', $usrent)){
//ALittle Dalvik wp_is_mobile Go-http-client等疑
 $zt = "请使用常规浏览器[疑似蜘蛛爬虫]";
}elseif(preg_match_all('/(Chrome|Firefox)/i', $usrent, $isc)){
 $iscv = explode('.', explode($isc[0][0], $usrent)[1])[0];
 if(Trim($iscv,"/") < 50) $zt = "浏览器版本过低,请升级".$isc[1][0]."到较新版本";
}elseif(preg_match_all('/(Gecko|Presto)/i', $usrent)){
 //$zt = "该浏览器已淘汰,推荐chrome浏览器或360等国产浏览器的急速模式";
 $zt = "";
}elseif(preg_match_all('/(MSIE|Trident)/i', $usrent)){
 $zt = "IE浏览器2015年就已淘汰,推荐chrome浏览器或360等国产浏览器的急速模式";
}elseif(preg_match("/\@([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61})?\.)+[a-zA-Z]{2,8}/i", $usrent)){
 $zt = "请使用常规浏览器[邮件UA爬虫]";
}elseif(preg_match_all('/(http|https|ftp)/i', $usrent) && preg_match("/([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61})?\.)+[a-zA-Z]{2,8}/i", $usrent)){
 $zt = "请使用常规浏览器[疑似爬虫(UA带网址)]";
}else{
 $zt = "";
}
  return $zt;
}
function aw($Key,$vals){
$html ="
<meta charset=\"UTF-8\" />
<title>$Key - $vals</title>
<link rel=\"shortcut icon\" href=\"data:image/ico;base64,aWNv\" />
</head>
<style type=\"text/css\" />
*{margin:0;padding:0;text-align:center;}
h1{margin-top:8%;font-size:3.3vw;}
hr{margin:1% 0;}
i{text-align:left;color:gray;font-size:2.2vw;}
</style>
<body><h1>$Key</h1><hr><i>$vals</i></body>";
echo $html;
}
function wo($Key){
$html ="<table cellspacing=\"0\" class=\"table\">\r\n<tbody>";
$html.="<tr><td data-label=\"提示\">$Key</td></tr>";
$html.="</tbody></table>";
echo $html;
}
function ht($ztai){
    return <<<EOT
<style>
.search-box { position: relative; flex: 6;display: flex;}
.rh {  flex: 9;  border: 1px solid #ccc;}
.close{text-decoration:none;float:right;font-size:24px;background-color:red;color:white;}
.close:hover,.close:focus{cursor:pointer;}
.ee {
  position: absolute;
  top: 30px;
  left: 0;
  width: 88vw;
  max-height: 300px;
  overflow-y: auto;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  z-index: 7;
}
.ee ul {  list-style: none;  margin: 0;  padding: 0;}
.ee li {  text-align:left; padding: 5px;  cursor: pointer;}
.ee li:hover {  background-color: #f5f5f5;}
</style>
<script>
var la = document.querySelector('#input');
var ox = document.querySelector('.rh');
let flag = true;  var timer = null; var keyword = '';
la.addEventListener('compositionstart',function(){ flag = false; });
la.addEventListener('compositionend',function(){ flag = true; });
la.addEventListener('input', function(e) {
 var keyword = e.target.value; var id = e.target.id;
  if (timer) { clearTimeout(timer);}
  timer = setTimeout(function() { ph(keyword,id); }, 500);
});
function ph(val,id) {
 if (val && flag ) {
if($('sg'+id)==null) return false;
    var xhr = new XMLHttpRequest();
    var dd="sqlcha"; 
if($("xidx")){ dd = $("xidx").value; }
    var pest = 'l='+id+'&d='+dd+'&k='+val;
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var data = JSON.parse(xhr.responseText); su(data,id);
      }
    };
    xhr.open('POST', '?x=wx&z=$ztai&tt='+Math.random(), true);
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(pest);
  } else {
    fc(id);
  }
}
la.addEventListener('click', function(e) {
  var target = e.target;
  if (target.tagName === 'LI') {
    var id = target.className; //console.log(target);
    $(id).value = target.innerText;
    fc(id); //$("sub").click;
  }
});
function su(data,id) {
  var html = '<span onclick="fc(\'' + id + '\')" class="close">&times;</span>';
  for (var i = 0; i < data.length; i++) {
    html += '<li class='+id+'>' + data[i] + '</li>';
  }
  if(data.length>0){
  $("sg"+id).innerHTML = '<ul>' + html + '</ul>';
  $("sg"+id).style.display = 'block';
  $("sg"+id).style.width = $(id).sc + 'px';
  }
}
function fc(id) {
  $("sg"+id).style.display = 'none';
}
</script>
EOT;
}
function ef($be,$ck,$li){
global $xpage,$mpage,$pages;
  $ji=ceil($ck/$mpage);
if($ji>20){$pgx=$xpage;}else{$pgx=$ji;}
//$ng='<table cellspacing="0" class="table">';
$ng="<tr><td colspan=\"$li\" data-label=\"分页信息\">共<b>{$ji}</b>页/<b>{$ck}</b>条";
  for($ix=0;$ix<$pgx;$ix++){
    $ia=$ix+1;
    if("x".$pages=="x".$ia){
  $ng.="\t\t第<b>$ia</b>页\r\n";
    }else{
  $ng.="\r\n<a href=\"#\" onClick=\"return {$be}('{$ia}');\">$ia</a>\r\n";
    }
  }
  $ng.="</td></tr>\r\n";
  return $ng;
}
$bc= explode("+",$itiao); $kl= explode("+",$ihide); $at= explode("+",$paixu); $ap= explode("+",$tishi); 
$os = (isset($_GET["t"]))?addslashes($_GET["t"]):"";
if($os!=""){
session_start();
$w=44; $h=22;
$code = rand(1000,9999);//随机4数字
$_SESSION['fo'] = $code;//保存验证码到 session 中
header('Content-Type: image/gif');
$im = imagecreate($w, $h);
imagecolorallocate($im, 255, 255, 255);//设置背景色
$text_color = imagecolorallocate($im, 0, 0, 0);//设置字体颜色
imagestring($im, 8, 4, 4, $code, $text_color);
for ($i = 0; $i < 3; $i++) { // 添加干扰线
    $line_color = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
    imageline($im, rand(0, $w), rand(0, $h), rand(0, $w), rand(0, $h), $line_color);
}
for ($i = 0; $i < 30; $i++) { // 添加干扰点
    $pixel_color = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
    imagesetpixel($im, rand(0, $w), rand(0, $h), $pixel_color);
}
imagegif($im);
imagedestroy($im);
exit();
}else{
//header('Content-type:text/html;charset = utf-8');//如乱码：去行首双斜杠
}
$idx = (isset($_GET["x"]))?addslashes($_GET["x"]):"";
if($idx=="wx"){
header("Content-type:application/json");
$keyword = (isset($_POST['k']))?addslashes($_POST['k']):'';
if(mb_strlen($keyword)<2) exit("[\"请输入关键词(2+字)\"]");
 if(stristr("-6-31-32-33-34-35-","-$ztai-")){    //多输入框只查一列
   $lie = (isset($_POST['l']))? Trim($_POST['l']):'X0';
   $st = preg_replace("/[^0-9]/", "", $lie);
   if(isset($bc[$st])){ $uo = $bc[$st]; $lieb = "`$uo`"; }else{ exit("[\"传递参数异常(条件$uo)\"]");}
 }elseif(stristr("-11-12-13-14-15-","-$ztai-")){    //下拉选条件单输入框获取下拉值
   $uo =(isset($_POST['d']))? addslashes($_POST['d']):$bc[0]; $lieb = "`$uo`";
   if(!stristr("+$itiao+","+$uo+")){ exit("[\"传递参数异常(条件$uo)\"]");}
 }elseif(stristr("-1-2-3-4-5-21-22-23-24-25-","-$ztai-")){ //单输入框多条件搜多列()
   $st = $bc; if(count($st)<1){ exit("[\"自动提示字段得是查询条件!\"]"); }
   $uo = join("`,`",$st); $af = join("`,'|',`",$st); $lieb = " CONCAT('|',`$af`,'|') ";
 }else{  exit("[\"不支持输入提示(\$ztai=$ztai)\"]"); }
$data = array(); $ii=0;
foreach ($db as $ti=>$val) $$ti = $val; //调用
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
if (!$conn){ exit("[\"连接失败(检查数据库连接参数)\"]"); }
$wi = "select DISTINCT `$uo` from `{$biao}` Where $lieb like '%$keyword%'";
//$wi = "select `$uo` from `$biao` Where $lieb like '%$keyword%'";
$tp = mysqli_query($conn, $wi); //exit("[\"$wi\"]");
if (!$tp){ exit("[\"获取失败:检查数据库($biao)设置!\"]"); }
while($row = mysqli_fetch_assoc($tp)){
  foreach($row as $row1){
    $data[$row1]=$row1; if(count($data)>$xtips){ echo json_encode(array_keys($data)); exit(); }
  }
}
//$data = array_unique($data);
if(count($data)>$xtips) $data = array_slice($data, 0, $xtips); //限制泛滥
if(count($data)<1 || $data=="null") exit("[\"查无结果(请优化输入)\"]");
echo json_encode(array_keys($data));
exit();
}
if($idx=="cha"){
$ge=microtime(true);
if($isyzm=="1"){
session_start();
$ft = (isset($_POST['yw']))?addslashes($_POST['yw']):"";
if($ft!=$_SESSION['fo']){ exit("请正确输入验证码！");}
}
$_SESSION['fo'] = ""; //清空验证码
 $ca = (isset($_POST['ztai']))?addslashes($_POST['ztai']):$ztai; //默认查询第个条件
if($ca != $ztai) exit("刷新重试:查询设置发生变化!");
 $tx = array(); $io=1;
 $yu = (isset($_POST['xidx']))?addslashes($_POST['xidx']):$bc[0]; //默认查询第个条件
 $fi = (isset($_POST['xid0']))?addslashes($_POST['xid0']):"";
 if(!in_array($yu,$bc)){ exit("请选择查询条件!");}
 if(stristr("-11-12-13-14-15-","-$ztai-")){ //单输入框选条件系列
   $txt = "$yu"; $cf = "`$yu`"; 
 if($ztai=="11"){ $txt .= " 等于 {$fi} "; $cf .= " Like '$fi' "; 
 }elseif($ztai=="12"){ $txt .= " 包含 {$fi} "; $cf .= " Like '%{$fi}%' ";
 }elseif($ztai=="13"){ $txt .= " {$fi} 开头 "; $cf .= " Like '{$fi}%' ";
 }elseif($ztai=="14"){ $txt .= " {$fi} 结尾 "; $cf .= " Like '%{$fi}' ";
 }elseif($ztai=="15"){
 $fi = (isset($_POST['xid0']))?Trim($_POST['xid0']):"";
 $jw = explode(" ",$fi); $fe=[]; $jw=array_filter($jw); $ikz=join(" 或 ",$jw);
 foreach ($jw as $mv) { $fe[]= " `$yu` LIKE '%" . addslashes($mv) . "%'"; }
 $txt .= " 都包含 {$ikz} ";  $cf = join(" AND ",$fe);
  }

 }elseif(stristr("-21-22-23-24-25-","-$ztai-")){ //单输入框查多字段 方式1:CONCAT方式
 $fe=[]; $txt = " ".join(",",$bc); $fl = join("`,'|',`",$bc); $cf = " CONCAT('|',`$fl`,'|') ";
 if($ztai=="21"){ $cf .= " Like '%|$fi|%' "; $txt .= "等于";
 }elseif($ztai=="22"){ $cf .= " Like '%{$fi}%' "; $txt .= "包含";
 }elseif($ztai=="23"){ $cf .= " Like '%|{$fi}%' "; $txt .= "开头";
 }elseif($ztai=="24"){ $cf .= " Like '%{$fi}|%' "; $txt .= "结尾"; 
 }elseif($ztai=="25"){   
 $fi = (isset($_POST['xid0']))?Trim($_POST['xid0']):"";
 $jw = explode(" ",$fi); $fe=[]; $jw=array_filter($jw); $ikz=join(" 或 ",$jw);
 foreach ($jw as $mv) { $fe[]= " $cf LIKE '%" . addslashes($mv) . "%'"; }
 $txt .= " 都包含 {$ikz} ";  $cf = join(" AND ",$fe);
 }

 }elseif(stristr("-6-26-36-","-$ztai-")){  //多输入框都输对
 $fe=[]; $sqz=[]; 
 if(stristr("-6-","-$ztai-")){ $syu = "="; }else{ $syu = "Like"; }
 foreach ($bc as $ii=>$mv) {
 $ar = (isset($_POST['xid'.$ii]))?addslashes($_POST['xid'.$ii]):"";
 $fe[]= " `$mv` $syu '$ar' ";  $sqz[]= " $mv 等于 $ar "; 
 }
 $cf = join(" AND ",$fe); $txt=join(" 且 ",$sqz);

 }elseif(stristr("-51-","-$ztai-")){  //大文本框批量查询
 $fe=[]; $sqz=[]; 
 $ar = (isset($_POST['xid0']))?addslashes($_POST['xid0']):"";
 $ga = str_replace(array("\r\n","\r","\n","\t","'","\"",";","|","、")," ",$ar);
 $ih = explode(" ",$ga); $ih = array_filter($ih); $ih = array_unique($ih);
 if(count($ih)<1) exit("无效输入:请认真输入!");
 if(count($ih)>100) exit("无效输入:限制100个以内关键词!");
 $es = join("','",$ih);
 foreach ($bc as $ii=>$mv) {
 $fe[]= " `$mv` in('$es') ";  $sqz[]= " $mv "; 
 }
 $cf = join(" OR ",$fe); $txt=join(" 或 ",$sqz) ." 等于 所查各项 ";

 }elseif(stristr("-31-32-33-34-","-$ztai-")){  //多输入框输过都符合 
 $fe=[]; $sqz=[]; 
 foreach ($bc as $ii=>$mv) {
 $ar = (isset($_POST['xid'.$ii]))?addslashes($_POST['xid'.$ii]):"";
 if($ztai=="31"){ $txt = " 等于 {$ar} "; $cf = " = '$ar' "; 
 }elseif($ztai=="32"){ $txt = " 包含 {$ar} "; $cf = " Like '%{$ar}%' ";
 }elseif($ztai=="33"){ $txt = " {$ar} 开头 "; $cf = " Like '{$ar}%' ";
 }elseif($ztai=="34"){ $txt = " {$ar} 结尾 "; $cf = " Like '%{$ar}' "; }
 if($ar !=""){ $fe[]= " `$mv` $cf "; $sqz[]= " $mv $txt "; }
 }
 $txt=join(" 且 ",$sqz); $cf = join(" AND ",$fe); 

 }elseif(stristr("-1-2-3-4-5-","-$ztai-")){  //单输入框查多条件 方式1逐个字段 
 $fe=[]; $txt = " ".join("或",$bc);
 if($ztai=="1"){ $txt .= " 等于 {$fi} "; $ls = " Like '{$fi}' ";
 }elseif($ztai=="2"){ $txt .= " 包含 {$fi}"; $ls = " Like '%{$fi}%' ";
 }elseif($ztai=="3"){ $txt .= " {$fi} 开头 "; $ls = " Like '{$fi}%' ";
 }elseif($ztai=="4"){ $txt .= " {$fi} 结尾 "; $ls = " Like '%{$fi}' ";
 }elseif($ztai=="5"){  } //5->25
 foreach ($bc as $mv) { $fe[]= " `$mv` $ls "; }
 $cf = join(" OR ",$fe); 
   
 }else{
   exit("请设置查询模式(\$ztai=$ztai)!");
 }
foreach ($db as $ti=>$val) $$ti = $val; //调用
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
if (!$conn){ die("连接失败(检查数据库连接参数): " . mysqli_connect_error()); }
$pages = (isset($_POST['page']))?addslashes($_POST['page']):'1'; //页码
$ou = (isset($_POST['cu']))?addslashes($_POST['cu']): $bc[0]; //排序字段
$desc = (isset($_POST['desc']))?addslashes($_POST['desc']):'desc'; //排序+-
 if(!$pages || !is_numeric($pages)){ $pages = "1";}
 if(!$mpage || !is_numeric($mpage)){ $mpage = "10";}
 if(!$xpage || !is_numeric($xpage)){ $xpage = "20";}
if($pages>$xpage) $pages = $xpage; 
 $pe=$pages*$mpage; $ps=$pages*$mpage-$mpage;
$cl = "SELECT * FROM `$biao` Where $cf ORDER BY `$ou` $desc limit $ps, $mpage"; 
$rm = mysqli_query($conn, $cl); $ki=[];
if (!$rm){ exit("查询失败(检查数据库查询语句): \r$cl\r" . mysqli_error($conn)); }
echo "\r\n<table class=\"table\" cellspacing=\"0\">\r\n";
echo "\r\n<caption>查询结果如下</caption>\r\n";
$ii=0; echo "\r\n<!-- $txt -->\r\n\r\n";
while($data = mysqli_fetch_assoc($rm)) {
if ($ii<1) {
$ihide="|"; $ik=0;
echo "\r\n<thead>\r\n<tr class=\"tt\">\r\n";
foreach($data as $key=>$value){
 if(isset($du[$key])){ $keyx=$du[$key]; }else{ $keyx=$key; }
if(in_array($key,$kl)){ $ihide.="$key|";
}elseif(in_array($key,$at)){
 if($desc=="desc" && $key==$ou){ $deso="asc"; $dj="↑";}else{ $deso="desc"; $dj="↓"; }
 $ik++; if($key!=$ou){ $dj="↕"; }
 $link = "<a href='#' onclick=\"pu('$key','$deso');\"><nobr>$keyx$dj</nobr></a>";
 echo "<td>$link</td>\r\n";
}else{ $ik++; echo "<td>$keyx</td>\r\n";}
}
echo "\r\n</tr>\r\n</thead>\r\n<tbody>\r\n";
}
$ii++; echo "<tr>\r\n";
foreach($data as $key=>$value){
if(stripos($ihide,"|$key|") !== false){ //指定字段隐藏
}elseif(stripos("^null^kong^-^/^","^$value^") !== false){ //指定值隐藏
}elseif(stripos("^".$value,"^tel:") !== false){ //tel
$valua = str_replace("^tel:","","^".$value);
$val = "<a href=\"$value\" target=\"_blank\">$value</a>\r\n";
echo "<td data-label='$key'>$val</td>\r\n";
}elseif(stripos("^".$value,"^img:http") !== false){ //img
$valua = str_replace("^img:","","^".$value);
$val = "<a href=\"$valua\" target=\"_blank\"><img src=\"$valua\" class=\"ha\"></a>";
echo "<td data-label='$key'>$val</td>\r\n";
}elseif(stripos("^".$value,"^http") !== false){ //url
$val = "<a href=\"$value\" target=\"_blank\">$key</a>\r\n";
echo "<td data-label='$key'>$val</td>\r\n";
}else{
echo "<td data-label='$key'>$value</td>\r\n";
}
}
echo "</tr>\r\n";
}
if($ii>=$mpage){ //结果数量大于等于页码则显示分页
$ze = "select `$ou` from `{$biao}` Where $cf";
$result = mysqli_query($conn, $ze); $bt = $result->num_rows;
$gs = ef("cha",$bt,$ik);
 }else{ $gs = ""; }
if($ii<1) echo "<tr><td colspan='$ik' data-label='提示'>未查到".$txt."相关信息!</td></tr>";
echo "</tbody>\r\n$gs\r\n</table>";
 $gt=microtime(true); $total=$gt-$ge;
echo "\r\n <center>$fu</center>\r\n<!--页面执行时间：{$total} 秒-->";
exit();
}
?><!DOCTYPE html><html><head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title ." - ". $zt[$ztai];?></title>
<meta name="author" content="请保留作者信息: yujianyue, 15058593138@qq.com">
<link rel="shortcut icon" href="data:image/ico;base64,<?php echo $uid;?>" />
<style>
<?php
if (!preg_match('/^[0-9A-Fa-f]{6}$/', $isese)) $isese = "4CAF50";
 echo "
*{margin:0;font-size:16px;text-decoration:none;}
body{font-family:Arial,sans-serif;background-color:#f2f2f2;}
.main{margin:0 auto;padding:5px 0;background-color:#fff;border-radius:5px;box-shadow:0 0 5px rgba(0,0,0,0.3);min-width:300px;width:calc(99vw - 39px);min-height:calc(99vh - 39px);}
#result,#input{margin:10px auto;padding:0 10px;}
.tbv{margin:10px auto;width:97.5%; display: flex;flex-wrap: wrap;}
.flex{flex:6;} .flax{flex:2;} 
 #bk{position:absolute;top:2px;right:6px;height:35px;z-index:8;}
h1{margin:0 auto 20px auto;padding:10px 20px;background-color:#$isese;font-size:18px;text-align:center;color:white;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
p{margin:0; text-align:left;font-weight:bold;color:#$isese;}
.ha{max-width:200px;max-height:200px;}
.li {padding:6px 0;}
select{display:block;position:relative;width:99%;min-width:200px;background:none;border:2px solid #acacac;border-radius:5px;padding:0;height:39px;z-index:1;}
input{display:block;position:relative;width:99%;min-width:200px;background:none;border:2px solid #acacac;border-radius:5px;padding:0;height:35px;z-index:1;}
textarea{ height:300px;flex:15;}
label{display:inline-block;position:relative;top:-32px;left:10px;color:#acacac;z-index:2;transition:all 0.2s ease-out;}
input:focus,input:valid{outline:none;border:2px solid #$isese;}
input:focus + label,input:valid + label{top:-50px;color:#$isese;background-color:#fff;}
button{display:inline;padding:9px;background-color:#$isese;color:#fff;border:none;border-radius:5px;cursor:pointer;min-width:60px;}
button:hover{background-color:#3e8e41;}
caption{ color:gray; font-weight:bold;}
table{margin:10px auto;width:97.5%;border-left:1px solid #a2c6d3;border-top:3px solid #$isese;}
table td{border-right:1px solid #a2c6d3;min-width:36px;border-bottom:1px solid #a2c6d3;padding:6px 3px;word-wrap:break-word;word-break:break-all;}
.tt{background:#e5f2fa;line-height:18px;min-width:300px;}
.c{color:#3e8e41;text-align:center;width:25%;}
.r{text-align:right;}
b{font-weight:bold;color:red;}
table tr:nth-child(2n){background:#FAFAFA;}
#fa{margin:5px auto 0;width:calc(99vw - 39px);min-width:300px;display:block;}
.fa{color:gray;text-align:center;line-height:150%;}
.fa a{color:gray;}
@media screen and (max-width: 777px) { 
table{border:0;border-top:0px solid #$isese;} 
table thead {display:none;}
table tr{margin-bottom:18px;display:block;border-top:2px solid #$isese;}
table tr{border-bottom:1px solid #$isese;} 
table td {display:block;text-align:right;} 
table td {border-left:1px dotted #$isese;border-bottom: 1px dotted #ccc;} 
table td:nth-child(2n){background:#FAFAFA;}
table td:last-child {border-bottom:0;}
table td:before {content:attr(data-label);float:left;}
table td:before {font-weight:bold;color:blue;}
}
"; ?>
</style>
<script>
function $(objId){ return document.getElementById(objId);}
function rc(){ $("ng").style.display = "block"; }
function me(){ $("input").style.display = "block"; $("result").innerHTML = ""; }
function pu(cu,desc) { $("cu").value = cu; $("desc").value = desc; te();}
document.onkeydown = function(e){
if(!e) e = window.event;
//if((e.keyCode || e.which) == 13) te();
}
function oc(){
var sltCity = $("xidx");
var index = sltCity.selectedIndex; // 选中索引
var placeholders = '请输入'+ sltCity.options[index].text;
$("xids0").innerHTML = placeholders;
//$("xid0").setAttribute("placeholder",placeholders);
}
function cha(iir) {$("page").value=iir; te();}
function ud(Acts,ne) {
if (window.XMLHttpRequest) {
xmlhttp = new XMLHttpRequest();
} else {
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
var re = xmlhttp.response;
if(re.indexOf('</table>')!=-1){
$("result").innerHTML = re;
$("input").style.display = "none";
} else {
alert(re);
}
}
}
xmlhttp.open("POST", "?x="+Acts+"<?php echo "&z=$ztai&u=$uid";?>&tt="+Math.random(), true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send(ne);
}
function te() {
var xmlhttp; var ic = 0; var ice = 0; var ia = $("nums").value;
var ne= "nums="+ia;
if($("sm")){
if(!$("sm").value.match(/^[0-9]{4}$/)){ alert("请输入验证码"); return false;}
ne += "&yw="+$("sm").value;
}
if($("cu")) ne += "&cu="+$("cu").value;
if($("desc")) ne += "&desc="+$("desc").value;
if($("mima")) ne += "&mima="+$("mima").value;
if($("ztai")) ne += "&ztai="+$("ztai").value;
if($("xidx")){ 
if($("xidx").value==""){ alert("各项均得输对(请选择查询条件)!"); return false;}
ne += "&xidx="+$("xidx").value;
}
if($("page")){ ne += "&page="+$("page").value; }
$("result").innerHTML = "";
for (var ib = 0; ib <= ia; ib++){
if($("xid"+ib).value == ""){ ic++; }else{ ice++;
 ne+="&xid"+ib+"="+ encodeURIComponent($("xid"+ib).value);
}
}
<?php if(!stristr("-31-32-33-34-35-","-$ztai-")){ ?>
if(ic>0){ alert("各项均得输对("+ic+"项未输入)!"); return false;}
<?php }else{ ?>
if(ice<1){ alert("至少输入一项(输过的都得符合)!"); return false;}
<?php } ?>
if($("bk")) $("bk").click();
    ud("cha",ne);
}
</script>
</head>
<body>
<div class="main">
<h1><?php echo $title;?></h1>
<div id="result"></div>
 <div id="input">
 <div class="tbv">
<?php
 $istip="N";
  if(stristr("-11-12-13-14-15-","-$ztai-")){ ?>
<div class="flax">
<?php  //下拉选条件
$sla = "<select name=\"xidx\" id=\"xidx\" onChange=\"oc()\" >";
foreach($bc as $ij=>$tj){ $sla .= "<option value=\"$tj\" >$tj</option>\r\n"; }
$sla .= "</select>"; $ij = 0;
echo "$sla"; $tx=$bc[0];
?>
</div>
<?php }elseif(stristr("-6-31-32-33-34-35-","-$ztai-")){
foreach($bc as $ij=>$tj){ //多输入框
if(stristr("+$tishi+","+$tj+")){  $istip="Y"; //有字段则提示
echo "<div class=\"search-box\"> <input type=\"text\" class=\"rh\" id=\"xid$ij\" placeholder=\"请输入{$tj}[带提示]\" onfocus=\"this.select();\" autocomplete=\"off\">\r\n<div id=\"sgxid$ij\" style=\"display:none;\" class=\"ee\"></div></div>\r\n";  
}else{
echo "<div class=\"flex\"><input type=\"text\" name=\"xid$ij\" id=\"xid$ij\" autocomplete=\"off\" required><label for=\"xid$ij\" id=\"xids$ij\">请输入$tj</label></div>"; 
}
}
}
?>
<?php if(!stristr("-6-31-32-33-34-35-","-$ztai-")){
  $tx=join("或",$bc); $sz = array_intersect($bc,$ap);
if(stristr("-51-","-$ztai-")){ //文本框
$isyzm == "0"; $istip=="N";
echo "<textarea name=\"xid0\" id=\"xid0\" placeholder='一行一个($tx)'></textarea>";
}elseif(count($sz)>0){  $istip="Y"; //有字段则提示
echo "<div class=\"search-box\"><input type=\"text\" class=\"rh\" id=\"xid0\" placeholder=\"请输入$tx [带提示]\" onfocus=\"this.select();\" autocomplete=\"off\">\r\n<div id=\"sgxid0\" style=\"display:none;\" class=\"ee\"></div></div>\r\n";  
}else{
echo "<div class=\"flex\"><input type=\"text\" name=\"xid0\" id=\"xid0\" autocomplete=\"off\" required><label for=\"xid0\" id=\"xids0\">请输入$tx;</label></div>";
}
}
 if($istip=="Y"){ echo ht($ztai);}
?>
<?php if($isyzm == "1"){ ?>
<div class="flax" id="cs" style="position:relative;">
<input type="text" name="sm" id="sm" autocomplete="off" required>
<label for="sm">验证码</label>
<img src="?t=<?php echo date("YmdHis");?>" id="bk" onClick="this.src='?t='+new Date();">
</div>
<?php } ?>
<div class="l"><button onclick="cha(1)">查询</button></div>
</div>
<input type="hidden" value="<?php echo $ij;?>" id="nums">
<input type="hidden" value="<?php echo $bc[0];?>" id="cu">
<input type="hidden" value="<?php echo $ztai;?>" id="ztai">
<input type="hidden" value="<?php echo md5("@$uid@$ztai@");?>" id="mima">
<input type="hidden" value="desc" id="desc">
<input type="hidden" value="1" id="page">
<?php
if($itips == "Y"){ //UA浏览器信息判断
  $etips = sn();
  if($etips!="") echo wo($etips);
}
if(file_exists($idesc)) { //本地说明文件读取
$txt = file_get_contents($idesc);
echo wo(str_replace(array("\r\n","\r","\n"),"<br>",$txt));
}
?>
</div>
</div>
<div class="fa" id="fa">
<?php
echo "&copy;".date("Y")."&nbsp;<!-- $ztai@{$zt[$ztai]} -->";
echo "<a href=\"$copyu\" target=\"_blank\" >$copyr</a>";
?>
</div>
</body>
</html>