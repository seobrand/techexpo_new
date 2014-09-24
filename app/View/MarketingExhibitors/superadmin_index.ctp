<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'MarketingExhibitor')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Marketing Partner's List</div>
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
          <td align="left" valign="middle"><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add Marketing Partner" name="assign">',array('action'=>'add'),array('escape'=>false)); ?></td>

      </tr>
      <td> 
      
            <ul class="bullet_list">
                <?php
                if(is_array($pixes) && count($pixes)>0){
                    foreach ($pixes as $pix){ ?>
                        <li><?php echo $this->Html->link('ID: '.h($pix['MarketingExhibitor']['id']).' - title: '.h($pix['MarketingExhibitor']['title']).' - edit',array('controller'=>'marketing_exhibitors','action'=>'edit',$pix['MarketingExhibitor']['id']));?></li>     
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
<?php if(count($pixes)):?>
<div style="clear:both; margin: 5px 60px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>
