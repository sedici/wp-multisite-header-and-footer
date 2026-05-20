<?php

namespace SediciMultisiteFooter\Inc;

class Network_Footer implements FooterInterface {
    
    public function is_enabled() {
        return get_network_option(get_current_network_id(), 'sedici_footer_network_status') == 1;
    }

    public function disable_footer() {
        update_network_option(get_current_network_id(), 'sedici_footer_network_status', 0);
    }

    public function enable_footer() {
        update_network_option(get_current_network_id(), 'sedici_footer_network_status', 1);
    }

    public function render_footer() {
        if ( ! $this->is_enabled() ) {
            return;
        }

        include_once dirname(__DIR__) . '/admin/views/adminMenu/footer-content.php';
    }
}


?>