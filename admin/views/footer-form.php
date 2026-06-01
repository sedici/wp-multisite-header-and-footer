<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
} 
?>
<div class="wrap">

    <?php if ($args['is_network_admin_interface'] === true) : ?>
        <h1>Configuración del Footer Global</h1>
    <?php else : ?>
        <h1>Configuración del Footer</h1>
    <?php endif; ?>

    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

        <input type="hidden" name="action" value="sedici_footer_save_status">
        
        <input type="hidden" name="sedici_admin_context" value="<?php echo $args['is_network_admin_interface'] ? 'network' : 'subsite'; ?>">
        
        <?php wp_nonce_field('sedici_footer_save_status', 'sedici_multisite_footer_nonce'); ?>
        
        <div style="margin-top: 20px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
            <h2 style="margin-top: 0; font-size: 14px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Visibilidad</h2>
            
            <div style="margin-bottom: 15px;">
                <label for="footer_status">
                    <?php if ($args['is_network_admin_interface'] === true) : ?>
                        <input name="input_sedici_footer_status" type="checkbox" id="footer_status" value="1" <?php checked($args['footer_status'], 1); ?>>
                        <strong>Habilitar el footer global</strong>
                    <?php else : ?>
                        <input name="input_sedici_footer_status" type="checkbox" id="footer_status" value="1" <?php checked($args['footer_status'], 1); ?>>
                        <strong>Habilitar el footer</strong>
                    <?php endif; ?>
                </label>
                    <?php if ($args['is_network_admin_interface'] === true) : ?>
                        <p class="description" style="margin-top: 8px; margin-left: 24px;">Al activar esta opción, todos los sitios del multisitio heredarán el diseño global del footer establecido por la red.</p>
                    <?php else : ?>
                        <p class="description" style="margin-top: 8px; margin-left: 24px;">Al activar esta opción, el footer será visible en este sitio.</p>
                    <?php endif; ?>
            </div>
            
            <p class="submit" style="margin: 0; padding: 0;">
                <input type="submit" name="submit_status" id="submit_status" class="button button-primary" value="Guardar estado">
            </p>
        </div>
    </form>


    <?php if ( $args['footer_status'] === 1 ) : ?>
        
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            
            <input type="hidden" name="action" value="sedici_footer_selection">
            
            <input type="hidden" name="sedici_admin_context" value="<?php echo $args['is_network_admin_interface'] ? 'network' : 'subsite'; ?>">

            <?php wp_nonce_field('sedici_footer_save_type', 'sedici_multisite_footer_nonce'); ?>

            <div style="margin-top: 20px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; font-size: 14px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Diseño y Color</h2>

                <div style="margin-bottom: 20px;">
                    <label for="mi_desplegable" style="display: block; font-weight: 600; margin-bottom: 8px;">
                        Selecciona una opción:
                    </label>
                    <select name="sedici_gf_layout_simple" id="mi_desplegable" class="regular-text">
                        <?php 
                        if ( ! empty( $args['form_options'] ) && is_array( $args['form_options'] ) ) {
                            foreach ( $args['form_options'] as $opcion ) {
                                
                                $nombre_opcion = ucwords( str_replace( '-', ' ', $opcion ) );
                                
                                echo '<option value="' . esc_attr( $opcion ) . '">' . esc_html( $nombre_opcion ) . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay variantes disponibles</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="mi_color" style="display: block; font-weight: 600; margin-bottom: 8px;">
                        Selecciona un color de fondo:
                    </label>
                    <input type="color" name="sedici_gf_color_picker" id="mi_color" value="#0A1128" style="width: 60px; height: 35px; padding: 0; cursor: pointer; border: 1px solid #ccc; border-radius: 3px;">
                </div>

                <p class="submit" style="margin: 0; padding: 0;">
                    <input type="submit" name="submit_simple_form" class="button button-primary" value="Guardar configuración">
                </p>
            </div>
        </form>

    <?php endif; ?>

</div>