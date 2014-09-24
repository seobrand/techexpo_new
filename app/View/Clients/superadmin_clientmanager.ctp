<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'clientmanager')); ?>
<div class="display_row">
  <div class="table">
    <h2>Assign 
      Company to a TECHEXPO Event<br />
      (or perform additional admin tasks)</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody>
	  	<?php echo $this->Form->create(array('id'=>'saveLetterForm','action'=>'clientsearch','type'=>'get'));?>
        <tr>
          <td valign="middle">2. 
            Select the first letter of the company<br>
            <br><?php echo $this->Form->input('firstLetter',array('label'=>false,'type'=>'select','options'=>$letter,'error'=>false,'div'=>false));?>
            <?php echo $this->Form->submit('Search Letter Selection',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
          </td>
        </tr>
		<?php echo $this->Form->end();?>
		<?php echo $this->Form->create(array('id'=>'searchForm','action'=>'clientsearch','type'=>'get'));?>
        <tr>
          <td valign="middle">OR do a search by company name<br>
            <br>
            <?php echo $this->Form->input('employer_name',array('label'=>'','class'=>'inputbox1','error'=>false,'div'=>false));?>
            <?php echo $this->Form->submit('Search',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
            </td>
        </tr>
		<?php echo $this->Form->end();?>
		<?php echo $this->Form->create(array('id'=>'searchEmailForm','action'=>'clientsearch','type'=>'get'));?>
        <tr>
          <td valign="middle"> OR do a search by e-mail address<br>
            <br>
            <?php echo $this->Form->input('employer_email',array('label'=>'','class'=>'inputbox1','error'=>false,'div'=>false));?>
            <?php echo $this->Form->submit('Search By Email',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
			</td>
        </tr>
		<?php echo $this->Form->end();?>
        <tr>
          <td valign="middle"> What to do if the company you are looking <br>
            for doesn't show up in the list:
            <ul class="disc">
              <li>Look for acronyms, like SMI for<br>
                System Methodologies Inc.. Ask a<br>
                salesperson if you are not sure.<br>
              </li>
              <li>Check 'T'. The company may have a "the"<br>
                in front of it.</li>
              <li>If all fails, then it means it is not in the <br>
                system. Click below to create a new company. <br>
                <strong>The client MUST have an e-mail address before <br>
                you can resgister him/her.</strong><br>
              </li>
            </ul></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
