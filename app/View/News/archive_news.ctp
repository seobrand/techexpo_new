<?php $paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<table cellpadding="" cellspacing="" border="" width="100%">
<tr>
<td>
<div class="top_head" style="width:100%;">
  <h1 style="font-family:Verdana, Arial, Helvetica, sans-serif;">Kings<span> News Archive</span></h1>
  </div>
  </td><td>
  <span style="float:right;position:relative;"><?php echo $html->link('Back to News',array('controller'=>'news','action'=>'index')) ; ?></span>
</td></tr></table>
<?php		if(is_array($data) && count($data)) {
		$i=0;
			foreach ($data as $record) { ?>
<div style="background-color:<?php if($i%2==0) echo '#FBFBFB'; else {echo '#FFFFFF';}?>;">
  <table cellpadding="2px" cellspacing="5px" border="0" width="100%" style="border-bottom:1px dashed #999999;color:#666;">
    <tr>
      <td colspan="2"><?php echo $html->link($record['News']['title'],array('controller'=>'news','action'=>'view',$record['News']['id']), array('class'=>'links')) ;  ?></td>
    </tr>
  </table>
</div>
<?php $i++;	}?>
	<?php echo $this->element('front_paging'); }
	else { ?>
<table cellpadding="0" cellspacing="0" border="0" width="50%">
  <tr>
    <td colspan="2"><p>No News found.</p></td>
  </tr>
</table>
<?php }?>
<br />

<span id="url" style="display:none;"><?php echo FULL_BASE_URL.Router::url('/', false);?></span>
<style type="text/css">
 .links a:hover {
font: 12px/12px Verdana, Geneva, sans-serif;
color: #36C;
text-decoration: none;
}
 .links a {
font: 12px/12px Verdana, Geneva, sans-serif;
color: #36C;
}
</style>