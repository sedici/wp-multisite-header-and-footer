<?php

namespace SediciMultisiteFooter\Inc;

interface Footer_Interface {
    public function is_enabled();
    public function disable_footer();
    public function enable_footer();
    public function render_footer();
}

?>