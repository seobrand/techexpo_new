<?php

class TbsHelper extends AppHelper {

    function getOpenTbs() {
        App::import('Vendor', 'tbs/tbs_class_php5');
        App::import('Vendor', 'tbs/tbs_plugin_opentbs');

        $tbs  = new clsTinyButStrong; // new instance of TBS
        $tbs->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load OpenTBS plugin   
        return $tbs;
    }

}