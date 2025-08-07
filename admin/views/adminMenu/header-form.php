<?php
/**
 * Vista para el formulario del Header.
 *
 * Este archivo es una plantilla y espera que una variable $service (HeaderFooterService)
 * esté disponible en su scope para obtener los datos.
 *
 * @var \Wp_multisite_manager\Inc\HeaderFooterService $service
 */

// Lógica para determinar a dónde debe apuntar el formulario
$is_network_admin = is_network_admin();
$form_action_url =admin_url('admin-post.php');
?>
<div class="wrap">
    <h1><?php echo $is_network_admin ? 'Configuración del Header de Red' : 'Configuración del Header del Sitio'; ?></h1>
    <hr>
    <form id="wp_multisite_hyf_form" method="POST" action="<?php echo esc_url($form_action_url); ?>" enctype="multipart/form-data">
   <input type="hidden" name="action" value="header_update_network_options">

    
<div class="column-container">
    <h3>Columna 1</h3>
    <div class="blocks-area" id="blocks-col-1">
        </div>
    
    <div class="add-block-controls">
        <select class="block-type-selector">
            <option value="title">Título</option>
            <option value="text">Texto</option>
            <option value="images">Imágenes</option>
        </select>
        <button type="button" class="button add-block-button" data-column="col-1">Añadir Bloque</button>
    </div>
</div>
<div class="column-container">
    <h3>Columna 2</h3>
    <div class="blocks-area" id="blocks-col-2">
        </div>
    
    <div class="add-block-controls">
        <select class="block-type-selector">
            <option value="title">Título</option>
            <option value="text">Texto</option>
            <option value="images">Imágenes</option>
        </select>
        <button type="button" class="button add-block-button" data-column="col-2">Añadir Bloque</button>
    </div>

    <div class="column-container">
    <h3>Columna 3</h3>
    <div class="blocks-area" id="blocks-col-3">
        </div>
    
    <div class="add-block-controls">
        <select class="block-type-selector">
            <option value="title">Título</option>
            <option value="text">Texto</option>
            <option value="images">Imágenes</option>
        </select>
        <button type="button" class="button add-block-button" data-column="col-3">Añadir Bloque</button>
    </div>
</div>




</div>

<template id="template-title-block">
    <div class="block">
        <strong>Bloque de Título</strong>
        <input type="text" name="header_layout[COLUMN_ID][BLOCK_INDEX][data][text]" placeholder="Texto del título">
        <input type="url" name="header_layout[COLUMN_ID][BLOCK_INDEX][data][link]" placeholder="Enlace">
        <button type="button" class="remove-block">Eliminar</button>
    </div>
</template>

<template id="template-text-block">
    <div class="block">
        <strong>Bloque de Texto</strong>
        <textarea name="header_layout[COLUMN_ID][BLOCK_INDEX][data][content]" placeholder="Texto descriptivo"></textarea>
        <button type="button" class="remove-block">Eliminar</button>
    </div>
</template>


<template id="template-images-block">
    <div class="block">
        <strong>Bloque de Imagen</strong>
        <div class="general-form-field image-row">
            <div>
                <h4 class="filds-titles">Subir imagen</h4>
                <input type="file" name="header_layout[COLUMN_ID][BLOCK_INDEX][image]">
            </div>
            <div>
                <h4 class="filds-titles">Link asociado a la imagen</h4>
                <input type="url" name="header_layout[COLUMN_ID][BLOCK_INDEX][link]" placeholder="https://ejemplo.com">
            </div>
        </div>
        <button type="button" class="button remove-block">Eliminar Bloque</button>
    </div>
</template>

        <?php submit_button(); ?>
    </form>
</div>