<script type="text/javascript">
function confirmfrmSubmit()
{
	var agree=confirm("Are you sure you wish to continue?");
	
	if (agree)
		return true ;
	else
		return false ;
}
</script>
<?php
 $this->set('title_for_layout', 'Add new Client'); ?>

<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;"><?php if($CandidateExits)
			{
			  ?>Candidate Detail
              <?php }else{ ?>
              Candidate List
              <?php } ?>
              </div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
    <div class="display_row">
      <div class="table">
        
     
        
        <?php 
		
		if(count($CandidateREC)) {?>
       
        <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          
    <div class="display_row">
      <div class="table">
        
    
			<?php
			if($CandidateExits)
			{
			 
			 ?>   
             
             <table>
             	<tr>
                	<td width="20%"><p><strong>Candidate name:</strong><br /></p></strong></td>
                    <td><?php echo $CandidateREC['Candidate']['candidate_name']; ?></td>
                </tr>
                <tr>
                	<td><p><strong>Candidate phone:</strong><br /></p></strong></td>
                    <td><?php echo $CandidateREC['Candidate']['candidate_phone']; ?></td>
                </tr>
                	<tr>
                	<td><p><strong> Candidate ID:</strong><br /></p></strong></td>
                    <td><?php echo $CandidateREC['Candidate']['id']; ?></td>
                </tr>
                	<tr>
                	<td><p><strong>Candidate e-mail:</strong><br /></p></strong></td>
                    <td><?php echo $CandidateREC['Candidate']['candidate_email']; ?></td>
                </tr>
                	<tr>
                	<td><p><strong>Candidate username:<br /></p></strong></td>
                    <td><?php echo $CandidateREC['User']['username']; ?></td>
                </tr>
                
                <tr>
                	<td><p><strong>Candidate password:<br /></p></strong></td>
                    <td><?php echo $CandidateREC['User']['old_password']; ?></td>
                </tr>
                
                <tr>
                	<td colspan="2">
                    	<?php
					echo $this->Html->link('Update candidate info',array('controller'=>'admincandidates','action'=>'updateCandidateInfo',$CandidateREC['Candidate']['id']),array('class'=>'confirm_delete'));
				?>
                    </td>
                </tr>
                 <tr>
                	<td colspan="2">
                    	<?php
					echo $this->Html->link('Send login to candidate',array('action'=>'candidateInfo',$CandidateREC['Candidate']['id'],'LoginInfo'),
																		array('class'=>'confirm_delete'));
				?>
                    </td>
                </tr>
                
                 <tr>
                	<td colspan="2">
                    	<?php
							echo $this->Html->link('Delete account & resumes',array('action'=>'candidateInfo',$CandidateREC['Candidate']['id'],'delete'),
																		array('class'=>'confirm_delete','onClick'=>'return confirmfrmSubmit()'));
						?>
                    </td>
                </tr>
             </table> 
                 
                
               
              
              
                
                
             
                
                </p>
                <br />
            <?php 
			
			}
			else
			{
			
			 foreach($CandidateREC as $value) {
			 ?>
             <table>
             	<tr>
                	<td width="20%"><p><strong>Candidate name:</strong><br /></p></strong></td>
                    <td><?php echo $value['Candidate']['candidate_name']; ?></td>
                </tr>
                <tr>
                	<td><p><strong>Candidate phone:</strong><br /></p></strong></td>
                    <td><?php echo $value['Candidate']['candidate_phone']; ?></td>
                </tr>
                	<tr>
                	<td><p><strong> Candidate ID:</strong><br /></p></strong></td>
                    <td><?php echo $value['Candidate']['id']; ?></td>
                </tr>
                	<tr>
                	<td><p><strong>Candidate e-mail:</strong><br /></p></strong></td>
                    <td><?php echo $value['Candidate']['candidate_email']; ?></td>
                </tr>
                	<tr>
                	<td><p><strong>Candidate username:<br /></p></strong></td>
                    <td><?php echo $value['User']['username']; ?></td>
                </tr>
                
                <tr>
                	<td><p><strong>Candidate password:<br /></p></strong></td>
                    <td><?php echo $value['User']['old_password']; ?></td>
                </tr>
                
                <tr>
                	<td colspan="2">
                    	<?php
					echo $this->Html->link('Update candidate info',array('controller'=>'admincandidates','action'=>'updateCandidateInfo',$value['Candidate']['id']),array('class'=>'confirm_delete'));
				?>
                    </td>
                </tr>
                 <tr>
                	<td colspan="2">
                    	<?php
					echo $this->Html->link('Send login to candidate',array('action'=>'candidateInfo',$value['Candidate']['id'],'LoginInfo'),
																		array('class'=>'confirm_delete'));
				?>
                    </td>
                </tr>
                
                 <tr>
                	<td colspan="2">
                    	<?php
							echo $this->Html->link('Delete account & resumes',array('action'=>'candidateInfo',$value['Candidate']['id'],'delete'),
																		array('class'=>'confirm_delete','onClick'=>'return confirmfrmSubmit()'));
						?>
                    </td>
                </tr>
             </table>
             
                 
            
                
                
                <br /><br /><br />
                <br />
            <?php 
			
			}
			 ?>
             
             <div class="pager">
                <div class="paging"> <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $this->Paginator->numbers(array('pages' => 2));?> | <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?> </div>
                
                <div class="clear"></div>
              </div>
             <?php
			 
			 } ?>

            
	 </div>
    </div>
 </div>
 
 
        <!-- end table --> 
      </div>
    </div>
  </div>
        <?php }
		else{ ?>
            No Record Found
            <?php } 
		?>
      </div>
    </div>
 </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>
