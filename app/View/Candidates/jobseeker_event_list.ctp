<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Event Registration Center</h1>
          <div class="content">
            <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
            <p>By clicking on the "my interviews" graphic (under the "Interview list" column heading), you can view the list of employers (if any) that have requested interviews with you for a given event. Please print this list before heading to the event and be sure to visit the employers that have requested interviews with you.  </p>
            <br />
            <p>You are currently registered for the following upcoming TECHEXPO Top Secret events:</p>
            <br />
             
            <?php  if(count($eventList))
			 { ?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="74" style="text-align:left">
                      	<?php echo $this->Paginator->sort('show.show_name','Event Info'); ?>
                      </th>
                      <th width="84" style="text-align:left">
                     	 <?php echo $this->Paginator->sort('show.show_dt','Date'); ?>
                      </th>
                     
                      <th width="114" style="text-align:left">
                      	<?php echo $this->Paginator->sort('show.location_id','Address'); ?>
                      </th>
                       <th width="74" style="text-align:left">Interviews</th>
                      
                      <th width="74" style="text-align:left">Share</th>
                    </tr>
                
                  </table></td>
              </tr>
              <?php 
              $i=1;
              foreach($eventList as $key=>$value){?>
              <tr>
                <td  class="<?php if($i%2=='0'){?>table_row border_bottom<?php }else{?>table_row border_bottom alternate<?php } ?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="74" style="text-align:left">
                      <?php echo $this->Html->link($value['show']['show_name'],array('controller'=>'candidates','action'=>'eventinfo',$value['show']['id']));?>
                     </td>
                      <td  width="84" class="normalfont" style="text-align:left"><?php  echo $value['show']['show_dt'];?><br />
                      <?php  echo $value['show']['show_hours'];?>
                      </td>
                     
                      <td  width="114" class="normalfont" style="text-align:left">
                      	<?php echo   $common->getLocationAddress($value['show']['location_id']); ?>
                      </td>
                       <td  width="74" class="normalfont" style="text-align:left">
					   
                       	<?php echo $this->Html->link('Scheduled Interviews',array('controller'=>'candidates','action'=>'scheduledInterviewList',$value['show']['id']));?>
                       </td>
                      <td  width="74" class="last normalfont" style="text-align:left">
                       <a href="http://www.facebook.com/sharer.php?u=<?php echo FULL_BASE_URL.router::url('/',false).'shows/view/'.$value['show']['id'];?>&t=event" target="_blank"><?php echo $this->Html->image('images/face.jpg');?></a>  
                       &nbsp;&nbsp;
                       <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo FULL_BASE_URL.router::url('/',false).'shows/view/'.$value['show']['id'];?>" >
                       <?php echo $this->Html->image('images/twitt.jpg');?>
                       </a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                      </td>
                    </tr>
                  </table></td>
              </tr>
              <?php 
              $i=$i+1;
              } 
              
			  ?>
            </table>
           
            <br />
            
            <div class="paging"> 
            <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                  <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;&nbsp;'));?>
                  <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
            
             </div>
            <div class="man_resume_footer"> 
            
             <?php 
			}else
              {?>
             
            	  <strong>  You are currently not registered for any TECHEXPO Top Secret events.</strong><br />
              	<br />
              
              <?php 
              }?>
            
              <?php echo $this->Html->link($this->Html->image('images/register_event.jpg'),array('controller'=>'shows','action'=>'eventRegister'),array('escape'=>false));?>
             </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>