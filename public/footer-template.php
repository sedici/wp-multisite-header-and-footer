<?php
/**
 * Plantilla del Footer Global SEDICI
 * @var array $args Datos inyectados a través de load_template()
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Seguridad
}
?>

<footer class="sedici-global-footer" style="background-color: <?php echo esc_attr( $args['datos_footer']['color_fondo'] ); ?>;">
    
    <!-- Contenedor de Logos Izquierdos -->
    <div class="footer-logo-container" style="display: flex; align-items: center; gap: 15px;">
        <?php if ( $args['variante_elegida'] === 'prebi-cesgi' ) : ?>
            
            <!-- Logo 1 (PREBI-SEDICI) -->
            <?php if ( ! empty( $args['datos_footer']['logo_dependencia1'] ) ) : ?>
                <a href="<?php echo esc_url( $args['datos_footer']['url_dependencia1'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo esc_url( $args['datos_footer']['logo_dependencia1'] ); ?>" alt="Logo <?php echo esc_attr( $args['datos_footer']['nombre_dependencia1'] ); ?>">
                </a>
            <?php endif; ?>

            <!-- Logo 2 (CESGI) -->
            <?php if ( ! empty( $args['datos_footer']['logo_dependencia2'] ) ) : ?>
                <a href="<?php echo esc_url( $args['datos_footer']['url_dependencia2'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo esc_url( $args['datos_footer']['logo_dependencia2'] ); ?>" alt="Logo <?php echo esc_attr( $args['datos_footer']['nombre_dependencia2'] ); ?>">
                </a>
            <?php endif; ?>

        <?php else : ?>
            
            <!-- Comportamiento estándar para un solo logo -->
            <?php if ( ! empty( $args['datos_footer']['logo_dependencia'] ) ) : ?>
                <a href="<?php echo esc_url( $args['datos_footer']['url_dependencia'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo esc_url( $args['datos_footer']['logo_dependencia'] ); ?>" alt="Logo <?php echo esc_attr( $args['datos_footer']['nombre_dependencia'] ); ?>">
                </a>
            <?php endif; ?>

        <?php endif; ?>
    </div>

    <!-- Contenedor de Texto Central -->
    <div class="footer-text-container">
        <p>
            Sitio web desarrollado en colaboración con
            <?php if ( $args['variante_elegida'] === 'prebi-cesgi' ) : ?>
                
                <!-- Dependencia1 y Dependencia2-->
                <a href="<?php echo esc_url( $args['datos_footer']['url_dependencia1'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <strong><?php echo esc_html( $args['datos_footer']['nombre_dependencia1'] ); ?></strong>    
                </a> 
                y 
                <a href="<?php echo esc_url( $args['datos_footer']['url_dependencia2'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <strong><?php echo esc_html( $args['datos_footer']['nombre_dependencia2'] ); ?></strong>
                </a> 
                |
                <a href="<?php echo esc_url( $args['datos_footer']['url_institución1'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html( $args['datos_footer']['nombre_institucion1'] ); ?>
                </a>
                y
                <a href="<?php echo esc_url( $args['datos_footer']['url_institución2'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html( $args['datos_footer']['nombre_institucion2'] ); ?>
                </a>

            <?php else : ?>
                
                <!-- Comportamiento estándar para una sola dependencia -->
                <a href="<?php echo esc_url( $args['datos_footer']['url_dependencia'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <strong><?php echo esc_html( $args['datos_footer']['nombre_dependencia'] ); ?></strong>
                </a> 
                | 
                <a href="<?php echo esc_url( $args['datos_footer']['url_institución'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html( $args['datos_footer']['nombre_institucion'] ); ?>
                </a>

            <?php endif; ?>
        </p>
    </div>

    <!-- Logo Secundario Derecho (Solo si aplica)-->
    <?php if ( $args['variante_elegida'] == 'prebi-sedici' && ! empty( $args['datos_footer']['logo_secundario'] ) ) : ?>
        <div class="footer-logo-right-container">
            <a href="<?php echo esc_url( $args['datos_footer']['url_logo_secundario'] ); ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?php echo esc_url( $args['datos_footer']['logo_secundario'] ); ?>" alt="Logo Institución">
            </a>
        </div>
    <?php endif; ?>

</footer>