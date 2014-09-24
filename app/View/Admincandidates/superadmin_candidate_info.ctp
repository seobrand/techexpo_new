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
<?php echo $this->Form->create('Admincandidates', array('action'=>'','enctype'=>'multipart/form-data','type'=>'get'));?>
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
                <div style="float:left;">Candidate Login LOOKUP / E-mail Login / Update Profile</div>
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
        <table>
          <tbody>
            <tr>
              <td valign="middle" align="right" width="25%">Enter search criterion:</td>
              <td valign="middle" align="left" width="74%">
                <?php echo $this->Form->input('candidate_title',array('class'=>'inputbox1','div'=>false,'label'=>false)); ?>
              <div class="error-message"><?php echo $searcTextError;?></div>
              </td>
            </tr>
            <tr>
              <td valign="middle" align="right">This is the candidate's:</td>
              <td valign="middle" align="left">
                <?php 
                   $option=array('candidate_name'=>'Name','candidate_email'=>'E-mail','username'=>'User Name');
                   echo $this->Form->input('search',array('type'=>'select','options'=>$option,
				   																'empty'=>false,
																				'label'=>false,'div'=>'','class'=>'listbox'));
                ?>
               </td>
            </tr>
            <tr>
              <td valign="middle" align="right"></td>
              <td valign="middle" align="left">
              
              <?php
               echo $this->Form->input('SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'UPDATE')); ?>
               
           <input type="submit" name="operation"  class="cursorclass ui-state-default ui-corner-all" value="Find!"></td>
            </tr>
          </tbody>
        </table>
     
        
        <?php 
		if($SearchResult) {
		if(count($CandidateREC)) {?>
        <br /><br />
        <br /><br />
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
                <div style="float:left;">Login Lookup Search Results</div>
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
			
			 foreach($CandidateREC as $value) {?>    
                <p><strong>Candidate name: <?php echo $value['Candidate']['candidate_name']; ?></strong><br />
                Candidate phone: <?php echo $value['Candidate']['candidate_phone']; ?><br />
                Candidate ID: <?php echo $value['Candidate']['id']; ?><br />
                Candidate e-mail: <?php echo $value['Candidate']['candidate_email']; ?><br />
                Candidate username: <?php echo $value['User']['username']; ?><br />
                Candidate password: <?php echo $value['User']['old_password']; ?><br />
                <?php
					echo $this->Html->link('Delete account & resumes',array('action'=>'',$value['Candidate']['id'],'delete'),
																		array('class'=>'confirm_delete','onClick'=>'return confirmfrmSubmit()'));
				?>
               <br />
			   <?php
					echo $this->Html->link('Send login to candidate',array('action'=>'',$value['Candidate']['id'],'LoginInfo'),
																		array('class'=>'confirm_delete'));
				?><br />
                
                
                
                <?php
					echo $this->Html->link('Update candidate info',array('controller'=>'admincandidates','action'=>'updateCandidateInfo',$value['Candidate']['id']),array('class'=>'confirm_delete'));
				?><br />
                
                
                </p>
                <br />
            <?php 
			
			}?>
            
	 </div>
    </div>
 </div>
 
 <div class="pager">
                <div class="paging"> <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $this->Paginator->numbers(array('pages' => 2));?> | <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?> </div>
                
                <div class="clear"></div>
              </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
        <?php }
		else{ ?>
            No Record Found
            <?php } } 
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
<?php echo $this->Form->end();?>