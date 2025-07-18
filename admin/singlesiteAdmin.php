<?php
namespace Wp_multisite_manager\Admin;

use Wp_multisite_manager as MM;
use Wp_multisite_manager\Inc\HeaderFooter_DataService; // Usar la nueva clase
use Wp_multisite_manager\Inc\My_Template_Loader;

class singlesiteAdmin {
    private $plugin_name;
    private $version;
    private $plugin_text_domain;

    public function __construct() {
        $this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;

        // --- Hooks para el Frontend (Público) ---
        add_action('wp_head', [$this, 'registerHeader']);
        add_action('wp_footer', [$this, 'registerFooter']);

        // --- Hooks para el Backend (Administración del Sitio Individual) ---
        add_action('admin_menu', [$this, 'add_site_level_menu']);
        add_action('admin_post_save_site_header_options', [$this, 'save_site_header_options']);
        add_action('admin_post_save_site_footer_options', [$this, 'save_site_footer_options']);
    }

    // =============================================
    // MÉTODOS PARA EL FRONTEND (VISUALIZACIÓN)
    // =============================================

    public function registerHeader() {
        $service = new HeaderFooter_DataService('site');
        // Comprueba si el sitio individual tiene activada la sobrescritura
        if ($service->get_value('enabled')) {
            // Lógica para mostrar el header del SITIO
            // (Aquí se pasaría la data local a la plantilla)
        } else {
            // Fallback: Muestra el header de la RED (lógica original)
            $network_service = new HeaderFooter_DataService('network');
            if ($network_service->get_value('enabled')) {
                // ...Lógica original para cargar la plantilla con datos de la red...
                $templateLoader = My_Template_Loader::getInstance();
                $templateLoader->get_template_part("banner","structure",true);
            }
        }
    }

    public function registerFooter() {
        // Lógica similar a registerHeader, pero para el footer
    }

    // =========================================================
    // MÉTODOS PARA EL BACKEND (ADMINISTRACIÓN DEL SITIO)
    // =========================================================

    public function add_site_level_menu() {
        add_menu_page(
            'Header/Footer del Sitio',
            'Header/Footer Sitio',
            'manage_options',
            'site-header-footer',
            [$this, 'render_site_header_page'],
            'dashicons-admin-page'
        );
    }

    public function render_site_header_page() {
        echo '<h1>Configuración del Header para este Sitio</h1>';
        $service = new HeaderFooter_DataService('site');
        // El action del form debe apuntar a admin-post.php
        // Y debemos pasar un campo oculto: <input type="hidden" name="action" value="save_site_header_options">
        include_once MM\PLUGIN_NAME_DIR . 'admin/views/adminMenu/header-form.php';
    }

    public function save_site_header_options() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permiso para hacer esto.');
        }
        // Aquí iría la validación del nonce que pongas en el formulario

        $service = new HeaderFooter_DataService('site');
        $service->save_form_data($_POST);

        wp_redirect(admin_url('admin.php?page=site-header-footer&updated=true'));
        exit;
    }

    public function save_site_footer_options() {
        // Lógica similar para guardar el footer del sitio
    }
}