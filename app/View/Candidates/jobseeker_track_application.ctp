<?php   
echo $this->Html->script('front_js/jquery.colorbox.js');
echo $this->Html->css('front_css/colorbox.css');
?>
<script>
	$(document).ready(function(){
				$(".inline").colorbox({inline:true, width:"530px"});
				
	});
</script>

<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Track Job Applications</h1>
          <div class="content">
            <ul class="list">
              <li> Your job application history goes back 4 months (older job application archives are deleted)</li>
              <li>Click on a column heading to sort by the corresponding criteria.</li>
            </ul>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
              	  <tr class="tableHead">
                      <th width="88"><?php echo $this->Paginator->sort('ApplyHistory.employer_name','Employer Name'); ?></th>
                      <th width="108"><?php echo $this->Paginator->sort('JobPosting.job_title','Position Title'); ?></th>
                      <th width="88"><?php echo $this->Paginator->sort('Resume.resume_title','Resume Title'); ?></th>
                      <th width="68"><?php echo $this->Paginator->sort('ApplyHistory.dt','Applied on'); ?></th>
                      <th width="88"><?php echo $this->Paginator->sort('ApplyHistory.notes','Notes'); ?></th>
             	 </tr>
             	</thead>
                 <tbody>
					  <?php 
                      $i=1;
                      foreach($seekerApplyhistory as $key=>$value){?>
                        <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                              <td  width="88"><?php echo $this->Html->link($value['ApplyHistory']['employer_name'],array('controller'=>'candidates','action'=>'employeDetail/'.$value['Employer']['id']));?> </td>
                              <td  width="108"><?php echo $this->Html->link($value['JobPosting']['job_title'],array('controller'=>'candidates','action'=>'appliedjobDetail/'.$value['JobPosting']['posting_id']));?></td>
                              <td  width="88"><?php echo $value['Resume']['resume_title'] ?> </td>
                              <td  width="68"><?php echo date(DATE_FORMAT,strtotime($value['ApplyHistory']['dt'])); ?></td>
                              <td  width="88"><a class='inline' href="#inline_content<?php echo $value['Resume']['id'] ?>"> Preview Note </a> 
                              <div style='display:none'>
                                <div id='inline_content<?php echo $value['Resume']['id'] ?>' style='background:#fff;min-height:100px;'>
                                  <div id="succMSG" style="color:#003300"></div>
                                  <div style='margin:0 auto; width:482px;'> <br/>
                                    <br/>
                                    <?php  echo $value['ApplyHistory']['notes'] ?>
                                  </div>
                                </div>
                              </div>
                              </td>
                            </tr>
                      <?php
					  $i=$i+1;
					   } ?>
                  <tr>
                    <td colspan="5">
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
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>