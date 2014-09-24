<script type="text/javascript">
function confirmfrmSubmit()
{
	var agree=confirm("Are you sure to continue?");
	
	if (agree)
		return true ;
	else
		return false ;
}
</script>

<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Manage Resumes
           
          </h1>
          <div class="content"> <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?> 
            <ul class="list">
              <li>You can preview your resume as employers will view it. You can also test the resume download to see if your attached Word or PDF documents properly show on your pasted-in resume by following the "click for preview link.</li>
              <li><strong></strong>To attach a document to your resume, simply click "submit/edit a resume." Upon submitting your resume form you will be prompted to upload a file.</li>
              <li>Our matching feature will bring you a recent list of jobs best fitting your profile. We match based on the core skills you selected in the pull-down menu upon submitting your resume alongside your geographical location and preferences for relocation.</li>
            </ul>
            <?php echo $this->Form->create('Resume',array('action'=>'resumelist', 'enctype' => 'multipart/form-data')); ?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr class="tableHead">
                  <th width="109">Resume Title</th>
                  <th width="135">Preview/ Edit Resume</th>
                  <th width="135">Matching Jobs</th>
                  <th width="111">Last updated</th>
                  <th width="71">Delete</th>
                  <th width="81">Refresh</th>
                </tr>
              </thead>
              <tbody>
                <?php
			  if(count($resumeRec))
			  {
			   for($i=0;$i<count($resumeRec);$i++){ ?>
                <tr class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom"> 
                  <td><?php echo $resumeRec[$i]['Resume']['resume_title']; ?></td>
                  <td ><?php echo $this->Html->link('Preview',array('controller'=>'resumes','action'=>'viewResume/'.$resumeRec[$i]['Resume']['id']));?> / <?php echo $this->Html->link('Edit',array('controller'=>'resumes','action'=>'edit_resume/'.$resumeRec[$i]['Resume']['id']));?> </td>
                  <td> <?php echo $this->Html->link('Matching',array('controller'=>'candidates','action'=>'autoMatching/'.$resumeRec[$i]['Resume']['id']));?></td>
                  <td><?php echo date(DATE_FORMAT,strtotime($resumeRec[$i]['Resume']['modified']))?></td>
                  <td>
                    <input type="radio" name="data[Resume][action][<?php echo $resumeRec[$i]['Resume']['id'];?>]" value="delete" />
                  </td>
                  <td class="last"><input type="radio" name="data[Resume][action][<?php echo $resumeRec[$i]['Resume']['id'];?>]" value="refresh" />
                  </td>
                </tr>
                <?php } 
			  ?>
               
                <tr>
                  <td colspan="6"><div class="man_resume_footer"  style="padding-top:0px !important">
                      <ul>
                        <li class="last"> <?php echo $this->Form->submit('images/delete_refresh.jpg',
													array('class'=>'delete_btn','onClick'=>'return confirmfrmSubmit()'));?> </li>
                      </ul>
                      <div class="clear"></div>
                    </div></td>
                </tr>
                <?php
			  }else
			  {?>
                <tr>
                  <td align="center"  colspan="6"><strong>No Record Found</strong> </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php echo $this->Form->end(); ?> 
            
            
            
            <ul class="list">
              <li><strong class="bluecolor">Attach Multiple Resumes : &nbsp;</strong>
You can attach multiple resumes to your profile and then designate a specific resume to be submitted when applying for positions through this site. Use the button below to add additional resumes to your profile.</li>
		
            
            </ul>
        	 <div >
              <?php  
		  echo $this->Html->link($this->Html->image('images/upload_resume.jpg'),array('controller'=>'resumes','action'=>'upload_resume'),array('escape'=>false)); 
		  ?>
            </div>    
            </div>
            
            
            
            
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>