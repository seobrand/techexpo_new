<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<!--
<div class="title-pad">
  <div class="title">
    <h5>Code/Value</h5>
    <div class="search">
      <div class="button"> <?php //echo $this->Form->create('Code', array('action'=>'index'));echo $this->Form->input('search',array('label'=>'','value'=>$search,'class'=>'inputbox','div'=>false)); echo $this->Form->submit('Filter',array('class'=>'cursorclass ui-state-default ui-corner-all','id'=>'button41','div'=>false)); echo $this->Form->end();?> </div>
      <div class="input">
        <div class="button" style="margin-top:1px;"><?php //echo $this->Form->create('Code', array('controller'=>'codes','action'=>'create')); echo $this->Html->link('<input type="submit" name="submit" value="Add New Code" class="cursorclass ui-state-default ui-corner-all"  />',array('controller'=>'codes','action'=>'create'),array('escape'=>false));  echo $this->Form->end();?> </div>
      </div>
    </div>
  </div>
</div>
-->
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'Code')); ?>

      <div id="right2">
        <!-- table -->
        <div class="box1">
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Codes List</div>
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
                    <td align="left" valign="middle">
                        <?php echo $this->Html->link('Add New Code',array('controller'=>'codes','action'=>'create'),array('escape'=>false)); ?>
                      </td>
                  <tr>
                    <td align="left" valign="middle"><br />
                      <ul class="bullet_list">
                          <?php 
                                $i=0;
                                if(is_array($data) && count($data)) {
                                    foreach ($data as $record) { ?>
                        <li><?php echo $this->Html->link($record['Code']['code_name'],array('controller'=>'codes','action'=>'update',$record['Code']['code_name']),array('escape'=>false)); ?></li>
                            <?php } ?>   
                      </ul></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- end table -->
      </div>
    </div>
  </div>
  <!-- end content / right -->
</div>

<div style="clear:both; margin: 5px 60px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
			<?php
                                }else{ ?>
        <tr>
          <td colspan="6" align="center">No records found.</td>
        </tr>			      </tbody>
    </table>
  </div>
</div>
<?php } ?>