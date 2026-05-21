<?php

namespace SediciMultisiteFooter\Inc;

class Single_Site_Footer extends Footer_Interface {
    
    public function is_enabled() {
        return get_option('sedici_footer_status') == 1;
    }

    public function disable_footer() {
        update_option('sedici_footer_status', 0);
    }

    public function enable_footer() {
        update_option('sedici_footer_status', 1);
    }
}


?>