<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'editnews'));?>
<?php echo $this->Form->create('News', array('action'=>'update','id'=>'form','enctype'=>'multipart/form-data','type'=>'file'));?>
<?php echo $this->element('editor'); ?>
<div class="title-pad">
  <div class="title">
    <h5>Edit News</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="left">
      <tr>
        <td width="15%" align="right" valign="top"><span class="required">*</span>News Title :</td>
        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('title', array('label'=>'','id'=>'title','class'=>'inputbox1','tabindex'=>1,'div'=>false,'style'=>'width:192px;height:15px;','value'=>$data['News']['title'],'error'=>false,'onblur'=>'fillMetaTitle();')); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Content :</td>
                <td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0" class="nostyle" >
				<tr><td><?php echo $this->Form->input('description', array('label'=>'','type'=>'textarea','cols'=>'70','rows'=>'25','value'=>$data['News']['description'])); ?> </td></tr></table></td>
              </tr>	  
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Publish Date :</td>
        <td align="left" valign="top"><?php 
			$defaultDate 	= isset($data['News']['publish']) ? $data['News']['publish'] : date('d-m-Y') ;
			echo $this->element('calendar3',array('dateId'=>'publish','defaultDate'=>$defaultDate));?></td>
      </tr>      
	  
      <tr>
        <td align="right" valign="top">Expire Date :</td>
        <td align="left" valign="top"><?php 
			$defaultDate1 	= isset($data['News']['expire']) ? $data['News']['expire'] : date('d-m-Y') ;
			echo $this->element('calendar2',array('dateId'=>'expire','defaultDate'=>$defaultDate1));?></td>
      </tr>
       <tr>
                <td align="right" valign="top">Meta title :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_title',array('label'=>'','class'=>'inputbox1','id'=>'meta_title','tabindex'=>5,'div'=>false,'value'=>$data['News']['meta_title'],'style'=>'width:192px;height:25px;','error'=>false)); ?></td>
              </tr>
			  <tr>
                <td align="right" valign="top">Meta description :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_description',array('label'=>'','type'=>'textarea','class'=>'mceNoEditor','id'=>'meta_description','tabindex'=>5,'cols'=>'70','rows'=>'3','div'=>false,'value'=>$data['News']['meta_description'],'error'=>false)); ?></td>
              </tr>
			    <tr>
                <td align="right" valign="top">Meta keyword :</td>
                <td align="left" valign="top"><?php echo $this->Form->input('meta_keyword',array('label'=>'','type'=>'textarea','class'=>'mceNoEditor','id'=>'meta_keyword','tabindex'=>5,'div'=>false,'cols'=>'70','rows'=>'3','value'=>$data['News']['meta_keyword'],'error'=>false)); ?></td>
              </tr>
	  
	  
	  <tr>
        <td align="right" valign="top">Active :</td>
        <td align="left" valign="top"><?php  $options=array('yes'=>'Yes','no'=>'No');
 $attributes=array('label'=>false,'legend'=>false,'default'=>$data['News']['active'],'div'=>false,'id'=>'active');
 echo $this->Form->radio('active',$options,$attributes); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><?php echo $this->Form->input('id', array('label'=>'','id'=>'id','div'=>false,'value'=>$data['News']['id'],'type'=>'hidden')); ?></td>
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