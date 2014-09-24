<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'viewHistory')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Group Chat History </div>
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
        <table border="0" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
              <th valign="middle" align="left">User </th>
               <th valign="middle" align="left">Date Time </th>
              <th valign="middle" align="left">Chat</th>
            
            </tr>
            </thead>
             <tbody>
                 <?php     //pr($employerLastVisits);exit;           
                if(is_array($groupChatHistory) && count($groupChatHistory)>0){
                    foreach ($groupChatHistory as $groupChatHistory){ 
                    //    $days = floor((strtotime(date('Y-m-d')) - strtotime($employerLastVisit['EmployerLastVisit']['last_visit']))/(60*60*24));
                ?>
                 <tr>
                      <td valign="middle" align="left"><?php echo $groupChatHistory['ChatMessage']['user']; ?>  </td>
                       <td valign="middle" align="left"><?php echo date('M d Y,H:i:s', strtotime($groupChatHistory['ChatMessage']['timestamp']));  ?>  </td>
                      <td valign="middle" align="left"><?php  echo $groupChatHistory['ChatMessage']['message'];?></td>
                      
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
      
   