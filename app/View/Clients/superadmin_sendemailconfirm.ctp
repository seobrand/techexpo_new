<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Confirmation E-mail</div>
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
          <td valign="middle"><p> 
		  	<?php if(isset($sendemail) && $sendemail=='yes'){?>
		  <font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="2"> Confirmation e-mail re-sent. </font> 
			<?php }else{ ?>
			  <font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="2"> There is no confirmation packet assigned to this show. Please see Nancy. </font> </p>
			 <?php } ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
