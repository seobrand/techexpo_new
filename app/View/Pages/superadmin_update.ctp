<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'editpage'));?>
<?php echo $this->Form->create('Page', array('action'=>'update','id'=>'form','enctype'=>'multipart/form-data'));?>
<?php echo $this->element('editor'); ?>
<div class="title-pad">
  <div class="title">
    <h5>Edit Page</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
  
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="left" width="100%">
      <tr>
        <td width="12%" align="right" valign="top"><span class="required">*</span>Page Title :</td>
        <td width="88%" align="left" valign="top"><?php echo $this->Form->input('title', array('label'=>'','id'=>'title','class'=>'inputbox1','tabindex'=>1,'div'=>false,'value'=>$data['Page']['title'],'style'=>'width:192px;height:25px;','error'=>false,'onblur'=>'fillMetaTitle();')); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Alias :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('alias', array('label'=>'','id'=>'alias','class'=>'inputbox1','tabindex'=>2,'div'=>false,'value'=>$data['Page']['alias'],'style'=>'width:192px;height:25px;','error'=>false)); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Page Type :</td>
        <td align="left" valign="top"><?php $optionList =  array('content'=>'Content','document'=>'Document');
	   			echo $this->Form->input('page_type',array('label'=>'','type'=>'select','options'=>$optionList,'default'=>$data['Page']['page_type'],'class'=>'selectbox','id'=>'page_type','div'=>false,'onchange'=>'if(this.value=="document") { hideShow("contentDiv","documentDiv");} else { hideShow("documentDiv","contentDiv");} ','style'=>'width:200px;height:25px;','error'=>false));
	   ?>
	   
	  </td>
      </tr>
	  </table>
	  
<div id="contentDiv">
<div style="height:5px;"></div>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td align="right" valign="top" width="12%"><span class="required">*</span>Content :</td>
                <td align="left" valign="top" width="88%"><table cellpadding="0" cellspacing="0" border="0" class="nostyle"><tr><td><?php 
				echo $this->Form->input('content', array('label'=>'','type'=>'textarea','cols'=>'80','rows'=>'100','value'=>$data['Page']['content'],'style'=>'height:100%;','error'=>false)); ?></td></tr></table> </td>
              </tr>
              <tr>
                <td align="right" valign="top">Meta title :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_title',array('label'=>'','class'=>'inputbox1','id'=>'meta_title','tabindex'=>5,'div'=>false,'value'=>$data['Page']['meta_title'],'style'=>'width:192px;height:25px;','error'=>false)); ?></td>
              </tr>
			  <tr>
                <td align="right" valign="top">Meta description :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_description',array('label'=>'','type'=>'textarea','class'=>'mceNoEditor','id'=>'meta_description','tabindex'=>5,'cols'=>'70','rows'=>'3','div'=>false,'value'=>$data['Page']['meta_description'],'error'=>false)); ?></td>
              </tr>
			    <tr>
                <td align="right" valign="top">Meta keyword :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_keyword',array('label'=>'','type'=>'textarea','class'=>'mceNoEditor','id'=>'meta_keyword','tabindex'=>5,'div'=>false,'cols'=>'70','rows'=>'3','value'=>$data['Page']['meta_keyword'],'error'=>false)); ?></td>
              </tr>
            </table>
			</div>
			<div id="documentDiv" style="display:none;">
            <div style="height:5px;"></div>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td align="right" valign="top" width="12%"><span class="required">*</span>Upload document :</td>
                <td align="left" valign="top" width="88%"><?php echo $this->Form->file('doc_name', array('label'=>'','class'=>'inputbox1','id'=>'doc_name','tabindex'=>6,'div'=>false,'style'=>'width:286px;','error'=>false)); 
			if($data['Page']['doc_name']) { 
				echo $this->Html->link($data['Page']['doc_name'],FULL_BASE_URL.Router::url('/', false).'documents/'.$data['Page']['doc_name'],array('target'=>'_blank'));
			}?></td>
              </tr>
            </table>
			</div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
      <tr>
        <td width="12%" align="right" valign="top">Active :</td>
        <td width="88%" align="left" valign="top"><?php  $options=array('yes'=>'Yes','no'=>'No');
 $attributes=array('label'=>false,'legend'=>false,'default'=>$data['Page']['active'],'div'=>false,'id'=>'active');
 echo $this->Form->radio('active',$options,$attributes);
   ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php
		echo $this->Form->input('oldfilename',array('type'=>'hidden','value'=>$data['Page']['doc_name'],'div'=>false)); 
		echo $this->Form->input('id',array('type'=>'hidden','value'=>$data['Page']['id'],'div'=>false));
		echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
    </table>
  </div>
</div>
<input type="hidden" name="SUBMIT" value="SUBMIT" />
<?php echo $this->Form->end();?>
<script type="text/javascript">
	   hideShow(["contentDiv","documentDiv"],"<?php echo $data['Page']['page_type'];?>Div");

 function fillMetaTitle(){
       document.getElementById('meta_title').value = document.getElementById('title').value;
   }
</script>