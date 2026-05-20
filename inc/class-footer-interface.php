<?php

namespace SediciMultisiteFooter\Inc;

abstract class Footer_Interface {
    public abstract function is_enabled();
    public abstract function disable_footer();
    public abstract function enable_footer();
    public abstract function render_footer();
}

?>