<?php

namespace SediciMultisiteFooter\Inc;

class Single_Site_Footer implements Footer_Interface {
    
    public function is_enabled() {
        return get_option('sedici_footer_status') == 1;
    }

    public function disable_footer() {
        update_option('sedici_footer_status', 0);
    }

    public function enable_footer() {
        update_option('sedici_footer_status', 1);
    }

    public function render_footer() {
        if ( ! $this->is_enabled() ) {
            return;
        }

        include_once dirname(__DIR__) . '/admin/views/adminMenu/footer-content.php';
    }
}


?>