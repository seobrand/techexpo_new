<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'addnews'));?>
<?php echo $this->Form->create('News', array('action'=>'create','id'=>'form','enctype'=>'multipart/form-data','type'=>'file'));?>
<?php echo $this->element('editor'); ?>
<div class="title-pad">
  <div class="title">
    <h5>Add News</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="left" width="100%">
      <tr>
        <td width="15%" align="right" valign="top"><span class="required">*</span>News Title :</td>
        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('title', array('label'=>'','id'=>'title','class'=>'inputbox1','tabindex'=>1,'div'=>false,'style'=>'width:192px;height:15px;','error'=>false,'onblur'=>'fillMetaTitle();')); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Content :</td>
                <td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0" class="nostyle" >
				<tr><td><?php echo $this->Form->input('description', array('label'=>'','type'=>'textarea','cols'=>'118','rows'=>'25','error'=>false)); ?> </td></tr></table></td>
              </tr>	  
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Publish Date :</td>
        <td align="left" valign="top"><?php 
			$defaultDate 	= isset($argArr['publish']) ? $argArr['publish'] : date('d-m-Y') ;
			echo $this->element('calendar3',array('dateId'=>'publish','defaultDate'=>$defaultDate));?></td>
      </tr>      
	  
      <tr>
        <td align="right" valign="top">Expire Date :</td>
        <td align="left" valign="top"><?php 
			$defaultDate1 	= isset($argArr['expire']) ? $argArr['expire'] : date('d-m-Y') ;
			echo $this->element('calendar2',array('dateId'=>'expire','defaultDate'=>$defaultDate1));?></td>
      </tr>
      <tr>
                <td align="right" valign="top">Meta Title :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_title',array('label'=>'','class'=>'inputbox1','id'=>'meta_title','tabindex'=>5,'div'=>false,'style'=>'width:192px;height:15px;')); ?></td>
              </tr>
	  <tr>
                <td align="right" valign="top">Meta Description :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_description',array('label'=>'','type'=>'textarea','class'=>'mceNoEditor','id'=>'meta_description','tabindex'=>5,'cols'=>'70','rows'=>'3','div'=>false)); ?></td>
              </tr>
		  <tr>
                <td align="right" valign="top">Meta Keyword :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_keyword',array('label'=>'','type'=>'textarea','class'=>'mceNoEditor','id'=>'meta_keyword','tabindex'=>5,'cols'=>'70','rows'=>'3','div'=>false)); ?></td>
              </tr>
	  
	  
	  <tr>
        <td align="right" valign="top">Active :</td>
        <td align="left" valign="top"><?php  $options=array('yes'=>'Yes','no'=>'No');
 $attributes=array('label'=>false,'legend'=>false,'default'=>'yes','div'=>false,'id'=>'active');
 echo $this->Form->radio('active',$options,$attributes); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
    </table>
  </div>
</div>
<input type="hidden" name="SUBMIT" value="SUBMIT" />
<?php echo $this->Form->end();?>
<script type="text/javascript" language="javascript">
 function fillMetaTitle(){
       document.getElementById('meta_title').value = document.getElementById('title').value;
   }
</script>