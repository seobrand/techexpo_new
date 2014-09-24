<?php
class FolderContent extends AppModel {

var $actsAs = array('Containable');
//var $name="FolderContent";
var $primaryKey = 'fc_id';
var $useTable = 'folder_contents';
 
 public $belongsTo = array( 
		 'Resume' => array(
		 	'className'    => 'Resume',
            'foreignKey'   => 'e_resume_id'
        )
    );
/**
 * data validation of folder form
 *
 * @var array
 */	

}
