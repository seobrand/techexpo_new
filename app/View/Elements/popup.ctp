<script language="JavaScript1.2">
var ie=document.all
var dom=document.getElementById
var ns4=document.layers
var calunits=document.layers? "" : "px"
var PopupWin_bouncelimit
var direction="up"
var PopupWin_usedropin=0
function PopupMe1(url){
if (!dom&&!ie&&!ns4){
window.open(url, "", "scrollbars=1")}else{
PopupWin_bouncelimit=32 //(must be divisible by 8)
PopupWin_crossobj=(dom)?document.getElementById("PopupWin_dropin").style : ie? document.all.PopupWin_dropin : document.PopupWin_dropin
PopupWin_crossframe=(dom)?document.getElementById("PopupWin_cframe") : ie? document.all.PopupWin_cframe : document.PopupWin_cframe
PopupWin_crossframe.src=url
if(PopupWin_usedropin){
scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
PopupWin_crossobj.top=scroll_top-250+calunits}
PopupWin_crossobj.visibility=(dom||ie)? "visible" : "show"
if(PopupWin_usedropin){
PopupWin_dropstart=setInterval("PopupWin_dropin()",50)}}}
function PopupWin_dropin(){
scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
if (parseInt(PopupWin_crossobj.top)<0+scroll_top){
PopupWin_crossobj.top=parseInt(PopupWin_crossobj.top)+40+calunits
if (parseInt(PopupWin_crossobj.top)>0+scroll_top){PopupWin_crossobj.top=0+scroll_top}}else{
clearInterval(PopupWin_dropstart)
PopupWin_bouncestart=setInterval("PopupWin_bouncein()",50)}}
function PopupWin_bouncein(){
PopupWin_crossobj.top=parseInt(PopupWin_crossobj.top)-PopupWin_bouncelimit+calunits
if (PopupWin_bouncelimit<0)
PopupWin_bouncelimit+=8
PopupWin_bouncelimit=PopupWin_bouncelimit*-1
if (PopupWin_bouncelimit==0){
clearInterval(PopupWin_bouncestart)}}
function PopupWin_dismissbox(){
if (window.PopupWin_bouncestart) clearInterval(PopupWin_bouncestart)
PopupWin_crossframe.src=""
PopupWin_crossobj.visibility="hidden"}
function truebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body}
</script>
<a href="javascript:PopupMe1('<?php echo FULL_BASE_URL.Router::url('/',false)?>/users/forgotpassword')">Click here for popup</a>

<div id="PopupWin_dropin" style="position:absolute; z-index:100000; visibility:hidden; top:55%;left:30%; width:400px;  border:solid thin #e6e6e6;  background:url(<?php echo FULL_BASE_URL.Router::url('/',false)?>img/head_rep.gif) repeat-x;">
<div style="float:left; width:300px; text-align:left; color:#ffffff; font-size:24px; padding:5px 10px 24px 10px; font-weight: normal; font-family:"Times New Roman", Times, serif; ">Basic Modal Dialog</div>
<div style="float:right; text-align:right; width:30px;"><a href="#" onClick="PopupWin_dismissbox();location.href='#';return false"><img style="margin-top:4px; margin-right:5px;" border="0" src="<?php echo FULL_BASE_URL.Router::url('/',false)?>img/x.png" /></a></div>
<IFRAME ID="PopupWin_cframe" SRC="" width=400 height=230px FRAMEBORDER=0></IFRAME></div>