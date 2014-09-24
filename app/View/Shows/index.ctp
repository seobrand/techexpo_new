<div id="wrapper_outer1">
<div id="wrapper">
  <?php 
	if($this->Session->read('Auth.Client.Candidate.id')!='')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
	}

	if($this->Session->read('Auth.Client.employerContact.id')!='')
	{
		 echo $this->element('employer_tabs');
	}
 ?>
  <div class="inner_banner">
    <?php $bannerDt = $common->getbannerImage('2');   ?>
    <div class="static_inner_banner">
      <div class="static_title_bar_shows_evt">
        <p>
          <?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?>
        </p>
      </div>
      <img style="border:none" src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  /> </div>
  </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Event Registration Center</h1>
          <div class="content">
          <br />
         
          <?php 
			if($this->Session->read('Auth.Client.Candidate.id')=='' and $this->Session->read('Auth.Client.employerContact.id')=='')
			{
         		?>
                  <a href="javascript:void(0);" onclick="showRegisterPopup()"><?php echo $this->Html->image('images/cal-register_new.png',array('border'=>'none','alt'=>'Register','title'=>'Register')); ?></a>
                 <br />
                <?php
				
		   }
		   
		  ?>
         
            <br />
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr class="tableHead">
                        <th width="30%" style="text-align:center">Event</th>
                        <th width="25%" style="text-align:center">Date/Time</th>
                        <th width="30%" style="text-align:center">Location</th>
                        <th width="15%" style="text-align:center">Share</th>
                    </tr>
                </thead>
                 <tbody>
             	 <?php 
				 $i=1;
				 foreach( $shows as $show ) {  ?>
                      <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                        <td style="text-align:left">
	                        <?php 
							$show_detail=$common->get_show_homedetails($show['Show']['id']);
							$show_name = (!empty($show_detail['ShowsHome']['display_name'])) ? $show_detail['ShowsHome']['display_name'] : $show['Show']['show_name'];
					 		echo $this->Html->link($show_name, array('controller'=>'shows','action'=>'view',$show['Show']['id']),array('escape'=>false,'class'=>'event_list_text')); ?> 
	                        <br>                        
	                        <?php 
								echo $show_detail['ShowsHome']['special_message'];
							?>                        
                        </td>
                        <td class="normalfont" style="text-align:left"><?php echo date(WEBSITE_DATE_FORMAT,strtotime($show['Show']['show_dt']));   ?><br />
                        <?php echo $show['Show']['show_hours'];   ?></td>
                        <td class="normalfont" style="text-align:centre">
                        <?php  	
                            $theComponent = new commonComponent(new ComponentCollection());
                            $location_city 	= $theComponent->getLocationInfo('location_city',$show['Show']['location_id']);
                            $location_state = $theComponent->getLocationInfo('location_state',$show['Show']['location_id']);
                            $location_name 	= $theComponent->getLocationInfo('site_name',$show['Show']['location_id']);
                            /* $location_address = $theComponent->getLocationInfo('site_address',$show['Show']['location_id']); */
                        ?>
                        <?php echo  $location_name.'<br/>'.$location_city.',&nbsp;'.$location_state; ?>
                        </td>
                        <td class="normalfont" style="text-align:centre">                            
                        <?php 
                          $eventShareUrl = $_SERVER['SERVER_NAME'].$this->webroot."shows/view/".$show['Show']['id'];
                          $eventSharetitle = $show['Show']['show_name'];?>
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo FULL_BASE_URL.router::url('/',false).'shows/view/'.$show['Show']['id'];?>&t=event" target="_blank"><?php echo $this->Html->image('images/face.jpg');?></a>  <a href="http://twitter.com/home?status=<?php echo $eventShareUrl;?>" title="Click to share this post on Twitter" target="_blank"><img src="<?php echo $this->webroot;?>img/images/twitt.jpg" alt="" /></a> 
                        <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $eventShareUrl; ?>&title=<?php echo $eventSharetitle; ?>&summary=<?php echo $show['Show']['show_name'].'-'.date('M d,Y', strtotime($show['Show']['show_dt']));  ?>source=techexpousa.com" target="_blank"><img src="<?php echo $this->webroot;?>img/images/link.jpg" alt="" /></a> 
                        
                        <!--  <script src="https://apis.google.com/js/plusone.js"></script>
                        <g:plus action="share" annotation="bubble"></g:plus>-->
                        <a href="https://plus.google.com/share?url=<?php echo $currentURL;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/images.png" alt="Share on Google+"/></a>
                        </td>
                      </tr>
              	 <?php 
				  $i=$i+1;
				 } ?>
              </tbody>
            </table>
            <br />
          </div>
        </div>
      </div>
    </div>
    <div class="rt_col_inner">
    	<?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    </div>
    <div class="clear"></div>
    	<?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
