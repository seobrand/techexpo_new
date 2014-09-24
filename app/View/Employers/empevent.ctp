<?php $employerID = $this->Session->read('Auth.Client.employerContact.employer_id');  ?>

<div id="wrapper"> <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Events </h1>
          <div class="content">
            <p>Here are the upcoming TECHEXPO events:</p>
            <br />
            <?php if($this->Paginator->numbers()):?>
            <br />
            <div class="pager_panel">
              <div class="pager">
                <div class="paging"> <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $this->Paginator->numbers();?> | <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?> </div>
                <div class="clear"></div>
              </div>
            </div>
            <br />
            <?php endif;?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr class="tableHead">
                  <th width="32%">Event</th>
                  <th width="20%">Date/Time</th>
                  <th width="25%">Location</th>
                  <?php /*?>   <th width="17%">Interviews</th><?php */?>
                  <th width="15%">Share</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($upcomingEvents)>0):
				  $i=1;
				  foreach($upcomingEvents as $key => $upcomingEvent){
				  $eventShareUrl = $_SERVER['SERVER_NAME'].$this->webroot."employers/eventinfo/".$upcomingEvent['Show']['id'];
				   $eventSharetitle = $upcomingEvent['Show']['show_name'];
				?>
                <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                  <td align="left" style="text-align:left;" ><?php // echo $this->Html->link($upcomingEvent['Show']['show_name'],array('controller'=>'employers','action'=>'eventinfo',$upcomingEvent['Show']['id']));?>
                    <?php 
							  $show_detail=$common->get_show_homedetails($upcomingEvent['Show']['id']);
							  
							  $show_name = (!empty($show_detail['ShowsHome']['display_name'])) ? $show_detail['ShowsHome']['display_name'] : $upcomingEvent['Show']['show_name'];
							  echo $this->Html->link($show_name, array('controller'=>'employers','action'=>'eventinfo',$upcomingEvent['Show']['id']),array('escape'=>false,'class'=>'event_list_text')); ?>
                    <br>
                    <?php  echo $show_detail['ShowsHome']['special_message']; 
					
					$register_check=$common->isEmployerRegisteredForEvent($upcomingEvent['Show']['id'],$employerID);
					if($register_check) { ?> 
                    <span style="display:block;margin-top:10px;"><?php echo $this->Html->image("registered.png");?> </span>
			 		<?php } else { ?>
					<span style="display:block;margin-top:10px;">
                     <?php echo $this->Html->link("Register",array('controller'=>'employers','action'=>'eventinfo',$upcomingEvent['Show']['id']));?>
					</span>
					<?php  }  ?>  </td>
                    
                  <td class="normalfont" style="text-align:left"><?php echo date(WEBSITE_DATE_FORMAT,strtotime($upcomingEvent['Show']['show_dt']));?><br />
                    <?php echo $upcomingEvent['Show']['show_hours'];?></td>
                  <td class="normalfont" style="text-align:left"><?php echo $upcomingEvent['Location']['site_name'];?><br/>
                    <?php echo $upcomingEvent['Location']['location_city'];?>, <?php echo $upcomingEvent['Location']['location_state'];?> 
                    <!-- <a href="http://maps.google.com/?q=<?php echo $upcomingEvent['Location']['site_name']; echo $upcomingEvent['Location']['site_address'];?><?php echo $upcomingEvent['Location']['location_city'];?>, <?php echo $upcomingEvent['Location']['location_state'];?> <?php echo $upcomingEvent['Location']['site_zip'];?>" target="_blank" > view on google map</a> --></td>
                  <?php /*?> <td class="normalfont" style="text-align:left">
						<?php $isRegistered = $common->isEmployerRegisteredForEvent($upcomingEvent['Show']['id'],$employerID);?>
						<?php if($isRegistered>0){?>
							  <?php echo $this->Html->link("Requested Interview", array("controller"=>"employers","action"=>"eventInterviewList",$upcomingEvent['Show']['id'],$employerID));?><br /><br />
							  <?php echo $this->Html->link("Schedule interviews",array('controller'=>'folders','action'=>'searchRegCandidate'));?>
						<?php }else{?>
								<a href="javascript:void(0);" onclick="showClickFront('Sorry you are not registered for this event.');">Requested Interviews</a><br /><br />
								<a href="javascript:void(0);" onclick="showClickFront('Sorry you are not registered for this event.');">Scheduled Interviews</a>
						<?php }?>
					  </td><?php */?>
                  <td class="last normalfont" align="center"><a href="http://www.facebook.com/sharer.php?u=<?php echo FULL_BASE_URL.router::url('/',false).'shows/view/'.$upcomingEvent['Show']['id'];?>&t=event" target="_blank"><?php echo $this->Html->image('images/face.jpg');?></a> <a href="http://twitter.com/home?status=<?php echo $eventShareUrl;?>" title="Click to share this post on Twitter" target="_blank"><img src="<?php echo $this->webroot;?>img/images/twitt.jpg" alt="" /></a><br />
                    <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $eventShareUrl; ?>&title=<?php echo $eventSharetitle; ?>" target="_blank"><img src="<?php echo $this->webroot;?>img/images/link.jpg" alt="" /></a> <a href="https://plus.google.com/share?url=<?php echo $currentURL;?>" onclick="javascript:window.open(this.href,
	'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img
	src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/images.png" alt="Share on Google+"  width="25px"   height="25px"/></a></td>
                </tr>
                <?php $i=$i+1; } // endoreach
				else: 
				  ?>
                <tr>
                  <td class="table_row" width="100%" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="6"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">There is no upcoming event in our database.</font></td>
                      </tr>
                    </table></td>
                </tr>
                <?php endif;?>
              </tbody>
            </table>
            <br />
            <?php if($this->Paginator->numbers()):?>
            <br />
            <div class="pager_panel">
              <div class="pager">
                <div class="paging"> <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $this->Paginator->numbers();?> | <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?> </div>
                <div class="clear"></div>
              </div>
            </div>
            <br />
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> </div>
</div>
<script>function fbs_click(shareURL,shareTitle) {u=shareURL;t=shareTitle;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>