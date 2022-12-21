<h1>Header</h1>

<p class="comments-about-section">En esta sección usted podrá editar partes del header global que desea mostrar
    a lo largo de todo su multisitio.</p>

<hr>
   
<!-- Falta agregar atributos name a los elementos del formulario -->
<form method="POST" >
    <?php settings_fields( 'header_settings' ); ?>
    <?php do_settings_sections( 'header_settings' ); ?>
    
<div>
    
    <!-- Podria agregarse algun placeholder -->
    <div class="general-form-field">
        <h2 class="filds-titles"> Texto </h2>
        <input type="text" name="title-text" value="<?php echo esc_attr( get_option('title_text') ); ?>" >
    </div>

    <hr>

    <div class="general-form-field">
        <h2 class="filds-titles"> Enlace del texto </h2>
        <input name="title-link" type="text" value="<?php echo esc_attr( get_option('title_link') ); ?>" >
    </div>

    <hr>
<!--
    <div class="general-form-field">
        <h2 class="filds-titles"> Imagen </h2>
        <input type="file">
    </div>

    <hr>

    <div class="general-form-field">
        <h2 class="filds-titles"> Enlace de la imagen </h2>
        <input type="text">
    </div>
-->
    <hr>
    <?php submit_button("Guardar cambios") ?>
    <!-- <div class="general-form-field">
        <button id="save-changes-button" type="button">Guardar cambios</button>
    </div> --> 
     

</div>
</form>


<hr>

