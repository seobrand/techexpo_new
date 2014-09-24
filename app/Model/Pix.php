<?php
App::uses('AppModel', 'Model');
/**
 * Pix Model
 *
 */
class Pix extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
public $useTable = 'pix';

public $primaryKey = 'pic_id';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'pic_id';
	
/**
* belongsTo associations
*
* @var array
*/
 public $belongsTo = array(
          'Show' => array(
            'className'    => 'Show',
			'fields'           => array('id','show_name','show_dt'),
            'foreignKey'   => 'event_id'
        ), 
    );
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'pic_title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please Enter Picture Title',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'event_id' => array(
			'noBlank' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please select a event.'
			)
		),
		'pic_filename' => array(
             'Rule-1'=> array(
				'rule' => 'nullImageCheck',
				'message' => 'Please upload image.',
                 'last' => true
			  ),
			  'Rule-2'=>array(
				'rule'    => array('fileTypeCheck'),
				'message' => 'Please upload .jpg file or .png file or .gif file only.'
			  )
         )
	);
	
	function nullImageCheck()
	{
		if($this->data['Pix']['pic_filename1']=="" && $this->data['Pix']['pic_filename']['name']=="")
		{
			return false;
		}
		return true;
	}
	
	function fileTypeCheck()
	{
		$ftype = trim(end(explode(".",$this->data['Pix']['pic_filename']['name'])));
	
		if(strlen($ftype)>0){
			if(strtolower($ftype) =="png" || strtolower($ftype) =="jpeg" || strtolower($ftype) =="jpg"  || strtolower($ftype) =="gif"){
				return true;
			}else{
				return false;
			}
		}
		return true;
	
	}
	
	
}
