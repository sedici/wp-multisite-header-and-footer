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
    }

     
    }

 private function process_header_layout_blocks(array $header_layout) {
    foreach ($header_layout as $column_id => $blocks) {
        foreach ($blocks as $block_index => $block_data) {
            if (!isset($block_data['data']) || !is_array($block_data['data'])) {
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
            var_dump($option_name, $value); // Debugging
            update_option('_mshf_override' . $option_name, $value);
        } else {
            update_site_option($option_name, $value);
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


