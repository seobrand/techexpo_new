<?php //pr($regEvents);?>
<div id="wrapper"> <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Employer Event Preparation</h1>
          <div class="content">            
            <table class="tbl" border="0" cellpadding="4" cellspacing="2" width="100%">
            <?php /*?>   <tr>
                <td align="left" valign="middle" width="18%"><b>How To Use This Page:<br>
                  <br>
                  </b> </td>
				  <td align="left" valign="middle" width="82%">&nbsp; </td>
              </tr>
              
              <tr>
                <td align="left" valign="middle" width="18%"><?php echo $this->Html->image("images/download_icon.png",array('alt'=>"dowlnload info packet"));?></td>
                <td align="left" valign="middle" width="82%">Download documents with critical exhibitor information including start-up time, set-up procedures, shipping instructions, information about posting your jobs online and more.  </td>
              </tr>
              <tr>
                <td align="left" valign="middle"><?php echo $this->Html->image("images/create_icon.png",array('alt'=>"show profile"));?></td>                                            
                <td align="left" valign="middle"> You must complete this before attending a TECHEXPO event. This tool will use the profile and jobs you have submitted online to help you create an ad for our event directory listing, your company profile and open positions. This is also where you can fill out additional information including: number of lunch tickets required, requested phone lines, electricity, etc. </td>
              </tr>
              <tr>
                <td align="left" valign="middle"><?php echo $this->Html->image("images/ok_icon.png",array('alt'=>"OK"));?></td>
                <td align="left" valign="middle"> Indicates that your profile is complete. You can click here to make changes. </td>
              </tr>
              <tr>
                <td align="left" valign="middle"><?php echo $this->Html->image("images/past_icon.png",array('alt'=>"past deadline"));?></td>
                <td align="left" valign="middle">
                  <p>Indicates that the deadline has been reached (10 days before the event at 9am, eg: the 4th at 9am for a show on the 14th). For updates beyond that point, please call Nancy Mathew, Events Manager, at 212.655.4505 ext. 225. or e-mail <a href="mailto:nmathew@techexpoUSA.com?subject=last minute profile change">nmathew@techexpoUSA.com</a></p>
                  </font> </td>
              </tr>
              <tr>
                <td align="left" valign="middle"><?php echo $this->Html->image("images/schedule_icon.png",array('alt'=>"schedule interviews"));?></td>
                <td align="left" valign="middle"> Our site's most valuable resource: use this tool to search the resumes of candidates that have pre-registered for the event. You can then schedule interviews with them in advance. If you have scheduled interviews, you can access the list of your interviewees by clicking on the <b>"Display list"</b> link (under the "Interview list" column). If you haven't scheduled interviews yet, this will indicate "no interview requests". </td>
              </tr>
              <tr>
                <td align="left" valign="middle"><?php echo $this->Html->image("images/travel_icon.png",array('alt'=>"travel directions"));?></td>
                <td align="left" valign="middle"> Detailed travel directions to the event. </td>
              </tr>
              <tr>
                <td align="left" valign="middle" colpan="2"><br>
                </td>
              </tr><?php */?>
            </table>
            <font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="003399"> <b>You are registered for the following current TECHEXPO events:<br>
            <br>
            </b></font>
			<?php if($this->Paginator->numbers()):?>
			 <br />
            <div class="pager_panel">
              <div class="pager">
                <div class="paging"> <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $this->Paginator->numbers();?> | <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
				 </div>
                <div class="clear"></div>
              </div>
            </div>
			<br />
			<?php endif;?>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tableWhd">
              <tr>
                <td class="table_hd" width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                      <th width="144" style="text-align:left">Event Info</th>
                      <th width="74" style="text-align:left">Exhibitor manual</th>
                      <th width="74" style="text-align:left">Create show profile</th>
                   <?php /*?>   <th width="60" style="text-align:left">Interview list</th><?php */?>
                      <th width="60" style="text-align:left">View Resumes of Pre-Registered Candidates </th>
					  <th width="60" style="text-align:left">Directions</th>
                    </tr>
                  </table></td>
              </tr>
			  <?php 
			  if(count($regEvents)>0):
			  foreach($regEvents as $key => $regEvent){
			  	$right_now = time();
				$showdate = $regEvent['Show']['show_dt'];
				//$right_then1 = mktime(0, 0, 0, date("m", $date1), date("d", $date1)+1, date("Y", $date1)); 
				
				$right_then1 =   strtotime (  $showdate ) ;
			//	$right_then1 = strtotime ( '-10 day' , strtotime (  $showdate ) ); // task id  2523
			
				$right_then1 = date('d-m-Y',$right_then1)." 09:00:00";
				
				//$cutoff_time="2:00:00 PM";
				//$right_then2=$right_then1." ".$cutoff_time;
				$right_then=strtotime($right_then1);
				
			  ?>
              <tr>
                <td class="table_row border_bottom" width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                      <td width="144" style="text-align:left"><a href="<?php $this->webroot; ?>eventinfo/<?php echo $regEvent['Show']['id'] ?>"><?php echo $regEvent['Show']['show_name']; ?><br/><?php echo date(DATE_FORMAT,strtotime($regEvent['Show']['show_dt']));?></a></td>
					  
                      <td width="74" style="text-align:left" class="normalfont"><?php if(strlen($regEvent['Show']['show_confirm_file'])>1  && file_exists('ShowsDocument/showConfirmFile/'.$regEvent['Show']['show_confirm_file'])){?><a href="<?php echo $this->webroot;?>ShowsDocument/showConfirmFile/<?php echo $regEvent['Show']['show_confirm_file'];?>" target="_blank"><?php echo $this->Html->image("images/download_icon.png",array('alt'=>"dowlnload info packet"));?></a><?php }else{?> No file available<?php } ?></td>
					  
                      <td width="74" style="text-align:left" class="normalfont"><?php if($right_now > $right_then){?><?php echo $this->Html->image("images/past_icon.png",array('alt'=>"past deadline"));?><?php }else{ echo $this->Html->link($this->Html->image("images/create_icon.png",array('alt'=>"past deadline")), array("controller"=>"folders","action"=>"createxhibitorprofile",$regEvent['ShowEmployer']['show_id'],$regEvent['ShowEmployer']['employer_id']),array('escape' => false)); } ?></td>
					  
                   <?php /*?>   <td width="60" style="text-align:left" class="normalfont"><?php $intervCount = $common->interviewCount($regEvent['ShowEmployer']['show_id'],$regEvent['ShowEmployer']['employer_id']); if($intervCount>0){ echo $this->Html->link("Display List", array("controller"=>"employers","action"=>"eventInterviewList",$regEvent['ShowEmployer']['show_id'],$regEvent['ShowEmployer']['employer_id'])); }else{?> No interview requests<?php } ?></td><?php */?>
					  
                      <td width="60" style="text-align:left" class="normalfont">
					  <?php echo $this->Html->link("Search Resumes",array('controller'=>'folders','action'=>'searchRegCandidate'), array('escape'=>false));?>
                      <?php // echo $this->Html->link($this->Html->image("images/schedule_icon.png",array('alt'=>"schedule interviews")),array('controller'=>'folders','action'=>'searchRegCandidate'), array('escape'=>false));?>  
                      </td>
					  
					  <td width="60" style="text-align:left" class="last normalfont"><?php echo $this->Html->link($this->Html->image("images/travel_icon.png",array('alt'=>"travel directions")),array('controller'=>'employers','action'=>'traveldirection',$regEvent['Show']['id']),array('escape'=>false));?></td>
                    </tr>
                  </table></td>
              </tr>
              <?php  } // endoreach
			  else: 
				?>
				<tr>
                <td class="table_row" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="6"> You do not seem to be registered for any TECHEXPO events. If you feel this is a mistake, please contact <b>Nancy Mathew, Events Manager, at 212.655.4505 ext. 225.</b> Thank you.</td>
                    </tr>
                  </table></td>
              </tr>
			<?php endif;?>
            </table>
			 <br />
			<?php if($this->Paginator->numbers()):?>
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
			<?php endif;?>
			<br />
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label> <?php echo $this->Html->link('Exhibitor Resources',array('controller'=>'employers','action'=>'empexhibitor'));?></a></label>
                  <div class="form_rt_col1">
                    <label> Need promotional items to hand out at the event ? Need a display booth ? Click on this "exhibitor resources" button to purchase these tradeshow items at a great discount through our preferred vendors.</label>
                  </div>
                </li>
				<li>
                  <label> <?php echo $this->Html->link('Event Registration Form',array('controller'=>'employers','action'=>'eventregistrationform'));?></a></label>
                  <div class="form_rt_col1">
                    <label> Download the TECHEXPO registration forms to fulfill your recruiting needs at one of our upcoming events. Note: these documents are in PDF format and require Adobe Acrobat Reader. A link to Adobe's download area is provided on the registration form screen. </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> </div>
</div>
