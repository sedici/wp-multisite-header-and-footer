<?php

namespace SediciMultisiteFooter\Inc;

interface FooterInterface {
    public function is_enabled();
    public function disable_footer();
    public function enable_footer();
    public function render_footer();
}

?>