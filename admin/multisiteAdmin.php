<?php
namespace Wp_multisite_manager\Admin;

use Wp_multisite_manager as MM;
use Wp_multisite_manager\Inc\HeaderFooter_DataService;

class multisiteAdmin {
    private $plugin_name;
    private $version;
    private $plugin_text_domain;

    public function __construct() {
        $this->plugin_name = MM\PLUGIN_NAME;
        $this->version = MM\PLUGIN_VERSION;
        $this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;

        // --- Hooks de Administración de Red ---
        add_action('network_admin_menu', [$this, 'add_multisite_menu_pages']);
        add_action('network_admin_edit_header_update_network_options', [$this, 'header_update_network_options']);
        add_action('network_admin_edit_footer_update_network_options', [$this, 'footer_update_network_options']);
    }

    /**
     * Registra las páginas del menú en el panel de red.
     */
    public function add_multisite_menu_pages() {
        add_menu_page(
            'Header y Footer de Red',
            'Header/Footer Red',
            'manage_options',
            'config-header',
            [$this, 'header_menu_page'],
            'dashicons-layout',
            6
        );
        add_submenu_page(
            'config-header',
            'Administrar Header',
            'Administrar Header',
            'manage_options',
            'config-header',
            [$this, 'header_menu_page']
        );
        add_submenu_page(
            'config-header',
            'Administrar Footer',
            'Administrar Footer',
            'manage_options',
            'config-footer',
            [$this, 'footer_menu_page']
        );
    }

    /**
     * Muestra la página de configuración del Header.
     */
    public function header_menu_page() {
        $service = new HeaderFooter_DataService('network');

        // El objeto $service estará disponible en el archivo de la vista.
        include_once MM\PLUGIN_NAME_DIR . 'admin/views/adminMenu/header-form.php';
    }

    /**
     * Muestra la página de configuración del Footer.
     */
    public function footer_menu_page() {
        $service = new HeaderFooter_DataService('network');
        include_once MM\PLUGIN_NAME_DIR . 'admin/views/adminMenu/footer-form.php';
    }

    /**
     * Guarda los datos del formulario del Header de red.
     */
    public function header_update_network_options() {
        // La validación (check_admin_referer) la maneja WordPress aquí.
        $service = new HeaderFooter_DataService('network');
        $service->save_form_data($_POST);
        
        wp_redirect(add_query_arg(['page' => 'config-header', 'updated' => 'true'], network_admin_url('admin.php')));
        exit;
    }

    /**
     * Guarda los datos del formulario del Footer de red.
     */
    public function footer_update_network_options() {
        $service = new HeaderFooter_DataService('network');
        $service->save_form_data($_POST);
        
        wp_redirect(add_query_arg(['page' => 'config-footer', 'updated' => 'true'], network_admin_url('admin.php')));
        exit;
    }
}