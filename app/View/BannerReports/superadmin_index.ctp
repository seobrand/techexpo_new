<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Banner Report</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
  <div class="table"> <?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="View All Banner Reports" name="assign">',array('controller'=>'banner_reports','action'=>'index'),array('escape'=>false)); ?>
  	&nbsp;&nbsp;<?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="View Corporate Banner Reports" name="assign">',array('controller'=>'banner_reports','action'=>'index',1),array('escape'=>false)); ?>
	&nbsp;&nbsp;<?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value=" View Media Banner Reports" name="assign">',array('controller'=>'banner_reports','action'=>'index',3),array('escape'=>false)); ?>
	&nbsp;&nbsp;<?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="View Platinum Banner Reports" name="assign">',array('controller'=>'banner_reports','action'=>'index',2),array('escape'=>false)); ?><br />
    <br />
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th width="30%" align="left" valign="middle"> Banner Name </th>
          <th align="left" valign="middle"> Impressions / loads </th>
          <th align="left" valign="middle"> Clickthoughs </th>
          <th align="left" valign="middle"> Impressions /<br>
            Clickthoughs (%)
            </td>
          <th align="left" valign="middle"> Banner preview </th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($rec as $key =>$bannerReport){?>
        <tr>
          <td width="25%"  align="left"> <?php if($bannerReport['Banner']['href']!=''){?><a href="<?php echo $bannerReport['Banner']['href'];?>" target="_blank"><?php echo $bannerReport['Banner']['name'];?> </a><?php }else{?><?php echo $bannerReport['Banner']['name'];?> <?php } ?></td>
          <td align="left"> <?php if($bannerReport[0]['totalloads']>0) echo $bannerReport[0]['totalloads']; else echo "0";?><br></td>
          <td align="left"> <?php if($bannerReport[0]['totalclicks']>0) echo $bannerReport[0]['totalclicks']; else echo "0";?><br></td>
          <td align="left"> 
		 <?php if($bannerReport[0]['totalloads']>0){?>
		  <?php $percent=(($bannerReport[0]['totalclicks']/$bannerReport[0]['totalloads'])*100) ?> 
		  <?php }else{ $percent= 0; }?>
		  <?php echo number_format($percent,2,'.','');?>%
		  </td>
          <td align="left"><img src="<?php echo $this->webroot;?>Banner/150x80_<?php echo $bannerReport['Banner']['filename'];?>" alt="<?php echo $bannerReport['Banner']['alt'];?>"></td>
        </tr>
        <?php } ?>
		<?php if(count($rec)==0){?>
		<tr>
          <td colspan="5" align="center">There is no banner added yet..</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
