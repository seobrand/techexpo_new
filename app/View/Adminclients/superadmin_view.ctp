<style type="text/css">
			.contactimage {
				border: none;
				font-family: Verdana, Arial, Helvetica, sans-serif;
				font-size: 11px;
				background-color: #A2B9D8;
				color: black;
			}	
		</style>
<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'viewadminclient'));?>

<div class="title-pad">
  <div class="title">
    <h5>View Client Details</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="candidate_registration">
      <tr>
        <td width="20%" align="right" valign="top">Title</td>
        <td width="80%" align="left" valign="top"><?php echo $data['Adminclient']['title'];?></td>
      </tr>
      <tr>
        <td align="right" valign="top">First Name</td>
        <td align="left" valign="top"><?php echo $data['Adminclient']['first_name'];?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Surname</td>
        <td align="left" valign="top"><?php echo $data['Adminclient']['last_name'];?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Title or Department </td>
        <td align="left" valign="top"><?php echo $data['Adminclient']['department'];?></td>
      </tr>	  
      <tr>
        <td align="right" valign="top">Company Name</td>
        <td align="left" valign="top"><?php echo $data['Adminclient']['company_name'];?></td>
      </tr>	  
      <tr>
        <td align="right" valign="top">Telephone Number</td>
        <?php $width = strlen($data['Adminclient']['contact1'])*8;?>
        <td align="left" valign="top"><input type="text" value="<?php echo $data['Adminclient']['contact1'];?>" class="contactimage" style="width:<?php echo $width;?>px;" readonly="true" />
          <?php echo ($data['Adminclient']['primary_contact']=='contact1') ? ' ( <b>Primary</b> ) ' : ''; ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <?php $width2 = strlen($data['Adminclient']['contact2'])*8;?>
        <td align="left" valign="top"><input type="text" value="<?php echo $data['Adminclient']['contact2'];?>" class="contactimage" style="width:<?php echo $width2;?>px;" readonly="true" />
          <?php echo ($data['Adminclient']['primary_contact']=='contact2') ? ' ( <b>Primary</b> ) ' : ''; ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Postcode</td>
        <td align="left" valign="top"><?php echo $data['Adminclient']['postcode'];?></td>
      </tr>

      <tr>
        <td align="right" valign="top">Email Address</td>
        <td align="left" valign="top"><?php echo $data['Adminclient']['email'];?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Comments</td>
        <td align="left" valign="top"><?php echo $data['Adminclient']['comments'];?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Areas of Interest</td>
        <td align="left" valign="top"><?php echo implode(',<br />',explode('|-|',$data['Adminclient']['area_of_interests']));
	?></td>
      </tr>
      <tr>
        <td align="right" valign="top">How do you prefer to communicate</td>
        <td align="left" valign="top"><?php echo ($data['Adminclient']['comm_telephone'] == 'yes') ? ' Telephone ' : '' ; ?> <?php echo ($data['Adminclient']['comm_email'] == 'yes') ? ' Email' : '' ; ?> </td>
      </tr>
      <tr>
        <td align="right" valign="top">Active</td>
        <td align="left" valign="top"><?php echo ucfirst($data['Adminclient']['active']);?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Date Registered</td>
        <td align="left" valign="top"><?php echo date(DATE_FORMAT,strtotime($data['Adminclient']['created']));?></td>
      </tr>
    </table>
  </div>
</div>
