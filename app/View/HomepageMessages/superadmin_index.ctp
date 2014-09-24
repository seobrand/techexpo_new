<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'homepagemessage')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Home Page Messages</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
          <!-- box / title -->
          
<div class="display_row">
  <div class="table">
  

  <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="left" valign="middle"><?php //echo $this->Html->link(__('Add Press Release'), array('action' => 'add'),array('class'=>'cursorclass ui-state-default ui-corner-all')); ?></td>

      </tr>
      <td>      
            <ul class="bullet_list">
                <?php
                $messageHomepage = array("e"=>"Employer","c"=>"Candidate");
                if(is_array($homepageMessages) && count($homepageMessages)>0){
                    foreach ($homepageMessages as $homepageMessage){ ?>
                        <li><?php echo $this->Html->link(h($messageHomepage[$homepageMessage['HomepageMessage']['type']]),array('controller'=>'homepageMessages','action'=>'edit',$homepageMessage['HomepageMessage']['type']));?></li>     
                <?php
                    }                
                } 
                ?>
            </ul>         
         </td></tr>
      
      </tbody>
    </table>
  </div>
</div>
   </div>
        <!-- end table --> 
</div>