<?php  	echo $this->Html->script('front_js/jquery-ui-1.7.2.custom.min.js'); ?>
<style type="text/css">
.column{
	 min-height: 300px;
	 
}
.column .dragbox{
	margin:5px;
	background:#fff;
	position:relative;
	
}
.column .dragbox h4{
	margin:0;
	background:#f0f0f0;
	cursor:move;
}


.column  .placeholder{
	 border: 1px dotted black; visibility: visible !important; height: 50px !important;
}

</style>
<script type="text/javascript">
$(function(){
	
	   $('.column').sortable({
		connectWith: '.column',
		handle: 'h4',
		cursor: 'move',
		placeholder: 'placeholder',
		forcePlaceholderSize: true,
		opacity: 0.4,
        stop: function(event, ui){  
            saveState();
        }
})
.disableSelection();

function saveState(){
    var items = [];
    // traverse all column div and fetch its id and its item detail. 
    $(".column").each(function(){
        var columnId = $(this).attr("id");
		$(".dragbox", this).each(function(i){ // here i is the order, it start from 0 to...
           var item = {
               id: $(this).attr("id"),
               column_no: columnId,
               order: i,
			   widget:$(this).attr("title")
           }
           items.push(item);
        });
        
    });
    $("#results").html("loading..");
    var shortorder = {items : items};
        $.ajax({
          url: "<?php echo $this->webroot; ?>employers/dashboardsort",
          async: false, 
          data: shortorder,
          dataType: "html",
          type: "POST",
          success: function(html){
			// alert(html);
            $("#results").html(html);
          }
        });    
}



});
</script>
<div id="wrapper">
	<?php
	$theComponent = new commonComponent(new ComponentCollection());
	 echo $this->element('employer_tabs');
	 

	 ?>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head border_top"></div>
        <div class="whiteB_mid border_mid">
          <div class="whiteB_bottom border_btm">
            <div class="content">
              <div class="dashboard_row">
              
              <div class="announcements_panel">
               <h4 class="dash_heading">Special Announcement</h4>
               
                  <ul class="dash_act_job">
                    <li><a href="">Construction Event has been postponed to 17-july-2012. </a></li>
                                       
                   
                  </ul>
                  
              </div>
      	        <!-- This is first column -->
				
                 
                   <div id="column_1" class="column"> 
                  <?php foreach($dashboard_items[0] as $col){  ?>  
                 <div class="dragbox" id="item_<?php echo $col['order']?>" title="section_1">
   				 <!-- this one is first item of 1st column -->
                <div class="dashboard_col_lf">
                  <h4 class="dash_heading">Employer Preparation</h4>
                  <div class="step_panel">
                    <div class="steps">Step<br />
                      1</div>
                    <div class="step_detail">Enter/Update corporate profile </div>
                    <div class="clear"></div>
                  </div>
                  <div class="step_panel">
                    <div class="steps">Step<br />
                      2</div>
                    <div class="step_detail">Enter/Update job postings </div>
                    <div class="clear"></div>
                  </div>
                  <div class="step_panel">
                    <div class="steps">Step<br />
                      3</div>
                    <div class="step_detail">Show Specifics: # of staff, booth size,  
                      electric/telephone needs </div>
                    <div class="clear"></div>
                  </div>
                  <div class="step_panel">
                    <div class="steps">Step<br />
                      4</div>
                    <div class="step_detail">To ensure a successful event </div>
                    <div class="clear"></div>
                  </div>
                  <div class="alignright">
                  <?php echo $this->Html->link($this->Html->image("images/view_more.jpg"), array('controller'=>'employers','action'=>'emppostjob'),array('class'=>'f_right padding_right view_edit','escape'=>false));?>
                  </div>
                </div> </div>
              
                 
                  <div id="item_<?php echo $col['order']?>" class="dragbox" title="section_2">
                  
                  <!-- this one is second item of 1st column -->
                <div class="dashboard_col_rt">
                   
                  <h4 class="dash_heading">Active Jobs</h4>
                  <ul class="active_job_heading">
               <li class="jobname">Job Name</li>
                              <li class="view_edit">View</li>
                                             <li class="view_edit">Edit</li>
                                                                                          <li>Delete</li>
               
               </ul>
               <div class="clear"></div>
                  <ul class="dash_act_job with_action">
                   <?php if(count($joblists)>0):
			   foreach ($joblists as $K=> $joblist):
			  ?>
                    <li> <span class="f_left jobname"><?php echo $joblist['JobPosting']['job_title'];  ?></span><span class="f_right"> 
                          
						  <?php echo $this->Html->link($this->Html->image("images/trash.jpg"), array('controller'=>'employers','action'=>'dashboard',$joblist['JobPosting']['posting_id']),array('class'=>'f_right padding_right view_delete','escape'=>false ,'confirm' => 'Are you sure to delete folder?'));?>
               
                         <?php echo $this->Html->link($this->Html->image("images/edit1.jpg"), array('controller'=>'employers','action'=>'empeditjob',$joblist['JobPosting']['posting_id']),array('class'=>'f_right padding_right view_edit','escape'=>false));?>
                    <?php echo $this->Html->link($this->Html->image("images/preview.jpg"), array('controller'=>'employers','action'=>'jobdetail',$joblist['JobPosting']['posting_id']),array('class'=>'f_right padding_right view_edit','escape'=>false));?>
                    </span>  <div class="clear"></div></li>
                      <?php endforeach;
				else: 
				?>
              <tr>
                <td class="table_row" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="8">No Jobs Found</td>
                    </tr>
                  </table></td>
              </tr>
              <?php endif;?>               
                   
                  </ul>
                  
                  
                  <div class="alignright viewmore_active">
                    <?php echo $this->Html->link($this->Html->image("images/view_more.jpg"), array('controller'=>'employers','action'=>'joblists'),array('escape'=>false)); ?>
            
                  </div>
                </div>
                </div> 
                    <?php } ?>
              
                 </div>
            
                
                <div class="clear"></div>
              </div>
              <div class="dashboard_row">
              
              <!-- 2nd Column -->
                  <div id="column_2" class="column"> 
                       <?php foreach($dashboard_items[2] as $col){ ?>
                    
                  <div id="item_<?php echo $col['order']?>" class="dragbox" title="section_3">
                <div class="dashboard_col_lf">
  <h4 class="dash_heading">Your Corporate Videos</h4>
                  
                    <?php  echo $this->Html->image("images/video_dashboard.jpg"); ?>
                  <div class="viewmore_active">
                    <a href="emp-seekers-video.html" class="f_left">
                    <?php  echo $this->Html->image("images/upload_videos.jpg"); ?>
                    </a>  <a href="emp-seekers-video.html" class="f_right">
                    <?php  echo $this->Html->image("images/manage_videos.jpg"); ?>
                    </a>
                  </div>
                </div>
                </div>
               
               
                    <!-- this one is second item of 2st column -->
              
 			 <div id="item_<?php echo $col['order']?>" class="dragbox" title="section_4">
                <div class="dashboard_col_rt">
                 <?php echo $this->Form->create('Folders',array('action'=>'searchRegResult','type'=>'GET'));?>
                  <h4 class="dash_heading">Search Resumes</h4>
                  <ul class="dash_search_list">
                    <li>
                      <label>Keywords:</label>
                      <br />
                      <p>
                       
                         <?php echo $this->Form->input('keyword',array('class'=>'dash_textField','div'=>false,'label'=>false)); ?>
                      </p>
                    </li>
                    <li>
                      <label>Select Database:</label>
                      <br />
                      <?php 
                         echo $this->Form->input('event_list',array('type'=>'select','multiple'=>'multiple','options'=>$event_list,'empty'=>'-Seletc Event-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;column:50;row:150;width:290px;')); ?>
                      
                    </li>
                    <li>
                      <label>Citizenship Status:</label>
                      <br />
                      <p class="dropdown_dash">
                            <?php  $citizen_list = $theComponent->getCitizenShipList();
					 echo $this->Form->input('citizen_status_code',array('label'=>'','options'=>$citizen_list,'type'=>'select','style'=>'font-size: x-small; font: x-small;','error'=>false,'div'=>false,'label'=>false));
					   ?>
                      </p>
                    </li>
                    <li>
                      <label>Location:</label>
                      <br />
                  
                      
                        <?php  $state_list = $theComponent->getStateList();
                         echo $this->Form->input('state_list',array('type'=>'select','multiple'=>'multiple','options'=>$state_list,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;column:50;row:150;width:290px;')); ?>
                    </li>
                  
                    
                     <li class="last">
                    <label>Job by Clearance Type:</label>
                    <br />
                    <!--   <p class="dropdown_dash"> </p>-->
                    <?php  $cleareance_list = $theComponent->getGovCleareanceList();
                         echo $this->Form->input('cleareance_list',array('type'=>'select','multiple'=>'multiple','options'=>$cleareance_list,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;column:50;row:150;width:290px;')); ?>
                  </li>
                  </ul>
                  <div class="alignright viewmore_active">
           <?php echo $this->Form->submit('images/grey_submit.jpg');?>
                  </div><?php $this->end();?>
                </div>
                 
                 </div>   <?php } ?></div>
                
               
                 
                <div class="clear"></div>
              </div>
            </div>
          </div>
        </div>
        <br />

               <div class="whiteB_head blue_head">
          
          <div class="blue_head_lf">Recent Applicants</div>
                    <div class="blue_head_rt"></div>
                    <div class="clear"></div>
          
          
          </div>
      		  <div class="whiteB_mid border_mid">
          <div class="whiteB_bottom border_btm">
          <div class="padding_dashboard employee_fixheight">
      <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th width="135" style="text-align:left">Seeker's Name</th>
                        <th width="135" style="text-align:left">Applied Job</th>
                        <th width="120" style="text-align:left">Date</th>
                          <th width="110" style="text-align:left">Experience</th>
                                               
                      </tr>
                    </table></td>
                </tr>
             <?php  if(count($apply_list)){
			 	foreach($apply_list as  $apply_list) { 
			  ?>
                 <tr>
                  <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  width="135" style="text-align:left"><a href=""><?php echo $apply_list['Candidate']['candidate_name'];   ?></a></td>
                        <td  width="135" class="normalfont" style="text-align:left" valign="middle"><?php echo $apply_list['ApplyHistory']['job_title'];   ?></td>
                        <td  width="120" class="normalfont" style="text-align:left"><?php echo $apply_list['ApplyHistory']['dt'];   ?></td>
                         <td  width="110" class="normalfont" style="text-align:left"><?php echo   $theComponent->getExperienceValue($apply_list['Candidate']['experience_code']);    ?></td>
                   
                      </tr>
                    </table></td>
                </tr>
               <?php  }
			   } ?> 
          
          
                
          
               
        
        
              </table><br />

<div class="alignright viewmore_active">
                  
                      <?php echo $this->Html->link($this->Html->image("images/viewall.jpg"), array('controller'=>'employers','action'=>'empinterview'),array('escape'=>false)); ?>
                  </div>
                  <br />

          
        </div>  
          </div>
          </div>
         
          
      </div>
      <?php echo $this->element('employer_left_panel');?>
      <div class="clear"></div>
      <?php echo $this->element('scroll_panel');?>
    </div>
  </div> 