<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Event Registration</h1>
          <div class="content">
            <?php //echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
            <p>If you are registered for an event, by clicking the "my interviews" link you can view the list of employers that have requested to interview you at a given event. Please print this list before heading to the event and be sure to visit the employers that have requested to interview you.</p>
           <br />
            <?php  if(count($eventList))
			 { ?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                <tr class="tableHead">
                    <th width="23%"><?php echo $this->Paginator->sort('show.show_name','Event'); ?></th>
                    <th width="23%"><?php echo $this->Paginator->sort('show.show_dt','Date/Time'); ?></th>
                    <th width="23%"><?php echo $this->Paginator->sort('show.location_id','Address'); ?></th>
                    <th width="18%">Status</th>
                    <th width="13%">Share</th>
                </tr>
                </thead>
             <tbody>
             	 <?php 
	              	$i=1;
              		foreach($eventList as $key=>$value){?>
                 	<?php 
					$eventShareUrl = $_SERVER['SERVER_NAME'].$this->webroot."shows/view/".$value['Show']['id'];
					$eventSharetitle = $value['Show']['show_name'];?>
                    <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                        <td style="text-align:left">
                        <?php 
						$show_detail=$common->get_show_homedetails($value['Show']['id']);
						
						if($show_detail['ShowsHome']['display_name']){
							$show_name=$show_detail['ShowsHome']['display_name'];
						}else{ 
							$show_name=$value['Show']['show_name'];
						}
						
						echo $this->Html->link($show_name,array('controller'=>'candidates','action'=>'eventinfo',$value['Show']['id']),array('class'=>'event_list_text'));?><br>
                        
                        <?php 
					echo	$show_detail['ShowsHome']['special_message'];
						?>
                        
                        
                        
                        </td>
                        <td class="normalfont" style="text-align:left"><?php  echo date(WEBSITE_DATE_FORMAT,strtotime($value['Show']['show_dt']));?><br />
                        <?php  echo $value['Show']['show_hours'];?>
                        </td>
                        <td class="normalfont" style="text-align:left">
	                        <?php echo $value['Location']['site_name'];?><br/>
						  	<?php echo $value['Location']['location_city'];?>, <?php echo $value['Location']['location_state'];?>
                        </td>
                        <td class="normalfont" style="text-align:left">
                         <?php
                        $chekRegistration=$common->isCandidateRegForEvent($this->Session->read('Auth.Client.Candidate.id'),$value['Show']['id']);
                        if($chekRegistration)
                        { 
                       		echo $this->Html->image('registered.png');    
                       		echo $this->Html->link('My Interviews',array('controller'=>'candidates','action'=>'scheduledInterviewList',$value['Show']['id']));
                        }else
                        {
                          	echo $this->Html->link('Register',array('controller'=>'shows','action'=>'eventRegister',$value['Show']['id']));
                        }
                        ?>
                        </td>
                        <td class="last normalfont" style="text-align:left">
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo FULL_BASE_URL.router::url('/',false).'shows/view/'.$value['Show']['id'];?>&t=event" target="_blank"><?php echo $this->Html->image('images/face.jpg');?></a>  
                        <a href="http://twitter.com/home?status=<?php echo $eventShareUrl;?>" title="Click to share this post on Twitter" target="_blank"><img src="<?php echo $this->webroot;?>img/images/twitt.jpg" alt="" /></a>
                        <br />
                        </a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                        
                        
                                                <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $eventShareUrl; ?>&title=<?php echo $eventSharetitle; ?>" target="_blank"><img src="<?php echo $this->webroot;?>img/images/link.jpg" alt="" /></a>
                        <!-- Place this tag where you want the +1 button to render. -->
                        <!--<script src="https://apis.google.com/js/plusone.js"></script>
                        <g:plus action="share" count="false" annotation="bubble"></g:plus> -->
                        
                        
                        <a href="https://plus.google.com/share?url=<?php echo $currentURL;?>" onclick="javascript:window.open(this.href,
                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img
                        src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/images.png" alt="Share on Google+"  width="25px"   height="25px"/></a>
                        
                        </td>
                    </tr>
				  <?php 
                  $i=$i+1;
                  } 
                  ?>
              </tbody>
            </table>
            <br />
            <div class="paging"> <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $this->Paginator->numbers();?> | <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?> </div>
           <div class="man_resume_footer"> 
             <?php 
			}else
              {?>
            	  <strong>  You are currently not registered for any TECHEXPO Top Secret events.</strong><br />
              	<br />
              <?php 
              }?>
              <?php //echo $this->Html->link($this->Html->image('images/register_event.jpg'),array('controller'=>'shows','action'=>'eventRegister'),array('escape'=>false));?>
             </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>