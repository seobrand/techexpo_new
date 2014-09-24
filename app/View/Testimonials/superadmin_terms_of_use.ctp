<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'termsOfUse')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Terms Of Use</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('Testimonial',array('action'=>'termsOfUse','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody> 
            <tr>
              <td width="25%" align="right" valign="middle">Text: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('PageContent.content',array('class'=>'inputbox12','type'=>'textarea','cols'=>100,'rows'=>30));?></td>
            </tr> 
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Save',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo "&nbsp;&nbsp;";
                echo $this->Form->hidden('PageContent.id'); 
                echo $this->Form->hidden('PageContent.page_name',array('value'=>'terms_of_use'));
                echo $this->Form->end();                                
              ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
 </div>
<!-- end table --> 
</div>

