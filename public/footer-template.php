<?php
/**
 * Plantilla del Footer Global SEDICI
 * * @var array $args Datos inyectados a través de load_template()
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Seguridad
}
?>

<footer class="sedici-global-footer" style="background-color: <?php echo esc_attr( $args['color_fondo'] ); ?>; color: <?php echo esc_attr( $args['color_texto'] ); ?>; display: flex; justify-content: space-between; align-items: center; padding: 20px; box-sizing: border-box;">
    
    <div class="footer-logo-container">
        <?php if ( ! empty( $args['logo_url'] ) ) : ?>
            <a href="<?php echo esc_url( $args['enlace_dependencia'] ); ?>" target="_blank" rel="noopener noreferrer" style="display: block;">
                <img src="<?php echo esc_url( $args['logo_url'] ); ?>" alt="Logo <?php echo esc_attr( $args['nombre_dependencia'] ); ?>" style="max-height: 60px; width: auto; display: block;">
            </a>
        <?php endif; ?>
    </div>

    <div class="footer-text-container" style="text-align: right; font-size: 14px; font-family: sans-serif;">
        <p style="margin: 0; line-height: 1.5;">
            Sitio web desarrollado en colaboración con 
            <strong><?php echo esc_html( $args['nombre_dependencia'] ); ?></strong> 
            | 
            <?php echo esc_html( $args['nombre_institucion'] ); ?>
        </p>
    </div>

</footer>