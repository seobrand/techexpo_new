<script type="text/javascript">


function validationCompanyName()
{

	var employerName = document.getElementById('employerName').value;
	var contactState = document.getElementById('contactState').value;
	var empTypeCode = document.getElementById('empTypeCode').value;

	// contactState empTypeCode
	if(employerName=='' && contactState=="" && empTypeCode=='')
	{
		alert('Please fill at least one search criteria');
		return false;
	}else
	{
		return true;
	}
	
	
	//alert(document.getElementById('employerName').value());
	
}
</script>

<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Research Companies</h1>
          <div class="content">
            <ul class="list">
              <li>Click on a link to view the company's full profile and available positions. The information will appear in a new window.</li>
              <li>Click on one of these links to access companies whose names start with a letter
                in one of the following letter ranges: <?php echo $this->Html->link('a-c',array('controller'=>'candidates','action'=>'searchCompanies?start=a,b,c'));?>&nbsp;&nbsp;&nbsp; <?php echo $this->Html->link('d-f',array('controller'=>'candidates','action'=>'searchCompanies?start=d,e,f'));?>&nbsp;&nbsp;&nbsp; <?php echo $this->Html->link('g-k',array('controller'=>'candidates','action'=>'searchCompanies?start=g,h,i,j,k'));?>&nbsp;&nbsp;&nbsp; <?php echo $this->Html->link('l-o',array('controller'=>'candidates','action'=>'searchCompanies?start=l,m,n,o'));?>&nbsp;&nbsp;&nbsp; <?php echo $this->Html->link('p-s',array('controller'=>'candidates','action'=>'searchCompanies?start=p,q,r,s'));?>&nbsp;&nbsp;&nbsp; <?php echo $this->Html->link('t-z and numeric',array('controller'=>'candidates','action'=>"searchCompanies?start=t,u,v,w,x,y,z&num=1"));?>&nbsp;&nbsp;&nbsp; </li>
            </ul>
            <div class="man_resume_footer top_header"> 
			<?php echo $this->Form->create('Candidates',array('controller'=>'Candidates','action'=>'searchCompanies','type'=>'GET'));?>
              <table>
                <tr>
                  <td>Industry: </td>
                  <td><div class="form_rt_col1" style="margin-left:30px;">
                      <div class="dropdown_237"> <?php echo $this->Form->input('Candidates.employer_type_code',array('type'=>'select','options'=>$industryList,'label'=>false,'div'=>false,'class'=>'big237_textfield','empty'=>'Please Select Industry','id'=>'empTypeCode'));?> </div>
                    </div></td>
                </tr> 
                <tr>
                  <td colspan="2" height="10px;"></td>
                </tr>
                <tr>
                <tr>
                  <td>State: </td>
                  <td><div class="form_rt_col1" style="margin-left:30px;">
                      <div class="dropdown_237"> <?php echo $this->Form->input('Candidates.contact_state',array('type'=>'select','empty'=>'Please Select State','options'=>$stateList,'label'=>false,'div'=>false,'class'=>'big237_textfield','id'=>'contactState'));?> </div>
                    </div></td>
                </tr>
                <tr>
                  <td colspan="2" height="10px;"></td>
                </tr>
                <tr>
                  <td  class="label" valign="middle"> Company Name: </td>
                  <td align="left"><ul style="margin:0 !important;padding:0 !important;width:200px;display:inline">
                      
                      <li>
                        <?php echo $this->Form->submit('images/submit.jpg',array('onClick'=>'return validationCompanyName()')); ?> 
                      </li>
                      <li  style="margin: 0 0 0 30px !important;padding:0 !important;width:200px;float:left"> <?php echo $this->Form->input('Candidates.employer_name',array('label'=>false,'div'=>false,'class'=>'security_txt','id'=>'employerName')); ?> </li>
                    </ul></td>
                </tr>
                <tr>
                  <td colspan="2" height="10px;"></td>
                </tr>
                
              </table>
              <?php echo $this->Form->end();?>
              <div class="clear"></div>
              <br />
            </div>
            <?php  
            if(empty($this->request->data['Candidates']['employer_name']))
            {
        		$arrayStart=explode(',',$start);
             }
             else
             {
             	$arrayStart=array('0'=>$start);
             }
			 
			 
       
        if(count($arrayStart)):
        foreach($arrayStart as $key=>$value):

   ?>
            <h2 class="mana_subheading">
              <?php  echo strtoupper($value)?>
            </h2>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="108"> <?php echo $this->Paginator->sort('Employer.employer_name','Employer'); ?> </th>
                      <th width="88"> <?php echo $this->Paginator->sort('Employer.address','Location'); ?> </th>
                      <th width="58"> Jobs </th>
                      <th width="98"> <a href="">Industry</a></th>
                      <th width="88"> <?php echo $this->Paginator->sort('Employer.number_of_employees','No. of Employees'); ?> </th>
                    </tr>
                  </table></td>
              </tr>
              <?php 
          
       
      if(empty($companyDiv))
      {
       if(count($$value)):
       	 foreach($$value as $key1=>$value1): ?>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="108"><?php echo $this->Html->link($value1['Employer']['employer_name'],array('controller'=>'candidates','action'=>'employeDetail/'.$value1['Employer']['id'])); ?></td>
                      <td  width="88"><?php echo $value1['Employer']['address']; ?> </td>
                      <td  width="58"><?php echo count($value1['JobPosting']); ?> Jobs</td>
                      <td  width="98"><?php echo $common->getIndustriesName($value1['Employer']['employer_type_code']); ?></td>
                      <td  width="88" class="last"><?php echo $value1['Employer']['number_of_employees']; ?> </td>
                    </tr>
                  </table></td>
              </tr>
              <?php endforeach;
       else:
       ?>
              <tr>
                <td class="table_row border_bottom" align="center" style="color:#CC0000"><strong> No Record Found</strong> </td>
              </tr>
              <?php
       endif;
       }else
       {
       ?>
              <tr>
                <td><?php
           if($companyList)
           {
          	 foreach($companyList as $key1=>$value1): ?>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="108"><?php echo $this->Html->link($value1['Employer']['employer_name'],array('controller'=>'candidates','action'=>'employeDetail/'.$value1['Employer']['id'])); ?> </td>
                      <td  width="88"><?php echo $value1['Employer']['address']; ?> </td>
                      <td  width="58"><?php echo count($value1['JobPosting']); ?> Jobs</td>
                      <td  width="98"><?php echo $common->getIndustriesName($value1['Employer']['employer_type_code']); ?></td>
                      <td  width="88" class="last"><?php echo $value1['Employer']['number_of_employees']; ?> </td>
                    </tr>
                  </table></td>
              </tr>
              <?php endforeach;
        }else
        {
        ?>
              <tr>
                <td class="table_row border_bottom" align="center" style="color:#CC0000"><strong> No Record Found</strong> </td>
              </tr>
              <?php
        }
        ?>
              </td>
              
              </tr>
              
              <?php
       }
       ?>
            </table>
            <br />
            <?php endforeach; 
  endif;
  ?>
            <?php if(count($empRecNonAlpha)){ ?>
            <h2 class="mana_subheading">
              <?php  echo strtoupper('Non-Alphabetically sortable names')?>
            </h2>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="108"> <?php echo $this->Paginator->sort('Employer.employer_name','Employer'); ?> </th>
                      <th width="88"> <?php echo $this->Paginator->sort('Employer.address','Location'); ?> </th>
                      <th width="58"> Jobs </th>
                      <th width="98"> <a href="">Industry</a></th>
                      <th width="88"> <?php echo $this->Paginator->sort('Employer.number_of_employees','No. of Employees'); ?> </th>
                    </tr>
                  </table></td>
              </tr>
              <?php 
       if(count($empRecNonAlpha)):
        foreach($empRecNonAlpha as $key1=>$value1): ?>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="108"><!--<?php echo $value1['Employer']['employer_name']; ?>-->
                      <?php echo $this->Html->link($value1['Employer']['employer_name'],array('controller'=>'candidates','action'=>'employeDetail/'.$value1['Employer']['id'])); ?>
                      </td>
                      <td  width="88"><?php echo $value1['Employer']['address']; ?> </td>
                      <td  width="58"><?php echo count($value1['JobPosting']); ?> Jobs</td>
                      <td  width="98"><?php echo $common->getIndustriesName($value1['Employer']['employer_type_code']); ?> </td>
                      <td  width="88" class="last"><?php echo $value1['Employer']['number_of_employees']; ?> </td>
                    </tr>
                  </table></td>
              </tr>
              <?php endforeach;
       else:
       ?>
              <tr>
                <td class="table_row border_bottom" align="center" style="color:#CC0000"><strong> No Record Found</strong> </td>
              </tr>
              <?php
       endif;
       ?>
            </table>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>