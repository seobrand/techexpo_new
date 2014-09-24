<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'editCode')); ?>

<?php echo $this->Form->create('Code', array('action'=>'update/'.$codename));?>

<div id="right2">
        <!-- table -->
        <div class="box1">
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Codes</div>
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
              <table  cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody>
                  <tr>
                    <td align="right" valign="middle" width="25%">Values for <?php echo $codename;?>:</td>
                    <td align="left" valign="top" width="74%">
                        <?php echo $this->Form->input('code_descr',array('options'=>$codedescr,'label'=>false,'error'=>false)); ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle"></td>
                    <td align="left" valign="top">
                        <?php echo $this->Html->link('Add Value',array('controller'=>'codes','action'=>'update',$codename,'add'));?>
                    </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle"></td>
                    <td align="left" valign="top">
                      <?php                      
                      foreach($codedescr as $cdv => $cd){
                        echo $this->Html->link($cd,array('controller'=>'codes','action'=>'update',$codename,$cdv),array('escape'=>false));
                        echo "<br /><br />";
                      }
                      ?>
                    </td>
                  </tr>
                </tbody>
              </table>
              <span id="disp" style="<?php if(isset($codeid)) echo "display:block;";else echo "display: none;"; ?>">
              <h2><span id="head"><?php if(isset($codeid) && $codeid=="add") echo "Add";else echo "Edit"; ?></span></h2>
              <table  cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody>
                  <tr>
                    <td align="right" valign="middle" width="25%">Value:</td>
                    <td align="left" valign="top" width="74%">
                        <?php echo $this->Form->input('code_descr',array('class'=>'inputbox1','label'=>false,'div'=>false,'id'=>'code_descr','error'=>false)); ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">Visible:</td>
                    <td align="left" valign="top">
                       <?php
                        echo $this->Form->checkbox('visible',array('value'=>'Y'));
                        echo $this->Form->hidden('code_id');
                        echo $this->Form->hidden('code_name',array('value'=>$codename));
                        ?>
                        
                        <?php                        
                        if(isset($codeid) && $codeid!='add'){
                            echo $this->Form->submit('Update Value',array('class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                            echo "&nbsp;&nbsp;";
                            echo $this->Html->link($this->Html->image('delete.jpg',array('alt'=>'Delete Value')),array('controller'=>'codes','action'=>'delete',$codeid,$codename),array('confirm'=>'Are you sure want to delete?','escape'=>false));
                        }else{
                            echo $this->Form->submit('Add Value',array('class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                        }
                       ?>
                        
                    </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">Sort Order:</td>
                    <td align="left" valign="top">
                        <?php echo $this->Form->input('sort_order',array('type'=>'text','onkeypress'=>'return isNumericKey(event)','class'=>'sort_textfield','label'=>false,'div'=>false)); ?>
                    </td>
                  </tr>
                </tbody>
              </table>
              </span>
            </div>
          </div>
        </div>
        <!-- end table -->
      </div>
<?php echo $this->Form->end(); ?>
    </div>
  </div>
  <!-- end content / right -->
</div>
<!-- end content -->







