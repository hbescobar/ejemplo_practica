
<!-- ============================= -->
<!-- FORMULARIO DE INICIO DE SESIÓN -->
<!-- ============================= -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="text-center mb-4">Iniciar Sesión</h2>


            <form action="<?php echo getUrl('login', 'login', 'postLogin'); ?>" method="post">

                <!-- ============================= -->
                <!-- CAMPO: Número de Documento -->
                <!-- ============================= -->
                <div class="mb-3">
                    <label for="usu_numero_docu" class="form-label">Número de Documento</label>
                    <input type="text" name="usu_numero_docu" id="usu_numero_docu" class="form-control" required>
                </div>

                <!-- ============================= -->
                <!-- CAMPO: Clave -->
                <!-- ============================= -->
                <div class="mb-3">
                    <label for="usu_clave" class="form-label">Contraseña</label>
                    <input type="password" name="usu_clave" id="usu_clave" class="form-control" required>
                </div>

                <!-- ============================= -->
                <!-- CAMPO: Rol -->
                <!-- ============================= -->
                <div class="mb-3">
                    <label for="rol_id" class="form-label">Seleccionar Rol</label>
                    <select name="rol_id" id="rol_id" class="form-select" required>
                        <option value="">Seleccione una opción</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?php echo $rol['rol_id']; ?>">
                                <?php echo $rol['rol_nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <!-- ============================= -->
                <!-- BOTÓN: Iniciar sesión -->
                <!-- ============================= -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </form>

        </div>
    </div>
</div>