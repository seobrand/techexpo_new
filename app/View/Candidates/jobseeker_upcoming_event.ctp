<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Upcoming Event List</h1>
          <div class="content"> <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
            <p>By clicking on the "my interviews" graphic (under the "Interview list" column heading), you can view the list of employers (if any) that have requested interviews with you for a given event. Please print this list before heading to the event and be sure to visit the employers that have requested interviews with you. </p>
            <br />
            <p>You are currently registered for the following upcoming TECHEXPO Top Secret events:</p>
            <br />
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr class="tableHead"> 
                  <th width="77"> <?php echo $this->Paginator->sort('Show.show_name','Event Info'); ?> </th>
                  <th width="77"> <?php echo $this->Paginator->sort('Show.show_dt','Date'); ?> </th>
                  <th width="97"> <?php echo $this->Paginator->sort('Show.location_id','Address'); ?> </th>
                  <th width="77">Register</th>
                  <th width="67">Share</th>
                </tr>
              </thead>
              <tbody>
				  <?php 
                  $i=1;
                  foreach($showRec as $key=>$value){?>
                  <tr class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                      <td style="text-align:left" >
					  <?php echo $this->Html->link($value['Show']['show_name'],
					  						array('controller'=>'candidates','action'=>'eventinfo',$value['Show']['id']));?> </td>
                      <td  class="normalfont" style="text-align:left">
					  					<?php  echo $value['Show']['show_dt'];?>
                        					<br />
                        				<?php  echo $value['Show']['show_hours'];?>
                      </td>
                      <td class="normalfont" style="text-align:left">
					  					<?php echo   $common->getLocationAddress($value['Show']['location_id']); ?> </td>
                      <td class="normalfont" style="text-align:left">
					  						<?php echo $this->Html->link('Register',
													array('controller'=>'shows','action'=>'eventRegister',$value['Show']['id']));?> </td>
                      <td class="last normalfont" style="text-align:left"><a href="http://www.facebook.com/sharer.php?u=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/pushkar/techexpo_new/shows/view/'.$value['Show']['id'];?>&t=event" target="_blank"><?php echo $this->Html->image('images/face.jpg');?></a> &nbsp;&nbsp; <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/pushkar/techexpo_new/shows/view/'.$value['Show']['id'];?>" > <?php echo $this->Html->image('images/twitt.jpg');?> </a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                        <?php //echo $this->Html->link($this->Html->image('images/twitt.jpg'),array('controller'=>'','action'=>''),array('escape'=>false));?>
                      </td>
                  </tr>
                  <?php 
                  $i=$i+1;
                  } ?>
              </tbody>
            </table>
            <br />
            <div class="paging"> 
			<?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                  <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;&nbsp;'));?>
                  <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
            
            </div>
            <div class="man_resume_footer"> <?php echo $this->Html->link($this->Html->image('images/register_event.jpg'),array('controller'=>'shows','action'=>'eventRegister'),array('escape'=>false));?> </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
