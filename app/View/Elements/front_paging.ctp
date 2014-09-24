<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #CCCCCC;" style="font-family:Verdana, Arial, Helvetica, sans-serif;">
  <tr height="30">
    <td align="center" valign="middle" width="12%" style="font-family:Verdana, Arial, Helvetica, sans-serif;"><?php echo $paginator->prev(" << Previous ", null, null, array('class' => 'disabled'));?></td>
    <td align="center" valign="middle" width="10%" style="font-family:Verdana, Arial, Helvetica, sans-serif;"><?php echo $paginator->next(" Next >> ", null, null, array('class' => 'disabled'));?></td>
    <td align="center" valign="middle" width="40%" style="font-family:Verdana, Arial, Helvetica, sans-serif;"><?php echo $paginator->counter(array('format' => 'Page %page% of %pages%, showing %current% records out of %count%')); ?></td>
    <td align="center" valign="middle" style="font-family:Verdana, Arial, Helvetica, sans-serif;"><?php echo $paginator->numbers();?></td>
  </tr>
</table>