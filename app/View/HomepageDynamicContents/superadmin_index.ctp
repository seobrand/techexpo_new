<?php //$this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'homepagedynamic')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Home Page Announcement</div>
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
          <td align="left" valign="middle"><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add Team Message" name="assign">',array('action'=>'add'),array('escape'=>false)); ?></td>

      </tr>
      <td> <strong>Special announcements:</strong><br/><br/>
            <ul class="bullet_list">
                <?php                
                if(is_array($homepageDynamicContents) && count($homepageDynamicContents)>0){
                    foreach ($homepageDynamicContents as $homepageDynamicContent){ ?>
                        <li><?php echo $this->Html->link($homepageDynamicContent['HomepageDynamicContent']['title'],array('controller'=>'homepageDynamicContents','action'=>'edit',$homepageDynamicContent['HomepageDynamicContent']['id']));?>&nbsp;(<?php echo $homepageDynamicContent['HomepageDynamicContent']['sort'] ?>)</li>     
                <?php
                    }                
                } 
                ?>
            </ul> <br/>
			<strong>Messages from the President:</strong><br/><br/>
            <ul class="bullet_list">
                <?php                
                if(is_array($presidentAnnouncement) && count($presidentAnnouncement)>0){
                    foreach ($presidentAnnouncement as $presidentAnnouncement){ ?>
                        <li><?php echo $this->Html->link($presidentAnnouncement['HomepageDynamicContent']['title'],array('controller'=>'homepageDynamicContents','action'=>'edit',$presidentAnnouncement['HomepageDynamicContent']['id']));?>&nbsp;(<?php echo $presidentAnnouncement['HomepageDynamicContent']['sort'] ?>)</li>     
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
</div>
</div>
</div>
<!-- end content / right -->
</div>
<?php /*if(count($homepageDynamicContents)):?>
<div style="clear:both; margin: 5px 60px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;*/?>
