<?php
namespace SediciMultisiteFooter\Admin;


class Admin {

    public function __construct() {
        add_action('network_admin_menu',array($this,'add_plugin_admin_menu'),30); 
        add_action( 'admin_init', array($this,'footer_settings'), 30 );
        add_action('network_admin_edit_footer_update_network_options',array($this,'footer_update_network_options'));        
    }


    /**
     * Agrega el submenú bajo la pestaña "Sitios"
     */
    public function add_plugin_admin_menu() {

        add_submenu_page(
            'sites.php',                  
            'Configuración Global Footer', 
            'Configuración Footer Global',               
            'manage_network_options',      
            'sedici-global-footer',      
            [ $this, 'render_form_multisite_footer' ]
        );
    
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

	public function render_form_multisite_footer()
    {
        include_once dirname(__DIR__) . '/admin/views/adminMenu/footer-form.php';
    }

}
?>