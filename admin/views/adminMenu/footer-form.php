<div class="wrap">
    <form method="post" action="">
    <div style="margin-bottom: 15px;">
        <label for="mi_desplegable" style="display: block; margin-bottom: 5px; font-weight: bold;">
            Selecciona una opción:
        </label>
        <select name="sedici_gf_layout_simple" id="mi_desplegable" style="padding: 5px; width: 250px;">
            <option value="opcion_1">Opción 1 (Estándar)</option>
            <option value="opcion_2">Opción 2 (Centrado)</option>
            <option value="opcion_3">Opción 3 (Bloques)</option>
        </select>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="mi_color" style="display: block; margin-bottom: 5px; font-weight: bold;">
            Selecciona un color de fondo:
        </label>
        <input type="color" name="sedici_gf_color_picker" id="mi_color" value="#0A1128" style="width: 60px; height: 35px; padding: 0; border: 1px solid #ccc; cursor: pointer;">
    </div>

    <div>
        <input type="submit" name="submit_simple_form" value="Guardar configuración" style="padding: 6px 12px; background-color: #007cba; color: white; border: none; border-radius: 3px; cursor: pointer;">
    </div>
</form>
</div>