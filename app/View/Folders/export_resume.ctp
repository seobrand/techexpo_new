<?php

ob_end_clean(); // Just in case, to be sure

// Get a new instance of TBS with the OpenTBS plug-in
$otbs = $this->Tbs->getOpenTbs(); 

$otbs->ResetVarRef(false); 
// Load the DOCX template which is supposed to be placed in the same folder
$otbs->LoadTemplate(dirname(__FILE__).'/export_template1.docx');


// Merge data in the template
$otbs->MergeBlock('a.b', $yourname);

// End the merge and export
$file_name = 'export.docx';
$otbs->Show(OPENTBS_DOWNLOAD, $file_name);

exit; // Just in case, to be sure