<?php
App::uses('AppModel', 'Model');
/**
 * Show Model
 *
 * @property Location $Location
 * @property Set $Set
 */
class Show extends AppModel {
var $name = 'Show';
//public $primaryKey = 'show_id';	

var $hasMany = 'Registration'; 


  var $virtualFields = array(
    'showsNameDate' => 'CONCAT(Show.show_name,"     ", Show.show_dt)'
    );


/**
 * belongsTo associations
 *
 * @var array
 */
 public $belongsTo = array(
          'Location' => array(
            'className'    => 'Location',
            'foreignKey'   => 'location_id'
        ),
		 'ResumeSetRule' => array(
            'className'    => 'ResumeSetRule',
            'foreignKey'   => 'resume_set_id'
        )
 );
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'show_dt' => array(	
				'rule' => array('date'),
				'message' => 'Enter Show Date',
		),
		'show_name' => array(			
				'rule' => array('notEmpty'),
				'message' => 'Enter Show Name'
		),
		'show_hours' => array(
			'rule' => array('notEmpty'),
			'message' => 'Enter Show Hour'
		),
		'regular_emp' =>
			 array('notEmpty'=>array(
									'rule' => array('notEmpty'),
									'message' => 'Enter total space for regular exhibitors'
								),
					 'numeric'=>array(
									'rule' => array('numeric'),
									'message' => 'Limit for regular exhibitors must be numeric'
								)
				   ),
		'virtual_emp' =>
			 array(			
					'notEmpty'=>array(
									'rule' => array('notEmpty'),
									'message' => 'Enter total space for virtual exhibitors'
								),
					 'numeric'=>array(
									'rule' => array('numeric'),
									'message' => 'Limit for virtual exhibitors must be numeric'
								)
				   )
	);

	function uploadShowConfirmFile(){	
		$validate2 = array(			
			'show_confirm_file' => array(
				'rule'    => array('extension', array('doc', 'pdf', 'rtf', 'docx')),
				'message' => 'Please supply a valid confirm file(.doc,.pdf,.rtf,.docx).'
			)
		);
		$this->validate=$validate2;
		return $this->validates();
	}
	
	function SetValidates(){	
		$validate2 =  array(
                'set_descr'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert set description.'				
                    ),
                 'start_dt'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert start Date.'				
                    ),
				'end_dt'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert end Date.'				
                    )	,
				'state_list'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert state.'				
                    )	,
				'short_desc'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please short description.'				
                    )	
		);
		$this->validate=$validate2;
		return $this->validates();
	}
	
	function uploadShowIcsFile(){	
		$validate3 = array(			
			'ics_file' => array(
				'rule'    => array('extension', array('ics')),
				'message' => 'Please supply a valid ics file.'
			)
		);
		$this->validate=$validate3;
		return $this->validates();
	}
	
	function uploadShowBannerFile(){	
		$validate4 = array(			
			'boutique_banner_file' => array(
				'rule'    => array('extension', array('jpg', 'jpeg', 'png', 'gif')),
				'message' => 'Please supply a valid banner file(.jpg,.jpeg,.png,.gif).'
			)
		);
		$this->validate=$validate4;
		return $this->validates();
	}
	
 function showName($id = null){
	   return $this->Show->find("first",array('conditions'=>array('id'=>$id),'fields'=>array('show_dt','show_name')));
   }
	   
	   
	   

}
