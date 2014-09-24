<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'addpage'));?>
<?php echo $this->Form->create('Page', array('action'=>'create','id'=>'form','enctype'=>'multipart/form-data'));?>
<?php echo $this->element('editor'); ?>
<div class="title-pad">
  <div class="title">
    <h5>Add New Page</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="left" width="100%">
      <tr>
        <td width="12%" align="right" valign="top"><span class="required">*</span>Page Title :</td>
        <td width="88%" align="left" valign="top"><?php echo $this->Form->input('title', array('label'=>'','id'=>'title','class'=>'inputbox1','tabindex'=>1,'div'=>false,'style'=>'width:192px;height:15px;','error'=>false,'onblur'=>'fillMetaTitle();')); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Alias :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('alias', array('label'=>'','id'=>'alias','class'=>'inputbox1','tabindex'=>2,'div'=>false,'style'=>'width:192px;height:15px;')); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Page Type :</td>
        <td align="left" valign="top"><?php $optionList =  array('content'=>'Content','document'=>'Document');
	   			echo $this->Form->input('page_type',array('label'=>'','type'=>'select','options'=>$optionList,'default'=>'content','class'=>'selectbox','id'=>'page_type','div'=>false,'onchange'=>'if(this.value=="document") { hideShow("contentDiv","documentDiv");} else { hideShow("documentDiv","contentDiv");} ','style'=>'width:200px;height:23px;','error'=>false));
	   ?>   
	  </td>
      </tr>
</table>
<div id="contentDiv">
<div style="height:5px;"></div>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td align="right" valign="top" width="12%"><span class="required">*</span>Content :</td>
                <td align="left" valign="top" width="88%" ><table cellpadding="0" cellspacing="0" border="0" class="nostyle" >
				<tr><td><?php echo $this->Form->input('content', array('label'=>'','type'=>'textarea','cols'=>'80','rows'=>'20','error'=>false,'div'=>'false')); ?> </td></tr></table></td>
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
            </table>
          </div>
          <div id="documentDiv" style="display:none;">
          <div style="height:5px;"></div>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td align="right" valign="top" width="12%"><span class="required">*</span>Upload Document :</td>
                <td align="left" valign="top" width="88%"><?php echo $this->Form->file('doc_name', array('label'=>'','class'=>'inputbox1','id'=>'doc_name','tabindex'=>6,'div'=>false,'style'=>'width:288px;','error'=>false)); ?></td>
              </tr>
            </table>
          </div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
      <tr>
        <td align="right" valign="top" width="12%">Active :</td>
        <td align="left" valign="top" width="88%"><?php  $options=array('yes'=>'Yes','no'=>'No');
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
<input type="hidden" value="SUBMIT" name="SUBMIT">
<?php echo $this->Form->end();?>
<script type="text/javascript">
   hideD = '<?php echo isset($this->params['data']['Page']['page_type']) ? $this->params['data']['Page']['page_type'] : 'content';?>';
   hideShow(["contentDiv","documentDiv"],hideD+"Div");
   
   function fillMetaTitle(){
       document.getElementById('meta_title').value = document.getElementById('title').value;
   }
</script>