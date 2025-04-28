<?php
namespace Wp_multisite_manager\Admin;

use Sites_table;
use Wp_multisite_manager as MM;

require_once plugin_dir_path( __DIR__ ) . 'helpers.php'; 




class multisiteAdmin{
    private $plugin_name;
    private $version;
    private $plugin_basename;
    private $plugin_text_domain;
    private $sites_table;
    private $cpt_list_table;

    public function __construct() {

        $this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;
      
        #  Esta función sirve para saber si se realizo algún POST de un formulario
        #  add_action('template_redirect', 'check_for_event_submissions');
      
        add_action('network_admin_menu',array($this,'add_Multisite_Menu_Pages'),30); 

        add_action( 'admin_init', array($this,'header_settings'), 30 );
        add_action( 'admin_init', array($this,'footer_settings'), 30 );

        // Registro las settings para formularios de HEADER Y FOOTER
        add_action('network_admin_edit_header_update_network_options',array($this,'header_update_network_options'));
        add_action('network_admin_edit_footer_update_network_options',array($this,'footer_update_network_options'));        

    }


  



    


    /**
     * Registra toda la configuración del header con la API de Settings de Wordpress
     *      
    */
    function header_settings() {
        register_setting( 'header_settings', 'enabled' );
        register_setting( 'header_settings', 'title_text' );
        register_setting( 'header_settings', 'title_link' );
        register_setting( 'header_settings', 'header_text' );

        register_setting( 'header_settings', 'header_css');
      
        register_setting( 'header_settings', 'header_images');
        /*  Header Settings => Array de imagenes con la siguiente estructura:
            [[0] {
                    "id" => id_De_Media_Upload,
                    "link" => link
                },
             [1] {
                    "id" => id_De_Media_Upload,
                    "link" => link
            }
            ] */
    }

    /**
     * Registra toda la configuración del footer con la API de Settings de Wordpress
     *      
    */
    function footer_settings() {
        register_setting( 'footer_settings', 'footer_enabled' );
        
        register_setting( 'footer_settings', 'footer_fb' );
        register_setting( 'footer_settings', 'footer_tw' );
        register_setting( 'footer_settings', 'footer_ig' );
        
        register_setting( 'footer_settings', 'footer_text' );
        register_setting( 'footer_settings', 'footer_text_link' );

        register_setting( 'footer_settings', 'footer_email' );
        register_setting( 'footer_settings', 'footer_phone' );


        register_setting( 'footer_settings', 'footer_images');

        register_setting( 'footer_settings', 'footer_css' );

    }


    function header_update_network_options(){
        #check_admin_referer('config-header-options');
       // $this->process_header_images();
       
        global $new_allowed_options;
        $options = $new_allowed_options['header_settings'];
        
        foreach ($options as $option) {
            if($option == "header_images"){
                $this->process_images($option);
            }
            else if (isset($_POST[$option])) {
                    update_site_option($option, $_POST[$option]);
            } else {
                delete_site_option($option);
            }
        }
        
        wp_redirect(add_query_arg(array('page' => 'config-header',
        'updated' => 'true'), network_admin_url('admin.php')));
        exit;
    }

    /**
     * Itera sobre $_FILES buscando todas las imágenes que se hayan subido, y busca el link para cada una.
     * @param String $option Nos indica que setting debemos cargar, puede ser header_images o footer_images
    */
    function process_images($option){
        $images_array = get_site_option($option);
        if($images_array == false){
            $images_array = array();
        }
        else{

            $images_array = $this->check_updated_image_data($images_array);
        }
        // Itero sobre el array de FILES para quedarme con todos los campos que sean imagenes
        foreach ($_FILES as $index => $file_data){
            if(  (strpos($index,"image") !== false) ){
                if($file_data["error"] == false){
                    // Me quedo con el número de imagen
                    $imageNumber = str_replace("image",'', $index);
                    if( !is_wp_error($file_data["name"])){
                    // Construyo el nombre de link para buscarlo
                    $imageLink= "image_link" . $imageNumber;

                    if (isset($_POST[$imageLink]) and (!is_wp_error($_POST[$imageLink])) ){

                        $image_id = media_handle_upload($index,0 );
                        if(!is_wp_error($image_id)){

                            $imageElement = [
                                "id" => $image_id,
                                "link"=> $_POST[$imageLink]
                                ];
                                array_push($images_array,$imageElement) ;
                        }
                        else{
                            echo "<script> alert('Ocurrio un error al subir la imagen número ". $index ."') </script>";
                        }

    
                    }
                    } 
                }
            }
        }

        update_site_option($option, $images_array);
    }

    function check_updated_image_data($images){

        $updatedImages = $images;
        // Reviso si los ids que tenia en la BD estan presentes en el POST

        if(isset($images)){
            foreach ($images as $key=>$image){
                $link = "link_" . strval($image["id"]);
    
                // Si estan presentes actualizo el link por las dudas
                if(array_key_exists($link, $_POST)){
                    $updatedImages[$key]["link"] = $_POST[$link];
                }
                // Si no esta presente, elimino el dato de la BD
                else{
                    wp_delete_attachment($updatedImages[$key]['id']);
                    unset($updatedImages[$key]);
                }
            }
            return $updatedImages;    
        }
        return false;
    }

    
    function footer_update_network_options(){
        #check_admin_referer('config-header-options');
        global $new_allowed_options;
        $options = $new_allowed_options['footer_settings'];
        foreach ($options as $option) {

            if($option == "footer_images"){
                $this->process_images($option);
            }

            else if (isset($_POST[$option])) {
                update_site_option($option, $_POST[$option]);
            } else {
                delete_site_option($option);
            }
        }
            
        wp_redirect(add_query_arg(array('page' => 'config-footer',
        'updated' => 'true'), network_admin_url('admin.php')));
        exit;
    }
    
        

    # Register all the MULTISITE Menu pages --------------------------------------------------------------

    public function add_Multisite_Menu_Pages() {

        // 1. Crear el menú padre que apunta directamente al primer hijo (Administrar Header)
        add_menu_page(
            __('Multisite Header and Footer', $this->plugin_text_domain), 
            __('Multisite Header and Footer', $this->plugin_text_domain), 
            'manage_options',
            'config-header',
            array($this, 'header_menu_page'), 
            'dashicons-admin-generic', 
            6
        );
    
        // 2. Submenú: Administrar Header
        add_submenu_page(
            'config-header', // Slug del menú padrE
            __('Administrar Header', $this->plugin_text_domain), // Título de la página Header
            __('Administrar Header', $this->plugin_text_domain), // Texto del submenú
            'manage_options', // Capacidad requerida
            'config-header', // Slug (mismo que el padre)
            array($this, 'header_menu_page') // Función de callback
        );
    
        // 3. Submenú: Administrar Footer
        add_submenu_page(
            'config-header', // Slug del menú padre
            __('Administrar Footer', $this->plugin_text_domain), // Título de la página Footer
            __('Administrar Footer', $this->plugin_text_domain), // Texto del submenú
            'manage_options', // Capacidad requerida
            'config-footer', // Slug
            array($this, 'footer_menu_page') // Función de callback
        );
    
    }
	




    /**
     * Imprime las imágenes que se encuentran cargadas, ya sea en Header o en Footer
     * @param String $option indica que opción recuperar (header_images o footer_images)
    */
    public function print_option_images($option){
        
        $images = get_site_option($option);

        if ($images !== false){
            echo "<div class='form-image-container'>";
            foreach ($images as $image){
                echo '<div class="form-image-box"> 
                            <img class="form-image" src="' . wp_get_attachment_url($image["id"]) . '"></img>
                            <input type="url" style="overflow:hidden;" required="" name="link_'. $image['id'] . '" value="'. $image["link"] . '">
                            <a style="text-decoration:none;" class="trashImg"> 
                            <span style="font-size: 30px;margin-bottom:10px;"  class="dashicons dashicons-trash"></span> </a>
                      </div>';
            }
            echo "</div>";
        }
                else{
            echo "<p style='font-size:medium'> No hay imágenes actualmente</p>";
        }
        
    }

	public function header_menu_page()
    {
        include_once dirname(__DIR__) . '/admin/views/adminMenu/header-form.php';
    }


	public function footer_menu_page()
    {
        include_once dirname(__DIR__) . '/admin/views/adminMenu/footer-form.php';
    }

}
?>