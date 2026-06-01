<?php
/**
 * Plantilla del Footer Global SEDICI
 * @var array $args Datos inyectados a través de load_template()
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Seguridad
}
?>

<footer class="sedici-global-footer" style="background-color: <?php echo esc_attr( $args['color_fondo'] ); ?>;">
    
    <div class="footer-logo-container">
        <?php if ( ! empty( $args['logo_dependencia'] ) ) : ?>
            <a href="<?php echo esc_url( $args['url_dependencia'] ); ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?php echo esc_url( $args['logo_dependencia'] ); ?>" alt="Logo <?php echo esc_attr( $args['nombre_dependencia'] ); ?>">
            </a>
        <?php endif; ?>
    </div>

    <div class="footer-text-container">
        <p>
            Sitio web desarrollado en colaboración con
            <strong><?php echo esc_html( $args['nombre_dependencia'] ); ?></strong> 
            | 
            <?php echo esc_html( $args['nombre_institucion'] ); ?>
        </p>
    </div>

    <?php if ( ! empty( $args['logo_secundario'] ) ) : ?>
        <div class="footer-logo-right-container">
            <a href="<?php echo esc_url( $args['url_institución'] ); ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?php echo esc_url( $args['logo_secundario'] ); ?>" alt="Logo Institución">
            </a>
        </div>
    <?php endif; ?>

</footer>