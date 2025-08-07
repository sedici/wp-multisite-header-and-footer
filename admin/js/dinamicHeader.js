jQuery(document).ready(function($) {
    // 1. Mensaje para saber si el script se cargó correctamente.
    // Objeto para llevar la cuenta de los bloques
    let blockCounters = { 'col-1': 0, 'col-2': 0, 'col-3': 0 };

    /**
     * LÓGICA PARA AÑADIR NUEVOS BLOQUES
     */
    $('.add-block-button').on('click', function() {

        const columnId = $(this).data('column');
        const blockType = $(this).siblings('.block-type-selector').val();
        

        const existingBlock = $('#blocks-' + columnId + ' .block');
        console.log(existingBlock);
        if (existingBlock.length > 0) {
        alert('Ya existe un bloque en esta columna.');
        return;
      }

        const template = $('#template-' + blockType + '-block');
        if (!template.length) {
            console.error('¡ERROR! No se encontró la plantilla: #template-' + blockType + '-block');
            return;
        }
        let templateHtml = template.html();
        
        templateHtml = templateHtml.replace(/COLUMN_ID/g, columnId);
        templateHtml = templateHtml.replace(/BLOCK_INDEX/g, blockCounters[columnId]);

        $('#blocks-' + columnId).append(templateHtml);
        blockCounters[columnId]++;
        
        console.log('Bloque añadido correctamente.');
    });

    /**
     * LÓGICA PARA ELIMINAR BLOQUES
     */
    $('body').on('click', '.remove-block', function() {
        if (confirm("¿Estás seguro de que quieres borrar este bloque?")) {
            $(this).closest('.block').remove();
        }
    });
    
    /**
     * LÓGICA PARA ELIMINAR IMÁGENES YA GUARDADAS
     */
    $('.trashImg').on('click', function(e) {
        e.preventDefault();
        if (confirm("¿Estás seguro de que quieres borrar esta imagen guardada?")) {
            $(this).closest('.form-image-box').remove();
        }
    });

});