<div id="wrapper">
  <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Scheduled Interview List</h1>
          <div class="content">
             <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
              	  <tr class="tableHead">
                      <th width="88"><?php echo $this->Paginator->sort('Candidate.candidate_name',"Seeker's Name"); ?></th>
                      <th width="88"><?php echo $this->Paginator->sort('Show.show_name'," Event's Name"); ?></th>
                      <th width="68"><?php echo $this->Paginator->sort('Show.show_dt',' Date / Time'); ?></th>
                      <th width="88">Interview</th>
                  </tr>
                 </thead>
              <?php 
			  $i=1;
			  foreach($InterviewRec as $key=>$value){?>
                  <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                        <td  width="88">
                        <?php echo $value['Candidate']['candidate_name'];?>
                        </td>
                        <td  width="88"><?php echo $value['Show']['show_name'] ?> </td>
                        <td  width="68"><?php echo date(DATE_FORMAT,strtotime($value['Show']['show_dt'])); ?><br />
                        <?php echo $value['Show']['show_hours'] ?>
                        </td>
                        <td  width="88">
                        <?php 
                        if(empty($value['ShowInterview']['status']))
                        {
                        echo $this->Html->link('Accept',array('controller'=>'candidates','action'=>'InterviewLists',$value['ShowInterview']['show_id'],$value['ShowInterview']['candidate_id'],$value['ShowInterview']['employer_id'],'ACCEPT'));?>
                        
                        <?php echo $this->Html->link('Denied',array('controller'=>'candidates','action'=>'InterviewLists',$value['ShowInterview']['show_id'],$value['ShowInterview']['candidate_id'],$value['ShowInterview']['employer_id'],'DENIED'));
                        }else
                        {
                        echo $value['ShowInterview']['status'];
                        }
                        ?>
                        <br />
                        
                        
                        <?php echo $this->Html->link('Delete',array('controller'=>'candidates','action'=>'InterviewLists',$value['ShowInterview']['show_id'],$value['ShowInterview']['candidate_id'],$value['ShowInterview']['employer_id'],'delete'),array('onclick'=>"return confirm('Are you sure you want to delete? Delete it your own risk')"));
                        ?>
                        </td>
                    </tr>
              <?php 
			  $i=$i+1;
			  } ?>
            
            <?php if(count($InterviewRec) >0){ ?>
            
            <tr>
            	<td colspan="4">
                	<div class="pager_panel">
              <div class="pager">
                <div class="paging">
                
                   <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                  <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;&nbsp;'));?>
                  <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
                 
                  </div>
               
                <div class="clear"></div>
              </div>
            </div>
                </td>
            </tr>
            <?php }else{ ?>
           
           <tr>
            	<td colspan="4" align="center" class="border_bottom">
                	No Record Found
            	</td>
            </tr>
            <?php 
			
			}
			?>
            
            </table>
          </div>
        </div>
      </div>
    </div>
    	<?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    	<?php echo $this->element('partners', array('cache' => true)); ?> 
  </div>
</div>