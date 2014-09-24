<div id="wrapper">
  <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Schedule Interview Of Candidates</h1>
             <?php echo $this->Form->create('Employer',array('name'=>'empinterview','id'=>'empinterview'));?>
          <div class="content">            
            <br />
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr class="tableHead">
                      <th width="115">Seeker's Name</th>
                      <th width="125">Applied Job</th>
                      <th width="115">Event's Name</th>
                      <th width="95" >Date / Time</th>
                      <th width="75">Interview</th>
                   </tr>
     			</thead>
                <tbody>
     		<?php
			if(count($apply_list))
			{
			 $i='0';  foreach($apply_list as  $apply_list) {  ?>
             <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                      <td  width="115" style="text-align:left">
                
       <?php echo $this->Html->link($apply_list['Candidate']['candidate_name'], array('controller'=>'folders','action'=>'showResume',$apply_list['ApplyHistory']['resume_id']),array('escape'=>false,'target'=>'blank')); ?>
                      </td>
                      <td  width="125" class="normalfont" style="text-align:left" valign="middle"><?php echo $apply_list['ApplyHistory']['job_title'];   ?></td>
                      <td  width="115" class="normalfont" style="text-align:left">
					  <?php  // $getfilterEvents =  $common->getfilterEvents($value);
					//  echo $this->Form->input('Candidate.show_id',array('label'=>'','options'=>$events,'type'=>'select','error'=>false));  ?>
                       <select  name="data[Candidate][show_id][]"  style="width:120px !important;">
                          <option value=''>select event</option>
                          <?php 
						  if(count($events) > 0) {
						  foreach ($events as  $event){  ?>
                          <option  value="<?php echo $event['Show']['id']; ?>"><?php echo $event['Show']['show_name'].'-'.date(DATE_FORMAT,strtotime($event['Show']['show_dt'])); ?></option>
                          <?php } }  else { ?>
                          
         				<option >No Event</option>                 
                          <?php }  ?>
                        </select>
                      </td>
                      <td  width="95" class="normalfont" style="text-align:left"><?php echo date(DATE_FORMAT,strtotime($apply_list['ApplyHistory']['dt'])); ?></td>
                      <td  width="75" class="normalfont last" style="text-align:center">
                       <input type="checkbox" name="data[Candidate][id][<?php echo $i;  ?>]" value="<?php echo $apply_list['Candidate']['id']?>-<?php echo $apply_list['ApplyHistory']['posting_id']?>" id="candidate_id<?php echo $apply_list['Candidate']['id'];?>" /></td>
              </tr>
     		<?php $i++; } }else
			{
			?>
            <tr>
            	<td colspan="5"  class="tablebody border_bottom" align="center">
                	No Record Found
                </td>
            </tr>
            <?php
				
			}?>
            <tbody>
            </table>
            <br />
            <div class="alignright">
                     <?php echo $this->Form->submit('images/submit.jpg',array('div'=>false,'name'=>'Submit'));?>
            </div>
          </div>
            <?php echo $this->Form->end();?>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> 
  </div>
</div>
