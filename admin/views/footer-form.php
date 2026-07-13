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


    <!-- 1. Sección de Sincronización (Solo para subsitios) -->

    <?php if ( ! $args['is_network_admin_interface'] ) : ?>

        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

            <input type="hidden" name="action" value="sedici_footer_sync_with_network">

            <input type="hidden" name="input_sync_status" value="<?php echo $args['is_footer_sync_with_network'] ? '0' : '1'; ?>">

            <input type="hidden" name="sedici_admin_context" value="<?php echo $args['is_network_admin_interface'] ? 'network' : 'subsite'; ?>">

            <?php wp_nonce_field('sedici_footer_sync_with_network', 'sedici_multisite_footer_nonce'); ?>


            <div style="margin-top: 20px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px; box-shadow: 0 1px 1px rgba(0,0,0,.04); border-left: 4px solid #00a0d2;">
                <h2 style="margin-top: 0; font-size: 14px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Sincronización con la Red</h2>
                
                <p style="margin-bottom: 15px;">
                    <?php if ( $args['is_footer_sync_with_network'] ) : ?>
                        Este sitio está <strong>sincronizado</strong>. Hereda dinámicamente la configuración global de la red.
                    <?php else : ?>
                        Este sitio tiene una <strong>configuración local propia</strong>. Puedes volver a sincronizarlo para heredar los valores de la red.
                    <?php endif; ?>
                </p>

                <p class="submit" style="margin: 0; padding: 0;">
                    <input type="submit" name="submit_sync_form" class="button button-secondary" value="<?php echo $args['is_footer_sync_with_network'] ? 'Desincronizar de la red' : 'Sincronizar con la red'; ?>">
                </p>
            </div>
        </form>

    <?php endif; ?>


    <!-- 2. Configuración de Visibilidad y Diseño (Solo si NO está sincronizado o es la interfaz de Red) -->

    <?php if ( $args['is_network_admin_interface'] || ! $args['is_footer_sync_with_network'] ) : ?>

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
                            <strong>Habilitar el footer local</strong>
                        <?php endif; ?>
                    </label>
                        <?php if ($args['is_network_admin_interface'] === true) : ?>
                            <p class="description" style="margin-top: 8px; margin-left: 24px;">Al activar esta opción, todos los sitios del multisitio heredarán el diseño global del footer establecido por la red (siempre que estén sincronizados).</p>
                        <?php else : ?>
                            <p class="description" style="margin-top: 8px; margin-left: 24px;">Al activar esta opción, el footer será visible en este sitio utilizando la configuración local.</p>
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
                    <h2 style="margin-top: 0; font-size: 14px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Seleccionar diseño</h2>

                    <div style="margin-bottom: 20px;">
                        <label for="mi_desplegable" style="display: block; font-weight: 600; margin-bottom: 8px;">
                            Selecciona una opción:
                        </label>
                        <select name="sedici_footer_option_selected" id="mi_desplegable" class="regular-text">
                            <?php 
                            if ( ! empty( $args['form_options'] ) && is_array( $args['form_options'] ) ) {
                                foreach ( $args['form_options'] as $opcion ) {
                                    
                                    $nombre_opcion = ucwords( str_replace( '-', ' ', $opcion ) );
                                    
                                    echo '<option value="' . esc_attr( $opcion ) . '" ' . selected( $args['footer_type_selected'], $opcion, false ) . '>' . esc_html( $nombre_opcion ) . '</option>';
                                }
                            } else {
                                echo '<option value="">No hay variantes disponibles</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <p class="submit" style="margin: 0; padding: 0;">
                        <input type="submit" name="submit_simple_form" class="button button-primary" value="Guardar diseño">
                    </p>
                </div>
            </form>
    
        <?php endif; ?>

    <?php endif; ?>
    
</div>
