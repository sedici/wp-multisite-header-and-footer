<?php
/**
 * Vista para el formulario del Footer.
 *
 * @var \Wp_multisite_manager\Inc\HeaderFooterService $service
 */

// Lógica para determinar a dónde debe apuntar el formulario
$is_network_admin = is_network_admin();
$form_action_url = $is_network_admin ? admin_url('edit.php?action=footer_update_network_options') : admin_url('admin-post.php');
?>
<div class="wrap">
    <h1><?php echo $is_network_admin ? 'Configuración del Footer de Red' : 'Configuración del Footer del Sitio'; ?></h1>
    <hr>
    <form method="POST" action="<?php echo esc_url($form_action_url); ?>" enctype="multipart/form-data">

        <?php
        if ($is_network_admin) {
            settings_fields('footer_settings');
            do_settings_sections('footer_settings');
        } else {
            wp_nonce_field('save_site_footer_options', 'footer_nonce');
            echo '<input type="hidden" name="action" value="save_site_footer_options">';
        }
        ?>

        <div class="general-form-field">
            <h2 class="filds-titles"><?php _e("Habilitar Footer", 'wp-multisite-manager'); ?></h2>
            <input type="checkbox" name="footer_enabled" value="1" <?php checked($service->get_value('footer_enabled'), 1); ?> />
             <?php if (!$is_network_admin) : ?>
                <p class="description"><?php _e("Activa esta opción para sobrescribir el footer de la red con uno personalizado para este sitio.", 'wp-multisite-manager'); ?></p>
            <?php endif; ?>
        </div>

        <div class="general-form-field">
            <h3 class="filds-titles"><?php _e("Links de redes sociales", 'wp-multisite-manager'); ?></h3>
            <label for="footer_fb"><?php _e("Facebook:", 'wp-multisite-manager'); ?></label>
            <input type="url" name="footer_fb" value="<?php echo esc_attr($service->get_value('footer_fb')); ?>"><br><br>
            <label for="footer_tw"><?php _e("Twitter:", 'wp-multisite-manager'); ?></label>
            <input type="url" name="footer_tw" value="<?php echo esc_attr($service->get_value('footer_tw')); ?>"><br><br>
            <label for="footer_ig"><?php _e("Instagram:", 'wp-multisite-manager'); ?></label>
            <input type="url" name="footer_ig" value="<?php echo esc_attr($service->get_value('footer_ig')); ?>">
        </div>

        <div class="general-form-field">
            <h3 class="filds-titles"><?php _e("Contacto", 'wp-multisite-manager'); ?></h3>
            <label for="footer_email"><?php _e("Email:", 'wp-multisite-manager'); ?></label>
            <input type="email" name="footer_email" value="<?php echo esc_attr($service->get_value('footer_email')); ?>"><br><br>
            <label for="footer_phone"><?php _e("Teléfono:", 'wp-multisite-manager'); ?></label>
            <input type="tel" name="footer_phone" value="<?php echo esc_attr($service->get_value('footer_phone')); ?>">
        </div>

        <div class="general-form-field">
            <h3 class="filds-titles"><?php _e("Texto central", 'wp-multisite-manager'); ?></h3>
            <input type="text" name="footer_text" class="regular-text" value="<?php echo esc_attr($service->get_value('footer_text')); ?>">
            <h4 class="filds-titles"><?php _e("Enlace del texto", 'wp-multisite-manager'); ?></h4>
            <input type="url" name="footer_text_link" class="regular-text" value="<?php echo esc_attr($service->get_value('footer_text_link')); ?>">
        </div>

        <hr>

        <h2 class="section-heading"><?php _e("Sección de Imágenes", 'wp-multisite-manager'); ?></h2>
         <div id="images-container">
            <h3 style="font-size:large"><?php _e("Imágenes actuales", 'wp-multisite-manager'); ?></h3>
            <div class="form-image-container">
                <?php
                $footer_images = $service->get_value('footer_images');
                if (!empty($footer_images) && is_array($footer_images)) {
                    foreach ($footer_images as $image) {
                         echo '<div class="form-image-box"> 
                                <img class="form-image" src="' . esc_url(wp_get_attachment_url($image["id"])) . '">
                                <input type="url" required name="link_' . esc_attr($image['id']) . '" value="' . esc_attr($image["link"]) . '">
                                <a href="#" class="trashImg" title="Eliminar imagen"><span class="dashicons dashicons-trash"></span></a>
                              </div>';
                    }
                } else {
                    echo "<p>No hay imágenes actualmente.</p>";
                }
                ?>
            </div>
            <br>
            <h3 style="font-size:large"><?php _e("Agregar nuevas imágenes", 'wp-multisite-manager'); ?></h3>
            <div id="dynamic-image-inputs">
                <div class="general-form-field image-row">
                    <div>
                        <h4 class="filds-titles"><?php _e("Subir imagen 1", 'wp-multisite-manager'); ?></h4>
                        <input type="file" name="image-1">
                    </div>
                    <div>
                        <h4 class="filds-titles"><?php _e("Link asociado a la imagen 1", 'wp-multisite-manager'); ?></h4>
                        <input type="url" name="image_link-1">
                    </div>
                </div>
            </div>
        </div>
        <div class="button-containers">
            <button id="add-img-input" type="button" class="add-btn" value="1"><?php _e("Agregar otra imagen", 'wp-multisite-manager'); ?></button>
        </div>

        <hr>

        <h2 class="section-heading"><?php _e("Estilos Personalizados", 'wp-multisite-manager'); ?></h2>
        <div class="general-form-field">
            <h4 class="filds-titles"><?php _e("CSS del Footer", 'wp-multisite-manager'); ?></h4>
            <textarea class="area_texto" name="footer_css"><?php echo esc_textarea($service->get_value('footer_css')); ?></textarea>
        </div>

        <?php submit_button(); ?>
    </form>
</div>