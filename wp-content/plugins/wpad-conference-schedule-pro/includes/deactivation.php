<?php

function wpcsp_pro_deactivation(){

    flush_rewrite_rules();
    
    delete_transient('wpcsp_license_valid');
    
}
