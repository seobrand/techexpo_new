<?php if($session->check('Message.flash')){  ?>

<div class="messages">
  <?php if(isset($this->params['named']['message'])&& $this->params['named']['message']=='success' && isset($_SESSION['popup'])) { ?>
  <style type="text/css">
#fade { /*--Transparent background layer--*/
	display: none; /*--hidden by default--*/
	background: #000;
	position: fixed; left: 0; top: 0;
	width: 100%; height: 100%;
	opacity: .80;
	z-index: 9999;
}
.popup_block{
	display: none; /*--hidden by default--*/
	background: #fff;
	padding: 5px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	border: 1px solid #000000;
	float: left;
	font-size: 1.2em;
	position: fixed;
	top: 70%; left: 50%;
	z-index: 99999;
	/*--CSS3 Box Shadows--*/
/*	-webkit-box-shadow: 0px 0px 20px #000;
	-moz-box-shadow: 0px 0px 20px #000;
	box-shadow: 0px 0px 20px #000;
	/*--CSS3 Rounded Corners--*/
/*	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;*/
}
img.btn_close {
	float: right;
	margin: -55px -55px 0 0;
}
/*--Making IE6 Understand Fixed Positioning--*/
*html #fade {
	position: absolute;
}
*html .popup_block {
	position: absolute;
}
.popup_block h3 {color:#ffffff; font-size:18px; background:url(<?php echo FULL_BASE_URL.Router::url('/',false);?>img/head_rep.gif) repeat-x; padding:5px 10px 4px 10px; font-weight: normal; font-family:Verdana, Arial, Helvetica, sans-serif; }

.success_text{font-size:14px; color:#075001; padding:20px; font-family:Verdana, Arial, Helvetica, sans-serif;}
</style>
  <script language="javascript">
	var popmsg = jQuery.noConflict();
popmsg(document).ready(function() {
	//When you click on a link with class of poplight and the href starts with a # 

popmsg('a.poplight[href^=#]').click(function() {
    var popID = popmsg(this).attr('rel'); //Get Popup Name
    var popURL = popmsg(this).attr('href'); //Get Popup href to define size

    //Pull Query & Variables from href URL
    var query= popURL.split('?');
    var dim= query[1].split('&');
    var popWidth = dim[0].split('=')[1]; //Gets the first query string value

    //Fade in the Popup and add close button
    popmsg('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('');

    //Define margin for center alignment (vertical   horizontal) - we add 80px to the height/width to accomodate for the padding  and border width defined in the css
    //var popMargTop = (popmsg('#' + popID).height() + 20) / 2;
    //var popMargLeft = (popmsg('#' + popID).width() + 20) / 2;
	var popMargTop  = 100;
    var popMargLeft = 190;
    //Apply Margin to Popup
    popmsg('#' + popID).css({
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });

    //Fade in Background
    popmsg('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
    popmsg('#fade').css({'filter' : 'alpha(opacity=60)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 

    return false;
});

//Close Popups and Fade Layer
popmsg('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
    popmsg('#fade , .popup_block').fadeOut(function() {
        popmsg('#fade, a.close').remove();  //fade them both out
    });
    return false;
});

});

</script>
  <script type="text/javascript">	 
function autoClick() {	
     document.getElementById('thisLink').click();
	 document.getElementById('popup_check').value='yes';
    }	 
</script>
  </head>
  <input type="hidden" name="popup_check" id="popup_check" value="no"/>
  <div id="popup_name" class="popup_block">
    <h3 style="font-family:Verdana, Arial, Helvetica, sans-serif;">Message</h3>
    <div class="success_text">
      <table cellpadding="10px" cellspacing="10px" border="0" width="" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;">
        <tr>
          <?php 
		 echo '<td style="background-color:#FFFFFF;border:none;">'.$html->image('success.png',array('alt'=>'success','title'=>'success','style'=>'width:40px;'));
		  echo'</td><td style="background-color:#FFFFFF;border:none;">'.$session->flash().'</td>';
		  unset($_SESSION['popup']);
 	?>
        </tr>
      </table>
      <a href="#?w=400" rel="popup_name" class="poplight" style="display:none;">
      <input type="image" src="" id="thisLink" width="0px"/>
      </a><a href="#" class="close" style="display:none;">
      <input type="image" src="" id="closethisLink" width="0px"/>
      </a></div>
  </div>
  <?php   }
	 else /*if(!isset($_SESSION['popup'])) */{ ?>
  <div id="message-error" class="message message-error">
    <div class="image"> <?php echo $html->image('error.png',array('alt'=>'Error','title'=>'Error'));?> </div>
    <div class="text">
      <!--<h6>Error Message</h6>-->
      <span><?php echo $session->flash(); ?></span> </div>
    <div class="dismiss"> <a href="#message-error"></a> </div>
  </div>
  <?php } ?>
</div>
<?php } ?>
