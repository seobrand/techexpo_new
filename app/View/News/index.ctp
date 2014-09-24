<?php $paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>

<div class="top_head">
  <h1>Kings <span>News</span></h1>
</div>
<?php		if(is_array($data) && count($data)) {
		$i=0;
		$j=0;
		
			foreach ($data as $record) { ?>
<div class="news_panel">
  <div class="news_top">
    <div class="news_heading" style="font-family:Verdana;"><?php echo $record['News']['title']; ?></div>
  </div>
  <div class="news_mid">
    <div class="news_padding">
      <div class="news_content">
        <?php  
								      
									  $content = strip_tags($record['News']['description']);
										$contentArr = explode(" ",$content);
										$length = count($contentArr);
										$k=0;
										if(!isset($contentNew[$j]))$contentNew[$j] ='';
										foreach($contentArr as $val){
										
										$contentNew[$j] .= $val." ";
										$k++;
										
											if($k >=WORD_COUNT){
											  break;
											}
										}
										
										if($length >= WORD_COUNT){ 
										   
										   $width = WORD_COUNT*2;
										   $height = WORD_COUNT*2;
										
										}else{
										
										   $width = $length*2;
										   $height = $length*2;
										
										}
									  $first_img = '';
									  ob_start();
									  ob_end_clean(); 
									  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $record['News']['description'], $matches);
									  if($output){
                                      $first_img = explode('/',$matches [1] [0]);
									  $cont = count($first_img);
									  $l_name = explode('&',$first_img[$cont-1]);
									  $image = $first_img[$cont-2].'/'.$l_name[0];								  
									  $base_url = WWW_ROOT.'/'.$image;
									  }
									  if($first_img !=''){?>
				<?php if(file_exists($base_url))	 {	?>	 
        <img src="<?=FULL_BASE_URL.Router::url("/", false)?>image_resizer.php?img=<?=$base_url?>&newWidth=<?= $width?>&newHeight=<?=$height?>" alt="News Image" title="News Image" />
		<?php } else { 
		?>
	<img src="<?=$matches [1] [0]?>" alt="News Image" title="News Image" width="<?= $width?>" Height=<?=$height?>"/>
		
        <?php }} ?>
        <p style="margin-bottom:10px;">
          <?php 

		  //echo (strlen($content) > CHARACTER_LENGTH) ? substr($content,0,CHARACTER_LENGTH).'...' : $content;
		  if($length >= WORD_COUNT ){
		  echo $contentNew[$j]."...";
		  }else{
		  echo $contentNew[$j];
		  }
		  
		    ?>
        </p>
      </div>
    </div>
  </div>
  <div class="news_bott">
    <div class="news_footer"><?php echo $html->link('View more details',array('controller'=>'news','action'=>'view',$record['News']['id']),array('class'=>'viewmore')) ; ?></div>
  </div>
</div>
<div class="aligncenter" style="margin-bottom:15px;"><img src="img/border-bottm.jpg" alt="" title="" /></div>
<?php $i++; $j++;	}
	}
	else { ?>
<table cellpadding="0" cellspacing="0" border="0" width="50%">
  <tr>
    <td colspan="2"><p>No News found.</p></td>
  </tr>
</table>
<?php }?>
<br />
<table cellpadding="0" cellspacing="0" border="0" width="50%">
  <tr>
    <td colspan="2"><p><?php echo $html->link('Previous Articles',array('controller'=>'news','action'=>'archiveNews')) ; ?></p></td>
  </tr>
</table>
<?php //echo $this->element('front_paging');?>
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