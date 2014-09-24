<?php //$this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'ShowHome')); ?>
<div id="right2">
        <!-- table -->
        <div class="box1">
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Homepage Shows</div>
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
              <p><strong>Decide which shows will appear on the homepage calendar and select your display options: </strong></p>
              <p>* Name to display: EXACT name as it will appear in the calendar and in the pull-down events menu</p>
              <p>* Will display a custom message below the main show information</p>
              <p>* Will display a banner / image next to main show info. NOTE: for proper look, the image should not be more than 40-50 pixels high and 60-70 pixels wide</p>
              <?php echo $this->Form->create('ShowsHome',array('action'=>'index','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
              <table cellspacing="0" cellpadding="0" border="0" align="center">
                <thead>
                  <tr>
                    <th align="left"><b>Display</b></font></th>
                    <th align="left"><b>Name to display<br>on calendar</b></font></th>
                    <th align="left"><b>Special message</b></font></th>
                    <th align="left"><b>Upload image / logo</b></font></th>
                  </tr>
                </thead>
                <tbody> 
                    
                  <?php  $i=1; foreach ($shows as $data){ //pr($data);?>
                    <tr>
                            <td bgcolor="ccccff">
                            <font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="1">
                            <?php 
                                $showInfo = ShowsHome::showName($data['Show']['id']);  
                                if($data['Show']['id'] == $showInfo['ShowsHome']['show_id']){
                                    $checked = $showInfo['ShowsHome']['assign_homepage'];
                                }else{
                                    $checked = false;
                                }
                                echo $this->Form->checkbox('ShowsHome.'.$i.'.c',array('value'=>'c'.$data['Show']['id'],'checked'=>$checked));
                                echo $data['Show']['show_name']."-".date('m/d/Y',strtotime($data['Show']['show_dt']));
                            ?>&nbsp;
                            </font>
                            </td>
                            <td bgcolor="ccccff">
                            <?php                            
                                echo $this->Form->input('ShowsHome.'.$i.'.display_name',array('class'=>'inputbox1','value'=>$showInfo['ShowsHome']['display_name'])); //h($Show['Show']['display_name']);
                            ?>&nbsp;
                            </td>
                            <td bgcolor="ccccff"><?php echo $this->Form->input('ShowsHome.'.$i.'.special_message',array('class'=>'smallTextB mceNoEditor','value'=>$showInfo['ShowsHome']['special_message'],'rows'=>'0')); //h($data['Show']['special_message']); ?>&nbsp;</td>
                            <td bgcolor="ccccff">
                            <font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="1">
                            <?php
                            	echo $this->element('photo_gallery_upload',array('id'=>"ShowsHome{$i}ImageFile",'name'=>"data[ShowsHome][{$i}][image_file1]",'radiofieldname'=>"{$i}_upload_photo"));
                                echo $this->Form->input('ShowsHome.'.$i.'.image_file',array('type'=>'file'));
								if($showInfo['ShowsHome']['image_file']!=''){
                                	echo $this->Html->image('showshome/'.$showInfo['ShowsHome']['image_file'],array('align'=>'absmiddle','height'=>100,'width'=>100));
								}
								echo "<br />";
                                echo $this->Form->checkbox('ShowsHome.'.$i.'.no_upload',array('value'=>'no_upload'.$data['Show']['id']));
                            ?>
							Do not upload / keep same image
                            </font>
                            </td>
                    </tr>
                <?php
                    echo $this->Form->hidden('ShowsHome.'.$i.'.show_id',array('value'=>$data['Show']['id']));
                    echo $this->Form->hidden('ShowsHome.'.$i.'.show_image',array('value'=>$showInfo['ShowsHome']['image_file']));
                    $i++;                    
                    } 
               ?>                    
                  
                  <tr>
                    <td colspan="9" align="left">                       
                        <?php
                            echo $this->Form->input('Assign',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all'));
                        ?>
                    </td>
                  </tr>
                </tbody>
              </table>
              <?php echo $this->Form->end(); ?>
            </div>
          </div>
        </div>
        <!-- end table -->
      </div>