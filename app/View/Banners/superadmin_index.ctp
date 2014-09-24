<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'bannerlist')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Banner Management</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
                
              </div>
              
            </div>
            <?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New" name="assign">',array('controller'=>'banners','action'=>'add'),array('escape'=>false)); ?>
          </div>
          
    <div class="display_row">
      <div class="table">
        <table border="0" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
              <th valign="middle" align="left">Banner Name</th>
              <th valign="middle" align="left">Type</th>
              <th valign="middle" align="left">Status</th>
              <th valign="middle" align="left">Action</th>
            </tr>
            </thead>
             <tbody>
                 <?php     //pr($employerLastVisits);exit;           
                if(is_array($Allbanner) && count($Allbanner)>0){
                    foreach ($Allbanner as $Allbanner){ 
                 
                ?>
                 <tr>
                      <td valign="middle" align="left"><?php echo $Allbanner['Banner']['name']; ?></td>
                      <td valign="middle" align="left"><?php  echo $Allbanner['Category']['category_name'];?></td>
                      <td valign="middle" align="left"><?php echo ucfirst($Allbanner['Banner']['banner_status']);?></td>
                      <td valign="middle" align="left"> <?php // echo $this->Html->link('Delete Account', array('controller'=>'employerLastVisits','action'=>'',$employerLastVisit['Employer']['id'],$employerLastVisit['EmployerContact']['id']),array('escape'=>false,'confirm' => 'You are about to delete this account. Are you sure you want to do this ?')); ?>
                      <?php echo $this->Html->link("Edit",array('controller'=>'banners','action'=>'edit',$Allbanner['Banner']['id']),array('escape'=>false)); ?>
                      </td>
                  </tr>
                  <?php
                    }                
                } 
                ?>      
          </tbody>
        </table>
      </div>
    </div>
  </div>
        <!-- end table --> 
      </div>
      
  
      