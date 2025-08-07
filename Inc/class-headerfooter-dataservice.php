<?php
namespace Wp_multisite_manager\Inc;
class HeaderFooter_DataService {
    private $context; // 'network' o 'site'

    public function __construct(string $context) {
        $this->context = $context;
    }

    public function get_value(string $option_name) {
        if ($this->context === 'site') {
            return get_option('mshf_override_' . $option_name);
        }
        return get_site_option($option_name);
    }
 
    public function save_form_data(array $post_data) {
       if (isset($post_data['header_layout']) && is_array($post_data['header_layout'])) {
        $this->process_header_layout_blocks($post_data['header_layout']);
       if( !empty($_FILES)){
        $this->process_uploaded_files($_FILES);

       }
    }

     
    }

 private function process_header_layout_blocks(array $header_layout) {
    foreach ($header_layout as $column_id => $blocks) {
        foreach ($blocks as $block_index => $block_data) {
            if (!isset($block_data['data']) ) {
                continue; // Saltar bloques sin sección "data"
            }
            $data = $block_data['data'];
            foreach ($data as $field => $value) {
                $this->save_value($field, $value);
            }           
        }
    }
}


    
  public function save_value(string $option_name, $value) {
        if ($this->context === 'site') {
            update_option('_mshf_override' . $option_name, $value);
        } else {
            update_site_option($option_name, $value);

        }
    }

    public function process_uploaded_files(array $files) {
    // Asegurarse de que WordPress cargó las funciones necesarias
    if (!function_exists('wp_handle_upload')) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }

    if (!function_exists('media_handle_sideload')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    // Iterar sobre las entradas
    foreach ($files as $field_name => $field_data) {
        foreach ($field_data['tmp_name'] as $column_id => $blocks) {
            foreach ($blocks as $block_index => $block_files) {
                foreach ($block_files as $input_name => $tmp_path) {
                    // Si no hay archivo subido, seguir
                    if (empty($tmp_path)) continue;

                    $file = [
                        'name'     => $files[$field_name]['name'][$column_id][$block_index][$input_name],
                        'type'     => $files[$field_name]['type'][$column_id][$block_index][$input_name],
                        'tmp_name' => $files[$field_name]['tmp_name'][$column_id][$block_index][$input_name],
                        'error'    => $files[$field_name]['error'][$column_id][$block_index][$input_name],
                        'size'     => $files[$field_name]['size'][$column_id][$block_index][$input_name],
                    ];

                    // Procesar el archivo
                    $overrides = ['test_form' => false];
                    $upload = wp_handle_upload($file, $overrides);

                    if (!isset($upload['file'])) {
                        continue; // Falló el upload
                    }

                    // Crear array de archivo para media_handle_sideload
                    $file_array = [
                        'name'     => $file['name'],
                        'tmp_name' => $upload['file'],
                    ];

                    // Cambiar a sitio principal si es necesario
                     // Cambiar temporalmente de blog si es necesario
                    if ($this->context === 'site' && is_multisite()) {
                        $blog_id = get_current_blog_id();
                        switch_to_blog($blog_id);
                    }
                    // Subir a media library
                    $attachment_id = media_handle_sideload($file_array, 0);

                    if (is_wp_error($attachment_id)) {
                        error_log('Error al subir imagen: ' . $attachment_id->get_error_message());
                    }

                    // Volver al blog original si cambiamos
                    if ($this->context === 'site' && is_multisite()) {
                        restore_current_blog();
                    }
                }
            }
        }
    }
}










    private function process_images(string $option_name) {
        $images_array = $this->get_value($option_name) ?: [];
        $images_array = $this->check_updated_image_data($images_array);

        foreach ($_FILES as $index => $file_data) {
            if (strpos($index, "image") !== false && $file_data["error"] == 0) {
                $imageNumber = str_replace("image", '', $index);
                $imageLinkKey = "image_link" . $imageNumber;

                if (isset($_POST[$imageLinkKey])) {
                    $image_id = media_handle_upload($index, 0);
                    if (!is_wp_error($image_id)) {
                        array_push($images_array, ["id" => $image_id, "link" => $_POST[$imageLinkKey]]);
                    }
                }
            }
        }
        
        $this->save_value($option_name, $images_array);
    }

    private function check_updated_image_data(array $images): array {
        $updatedImages = $images;
        if (!empty($images)) {
            foreach ($images as $key => $image) {
                $link_key = "link_" . strval($image["id"]);
                if (array_key_exists($link_key, $_POST)) {
                    $updatedImages[$key]["link"] = $_POST[$link_key];
                } else {
                    wp_delete_attachment($updatedImages[$key]['id'], true);
                    unset($updatedImages[$key]);
                }
            }
            return array_values($updatedImages);
        }
        return [];
    }
}


