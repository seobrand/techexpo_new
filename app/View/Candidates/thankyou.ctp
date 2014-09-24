<?php //pr($this->Session->read('Auth.Client');die;?>
<div id="wrapper">
  <div class="inner_banner">
    <?php $bannerDt = $common->getbannerImage('3');   ?>
    <div class="static_inner_banner">
      <div class="static_title_bar">
        <p><?php echo $bannerDt['OtherBanner']['name']; ?></p>
      </div>
      <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  /> </div>
  </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Thank you </h1>
          <div class="content">
            <div class="tab_panel_41 tab_panel_44">
              <ul>
                <li class="firstTab"><a> Create <br />New Profile
                 </a></li>
                <li class="secondTab"><a>Post <br />
                  Your Resume</a></li>
                <li class="thirdTab"><a>Register <br />
                  For an Event</a></li>
                <li class="fourthTab"><a>Thank You</a></li>
              </ul>
              <div class="clear"></div>
            </div>
            <div class="gray_full_top"></div>
            <?php echo $this->Form->create(null, array('url' => array('controller' => 'candidates', 'action' => 'thankyou','login')),array('method'=>'post'));?>
            <div class="gray_full_mid">
              <div class="thankyou thankyou1">
              <?php if(count($newsletter)>0){?>
	              Thank you for registering. As a service to our users, we offer the following industry newsletters. if you would like to receive any of these informative items, simply click the check box next to the ones that interest you. Feel free to select none or as many as you want. Once you've made you selections, click the button to be taken to your dashboard.<br/><br/>	              
	              <ul>
	              <?php foreach ($newsletter as $newsletter){?>
	              <li>
	              <div class="containt-li">
	              <div class="containt-li-checkbox"><input type="checkbox" name="data[Newsletter][id][]" value="<?php echo $newsletter['Newsletter']['id']?>" checked="checked"/></div>
	              <div class="containt-li-title"><span><?php echo $newsletter['Newsletter']['newsletter_title'];?></span></div>
	              <div class="containt-li-des"><?php echo $newsletter['Newsletter']['newsletter_description'];?></div>              
	              </div>              
	              </li> 
	              <?php }?>             
	              </ul>   
	              <?php }else{?>
	              Thank you for registering. Please click the button to be taken to your dashboard.<br/><br/>
	              <?php }?>           	
              	<div>
              	<?php echo $this->Form->submit('images/continue-1.jpg',array('class'=>false,'label'=>false,'div'=>false));?>
              	</div>
              </div>              
            </div>
            <?php echo $this->Form->end();?>
          </div>
        </div>
      </div>
    </div>
    <div class="rt_col_inner">
        <?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
      </div>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?> 
    
    
  </div>
</div>