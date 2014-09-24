<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Applied Job</h1>
          <div class="content">
            <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
         		<br />
          		<br />
            <?php  if(count($applyHistory))
			{ 
			 ?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="77" style="text-align:left">
                      	<?php echo $this->Paginator->sort('ApplyHistory.resume_title','Resume Title'); ?>
                      </th>
                      <th width="77" style="text-align:left">
                     	 <?php echo $this->Paginator->sort('ApplyHistory.job_title','Job Title'); ?>
                      </th>
                     
                      <th width="97" style="text-align:left">
                      	<?php echo $this->Paginator->sort('ApplyHistory.dt','Apply Date'); ?>
                      </th>
                       <th width="77" style="text-align:left">Interviews</th>
                      
                    </tr>
                  </table></td>
              </tr>
              <?php 
              $i=1;
              foreach($applyHistory as $key=>$value){?>
              <tr>
                <td  class="<?php if($i%2=='0'){?>table_row border_bottom<?php }else{?>table_row border_bottom alternate<?php } ?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="77" style="text-align:left">
                     
                      <?php  echo $value['ApplyHistory']['resume_title'];?>
                     </td>
                      <td  width="77" class="normalfont" style="text-align:left"><?php  echo $value['ApplyHistory']['job_title'];?><br />
                      <?php  echo $value['ApplyHistory']['dt'];?>
                      </td>
                     
                      <td  width="97" class="normalfont" style="text-align:left">
                      	<?php  echo $value['ApplyHistory']['dt'];?>
                      </td>
                       <td  width="77" class="normalfont" style="text-align:left">
					   
                    <?php echo $this->Html->link('Scheduled Interviews',array('controller'=>'candidates','action'=>'scheduledInterviewList',$value['ApplyHistory']['track_id']));?>
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