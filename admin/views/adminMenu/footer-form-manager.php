<div class="wrap">
    <h1>Estado del Footer Global</h1>
    
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">Visibilidad</th>
                    <td>
                        <label for="footer_status">
                            <input name="input_sedici_footer_status" type="checkbox" id="footer_status" value="1" <?php checked($footer_status, 1); ?>>
                            <input type="hidden" name="action" value="sedici_footer_save_status">
                            Habilitar el Footer Global en este sitio
                        </label>
                        <p class="description">Al activar esta opción, todos los sitios del multisitio heredarán el diseño global del footer establecido por la red.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <p class="submit">
            <input type="submit" name="submit_status" id="submit_status" class="button button-primary" value="Guardar estado">
        </p>
    </form>
</div>