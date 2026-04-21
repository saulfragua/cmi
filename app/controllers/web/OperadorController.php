<?php

/**
 * Controlador encargado de gestionar las funcionalidades del panel del operador.
 *
 * Responsabilidades principales:
 * - Mostrar la vista principal del operador.
 * - Permitir la actualización del perfil.
 * - Gestionar la actualización de la foto del operador.
 * - Consultar novedades del observador.
 * - Permitir el cambio de clave.
 * - Registrar y guardar el usuario de Steam.
 * - Generar el carnet del operador en formato imagen.
 */
class OperadorController
{
    /**
     * Instancia del modelo Operador.
     *
     * @var Operador
     */
    private $model;

    /**
     * Constructor del controlador.
     *
     * Inicializa el modelo principal que será utilizado
     * por los diferentes métodos del controlador.
     */
    public function __construct()
    {
        $this->model = new Operador();
    }

    /**
     * Muestra el panel principal del operador.
     *
     * Flujo:
     * 1. Inicia sesión si no está iniciada.
     * 2. Verifica que exista un usuario autenticado.
     * 3. Valida que el rol sea operador o mando.
     * 4. Obtiene los datos del operador y su historial de actividades.
     * 5. Carga la vista principal del panel.
     *
     * @return void
     */
    public function index()
    {
        // Inicia la sesión solo si aún no existe una activa.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no hay usuario autenticado, redirige al login.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Solo permite acceso a usuarios con rol operador o mando.
        if (!in_array($_SESSION['user']['rol'], ['operador', 'mando'])) {
            header('Location: ' . BASE_URL . '/login?error=permiso');
            exit;
        }

        // Obtiene el ID del usuario autenticado.
        $id = $_SESSION['user']['id'];

        // Consulta la información del operador.
        $operador = $this->model->obtenerPorId($id);

        // Consulta el historial de actividades del operador.
        $historial = $this->model->obtenerHistorialActividades($id); // ya limitado a 5 asistidas

        // Carga la vista principal del panel del operador.
        require ROOT . '/app/views/web/operador/index.php';
    }

    /**
     * Actualiza la información editable del perfil del operador.
     *
     * Flujo:
     * 1. Verifica sesión activa y autenticación.
     * 2. Valida que la petición sea POST.
     * 3. Recoge y limpia los datos enviados desde el formulario.
     * 4. Verifica que los campos obligatorios no estén vacíos.
     * 5. Envía los datos al modelo para actualización.
     * 6. Guarda mensajes de éxito o error en sesión.
     * 7. Redirige nuevamente al panel del operador.
     *
     * @return void
     */
    public function actualizarPerfil()
    {
        // Inicia la sesión si aún no está iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica que exista un usuario autenticado.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Solo permite solicitudes por método POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/operador');
            exit;
        }

        // Obtiene el ID del operador autenticado.
        $id = $_SESSION['user']['id'];

        // Construye el arreglo de datos saneados desde el formulario.
        $datos = [
            'nombre_completo'  => trim($_POST['nombre_completo'] ?? ''),
            'fecha_nacimiento' => trim($_POST['fecha_nacimiento'] ?? ''),
            'telefono'         => trim($_POST['telefono'] ?? ''),
            'pais'             => trim($_POST['pais'] ?? '')
        ];

        // Valida que todos los campos editables requeridos estén completos.
        if (
            empty($datos['nombre_completo']) ||
            empty($datos['fecha_nacimiento']) ||
            empty($datos['telefono']) ||
            empty($datos['pais'])
        ) {
            $_SESSION['error_operador'] = 'Todos los campos editables son obligatorios.';
            header('Location: ' . BASE_URL . '/operador');
            exit;
        }

        // Ejecuta la actualización en base de datos a través del modelo.
        $ok = $this->model->actualizarPerfilOperador($id, $datos);

        // Si la actualización fue exitosa, actualiza también los datos de sesión.
        if ($ok) {
            $_SESSION['user']['nombre_completo'] = $datos['nombre_completo'];
            $_SESSION['success_operador'] = 'Perfil actualizado correctamente.';
        } else {
            // Si falló, guarda mensaje de error.
            $_SESSION['error_operador'] = 'No se pudo actualizar el perfil.';
        }

        // Redirige de vuelta al panel del operador.
        header('Location: ' . BASE_URL . '/operador');
        exit;
    }

    /**
     * Actualiza la foto del operador.
     *
     * Flujo:
     * 1. Verifica sesión iniciada y autenticación.
     * 2. Comprueba si se recibió un archivo en el campo 'foto'.
     * 3. Crea el directorio destino si no existe.
     * 4. Genera un nombre único para la imagen.
     * 5. Mueve el archivo subido al destino final.
     * 6. Actualiza el nombre de la foto en base de datos y en sesión.
     * 7. Redirige al panel del operador.
     *
     * @return void
     */
    public function actualizarFoto()
    {
        // Inicia la sesión si es necesario.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no hay usuario autenticado, redirige al login.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Verifica que el formulario haya enviado un archivo con nombre válido.
        if (!empty($_FILES['foto']['name'])) {
            // Ruta física donde se almacenarán las fotos de operadores.
            $directorio = ROOT . '/public/assets/img/operadores/';

            // Crea el directorio si no existe.
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            // Genera un nombre de archivo único usando timestamp.
            $nombreArchivo = time() . '_' . preg_replace('/\s+/', '_', $_FILES['foto']['name']);
            $rutaDestino = $directorio . $nombreArchivo;

            // Mueve el archivo temporal al directorio definitivo.
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                // Actualiza el nombre de la foto en base de datos.
                $this->model->actualizarFoto($_SESSION['user']['id'], $nombreArchivo);

                // Sincroniza la información de sesión con la nueva foto.
                $_SESSION['user']['foto_operador'] = $nombreArchivo;
            }
        }

        // Redirige al panel del operador.
        header('Location: ' . BASE_URL . '/operador');
        exit;
    }

    /**
     * Muestra la vista del observador con las novedades del operador.
     *
     * Flujo:
     * 1. Valida sesión activa y autenticación.
     * 2. Verifica que el rol sea operador o mando.
     * 3. Obtiene los datos generales del operador.
     * 4. Consulta las novedades asociadas al operador.
     * 5. Carga la vista correspondiente.
     *
     * @return void
     */
    public function misObservador()
    {
        // Inicia la sesión si aún no existe.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no existe usuario autenticado, redirige al login.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Solo permite acceso a roles operador o mando.
        if (!in_array($_SESSION['user']['rol'], ['operador', 'mando'])) {
            header('Location: ' . BASE_URL . '/login?error=permiso');
            exit;
        }

        // Obtiene el ID del usuario autenticado.
        $id = $_SESSION['user']['id'];

        // Consulta la información del operador.
        $operador = $this->model->obtenerPorId($id);

        // Consulta las novedades registradas para el operador.
        $novedades = $this->model->obtenerNovedadesPorOperador($id);

        // Carga la vista del observador.
        require ROOT . '/app/views/web/operador/mis_observador.php';
    }

    /**
     * Permite cambiar la clave del operador autenticado.
     *
     * Flujo:
     * 1. Verifica sesión activa y autenticación.
     * 2. Obtiene la nueva clave y su confirmación.
     * 3. Valida que ambas coincidan.
     * 4. Genera el hash seguro de la nueva clave.
     * 5. Actualiza la clave en base de datos.
     * 6. Redirige al panel con mensaje de éxito o error.
     *
     * @return void
     */
    public function cambiarClave()
    {
        // Inicia la sesión si aún no está activa.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica que exista un usuario autenticado.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Obtiene el ID del operador autenticado.
        $operadorId = $_SESSION['user']['id'];

        // Obtiene las claves enviadas desde el formulario.
        $nueva = $_POST['nueva_clave'] ?? '';
        $confirmar = $_POST['confirmar_clave'] ?? '';

        // Si las claves no coinciden, redirige con error.
        if ($nueva !== $confirmar) {
            header('Location: ' . BASE_URL . '/operador?error=clave_no_coincide');
            exit;
        }

        // Genera un hash seguro de la nueva clave.
        $claveHash = password_hash($nueva, PASSWORD_BCRYPT);

        // Actualiza la clave en la base de datos.
        $this->model->actualizarClave($operadorId, $claveHash);

        // Redirige indicando éxito en la operación.
        header('Location: ' . BASE_URL . '/operador?success=clave_actualizada');
        exit;
    }

    /**
     * Muestra la vista para registrar el usuario de Steam.
     *
     * Flujo:
     * 1. Valida sesión activa y autenticación.
     * 2. Carga el modelo de autenticación.
     * 3. Obtiene la información actual del usuario.
     * 4. Si ya tiene Steam registrado, redirige al panel.
     * 5. Si no tiene Steam registrado, carga la vista de registro.
     *
     * @return void
     */
    public function registrarSteam()
    {
        // Inicia la sesión si aún no existe.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no hay usuario autenticado, redirige al login.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Carga el modelo de autenticación.
        require_once ROOT . '/app/models/AuthModel.php';
        $modelo = new AuthModel();

        // Obtiene el ID del usuario autenticado.
        $id = $_SESSION['user']['id'];

        // Consulta la información del usuario.
        $usuario = $modelo->obtenerPorId($id);

        // Si ya tiene Steam registrado, no permite volver a registrar.
        if (!empty(trim($usuario['steam'] ?? ''))) {
            header('Location: ' . BASE_URL . '/operador');
            exit;
        }

        // Carga la vista para registrar la cuenta de Steam.
        require ROOT . '/app/views/web/operador/registrar_steam.php';
    }

    /**
     * Guarda el usuario de Steam del operador autenticado.
     *
     * Flujo:
     * 1. Verifica sesión activa y autenticación.
     * 2. Obtiene el dato Steam enviado por formulario.
     * 3. Valida que exista ID de usuario y valor Steam.
     * 4. Carga el modelo AuthModel.
     * 5. Guarda el Steam en base de datos.
     * 6. Actualiza la sesión si el guardado fue exitoso.
     * 7. Redirige según el resultado.
     *
     * @return void
     */
    public function guardarSteam()
    {
        // Inicia la sesión si aún no existe.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no hay usuario autenticado, redirige al login.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Obtiene el valor Steam enviado desde el formulario.
        $steam = trim($_POST['steam'] ?? '');

        // Obtiene el ID del usuario autenticado.
        $id = $_SESSION['user']['id'] ?? null;

        // Valida que existan tanto el ID como el valor de Steam.
        if (empty($id) || empty($steam)) {
            header('Location: ' . BASE_URL . '/operador/registrar-steam?error=vacío');
            exit;
        }

        // Carga el modelo de autenticación.
        require_once ROOT . '/app/models/AuthModel.php';
        $modelo = new AuthModel();

        // Guarda el usuario de Steam en la base de datos.
        $guardado = $modelo->actualizarSteam($id, $steam);

        // Si se guardó correctamente, actualiza también la sesión.
        if ($guardado) {
            $_SESSION['user']['steam'] = $steam;
            header('Location: ' . BASE_URL . '/operador');
            exit;
        }

        // Si falla el guardado, redirige con parámetro de error.
        header('Location: ' . BASE_URL . '/operador/registrar-steam?error=guardar');
        exit;
    }

    /**
     * Genera y entrega en tiempo real el carnet del operador en formato PNG.
     *
     * Este método:
     * - Valida sesión y usuario autenticado.
     * - Consulta la información del operador para el carnet.
     * - Verifica disponibilidad de la extensión GD.
     * - Construye una imagen personalizada con:
     *   logo, foto, datos del operador, código de barras y estado.
     * - Envía la imagen directamente al navegador.
     *
     * @return void
     */
    public function carnet()
    {
        // Inicia la sesión si aún no existe.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no hay sesión de usuario, redirige al login.
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Carga explícitamente el modelo Operador.
        require_once ROOT . '/app/models/Operador.php';
        $operadorModel = new Operador();

        // Obtiene y fuerza a entero el ID del operador autenticado.
        $operadorId = (int) ($_SESSION['user']['id'] ?? 0);

        // Si el ID no es válido, redirige al login.
        if ($operadorId <= 0) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Obtiene los datos necesarios para construir el carnet.
        $operador = $operadorModel->obtenerPorIdCarnet($operadorId);

        // Si no se encuentra información del operador, redirige al panel.
        if (!$operador) {
            header('Location: ' . BASE_URL . '/operador');
            exit;
        }

        // Verifica que la extensión GD esté habilitada en PHP.
        if (!extension_loaded('gd')) {
            die('La extensión GD no está habilitada en PHP.');
        }

        // Define el tamaño del lienzo del carnet.
        $ancho = 2048;
        $alto  = 1365;

        // Crea la imagen base en memoria.
        $imagen = imagecreatetruecolor($ancho, $alto);
        imagealphablending($imagen, true);
        imagesavealpha($imagen, true);

        // Define la paleta de colores utilizada en el diseño.
        $negro       = imagecolorallocate($imagen, 5, 5, 5);
        $negroSuave  = imagecolorallocate($imagen, 10, 10, 10);
        $grisOscuro  = imagecolorallocate($imagen, 18, 18, 18);
        $dorado      = imagecolorallocate($imagen, 200, 152, 46);
        $doradoClaro = imagecolorallocate($imagen, 230, 190, 70);
        $blanco      = imagecolorallocate($imagen, 245, 245, 245);
        $verde       = imagecolorallocate($imagen, 40, 240, 120);
        $rojo        = imagecolorallocate($imagen, 230, 70, 70);

        // Aplica fondo negro al lienzo completo.
        imagefill($imagen, 0, 0, $negro);

        // Resuelve la ruta de la fuente en negrita.
        $fontBold = $this->resolverRutaFuente([
            ROOT . '/public/assets/fonts/Oswald-Bold.ttf',
            ROOT . '/public/assets/fonts/Oswald-Bold.ttf',
        ]);

        // Resuelve la ruta de la fuente regular.
        $fontReg = $this->resolverRutaFuente([
            ROOT . '/public/assets/fonts/Oswald-Regular.ttf',
            ROOT . '/public/assets/fonts/Oswald-Regular.ttf',
        ]);

        $fontEstrella = ROOT . '/public/assets/fonts/DejaVuSans.ttf';

        // Verifica si se pueden usar fuentes TTF y la función de renderizado.
        $usarTTF = $fontBold && $fontReg && function_exists('imagettftext');

        // Prepara y normaliza los textos principales del operador.
        $nombre = strtoupper(trim($operador['nombre_completo'] ?? 'OPERADOR'));
        $codigo = strtoupper(trim($operador['codigo'] ?? 'CMI-OP-0000'));
        $rango  = strtoupper(trim($operador['rango_nombre'] ?? ($operador['rango'] ?? 'SIN RANGO')));
        $estado = strtoupper(trim($operador['estado'] ?? 'ACTIVO'));

        // Determina la especialidad principal o valor por defecto.
        $especialidad = 'SIN ESPECIALIDAD';
        if (!empty($operador['especialidad_principal'])) {
            $especialidad = strtoupper($operador['especialidad_principal']);
        } elseif (!empty($operador['especialidad_nombre'])) {
            $especialidad = strtoupper($operador['especialidad_nombre']);
        }

        // Determina la unidad o valor por defecto.
        $unidad = 'SIN UNIDAD';
        if (!empty($operador['unidad_nombre'])) {
            $unidad = strtoupper($operador['unidad_nombre']);
        } elseif (!empty($operador['unidad'])) {
            $unidad = strtoupper($operador['unidad']);
        }

        // Calcula la edad del operador a partir de la fecha de nacimiento.
        $edad = 'N/A';
        if (!empty($operador['fecha_nacimiento'])) {
            try {
                $fn = new DateTime($operador['fecha_nacimiento']);
                $hoy = new DateTime();
                $edad = $fn->diff($hoy)->y . ' AÑOS';
            } catch (Exception $e) {
                // Si ocurre un error con la fecha, asigna valor por defecto.
                $edad = 'N/A';
            }
        }

        // Dibuja el fondo principal redondeado del carnet.
        $this->roundedRect($imagen, 18, 18, $ancho - 18, $alto - 18, 42, $negroSuave, true);

        // Dibuja el borde exterior dorado.
        imagesetthickness($imagen, 20);
        $this->roundedRect($imagen, 18, 18, $ancho - 18, $alto - 18, 42, $dorado, false);

        // Dibuja un segundo borde interior más claro.
        imagesetthickness($imagen, 1);
        $this->roundedRect($imagen, 38, 38, $ancho - 38, $alto - 38, 30, $negro, false);

        // Dibuja la franja inferior del diseño.
        imagefilledrectangle($imagen, 0, $alto - 130, $ancho, $alto, $dorado);

        // Inicializa la ruta del logo.
        $rutaLogo = null;

        // Posibles rutas donde puede existir el archivo del escudo/logo.
        $rutasLogo = [
            ROOT . '/public/assets/img/logos/CMI.png',
            ROOT . '/assets/img/logos/CMI.png',
            ROOT . '/public/assets/img/logos/CMI.png',
            ROOT . '/assets/img/logos/CMI.png',
        ];

        // Recorre las rutas y selecciona la primera existente.
        foreach ($rutasLogo as $rutaTmp) {
            if (file_exists($rutaTmp)) {
                $rutaLogo = $rutaTmp;
                break;
            }
        }

        // Si se encontró logo, se carga y dibuja en la imagen.
        if ($rutaLogo) {
            $logo = $this->cargarImagenGD($rutaLogo);
            if ($logo) {
                imagecopyresampled(
                    $imagen,
                    $logo,
                    70,
                    70,
                    0,
                    0,
                    460,
                    460,
                    imagesx($logo),
                    imagesy($logo)
                );
                imagedestroy($logo);
            }
        }

        // Dibuja encabezado principal usando fuentes TTF si están disponibles.
        if ($usarTTF) {
            imagettftext($imagen, 68, 0, 610, 170, $blanco, $fontBold, 'COMANDO MILITAR');
            imagettftext($imagen, 68, 0, 670, 275, $blanco, $fontBold, 'INTERNACIONAL');

            imageline($imagen, 560, 345, 900, 345, $dorado);
            imageline($imagen, 1035, 345, 1380, 345, $dorado);

            imagettftext($imagen, 70, 0, 928, 372, $dorado, $fontEstrella, '★');
            imagettftext($imagen, 48, 0, 560, 435, $dorado, $fontBold, 'CARNET OFICIAL DE OPERADOR');
        } else {
            // Fallback si no hay soporte TTF.
            imagestring($imagen, 5, 560, 120, 'COMANDO MILITAR', $blanco);
            imagestring($imagen, 5, 560, 170, 'INTERNACIONAL', $blanco);
            imagestring($imagen, 5, 560, 220, 'CARNET OFICIAL DE OPERADOR', $dorado);
        }

        // Define la posición y tamaño del marco de la fotografía.
        $fotoX = 1450;
        $fotoY = 92;
        $fotoW = 510;
        $fotoH = 635;

        // Dibuja el borde del contenedor de la foto.
        $this->roundedRect($imagen, $fotoX, $fotoY, $fotoX + $fotoW, $fotoY + $fotoH, 22, $dorado, false);

        // Si el operador tiene foto registrada, intenta cargarla.
        if (!empty($operador['foto_operador'])) {
            $rutasFoto = [
                ROOT . '/public/assets/img/operadores/' . $operador['foto_operador'],
                ROOT . '/assets/img/operadores/' . $operador['foto_operador'],
            ];

            $rutaFoto = null;
            foreach ($rutasFoto as $rf) {
                if (file_exists($rf)) {
                    $rutaFoto = $rf;
                    break;
                }
            }

            // Si encuentra la ruta válida, procesa la imagen.
            if ($rutaFoto) {
                $foto = $this->cargarImagenGD($rutaFoto);

                if ($foto) {
                    // Define margen interno del área de foto.
                    $margen = 8;
                    $tmpW = $fotoW - ($margen * 2);
                    $tmpH = $fotoH - ($margen * 2);

                    // Crea un lienzo temporal para adaptar la foto.
                    $tmp = imagecreatetruecolor($tmpW, $tmpH);
                    imagefill($tmp, 0, 0, $negro);

                    // Obtiene dimensiones originales de la foto.
                    $origW = imagesx($foto);
                    $origH = imagesy($foto);

                    // Calcula proporciones para recorte centrado.
                    $ratioDestino = $tmpW / $tmpH;
                    $ratioOrigen  = $origW / $origH;

                    if ($ratioOrigen > $ratioDestino) {
                        $cropH = $origH;
                        $cropW = (int) round($origH * $ratioDestino);
                        $srcX = (int) round(($origW - $cropW) / 2);
                        $srcY = 0;
                    } else {
                        $cropW = $origW;
                        $cropH = (int) round($origW / $ratioDestino);
                        $srcX = 0;
                        $srcY = (int) round(($origH - $cropH) / 2);
                    }

                    // Copia y redimensiona la foto recortada al contenedor temporal.
                    imagecopyresampled(
                        $tmp,
                        $foto,
                        0,
                        0,
                        $srcX,
                        $srcY,
                        $tmpW,
                        $tmpH,
                        $cropW,
                        $cropH
                    );

                    // Inserta la imagen temporal dentro del carnet.
                    imagecopy($imagen, $tmp, $fotoX + $margen, $fotoY + $margen, 0, 0, $tmpW, $tmpH);

                    // Libera memoria de las imágenes temporales.
                    imagedestroy($tmp);
                    imagedestroy($foto);
                }
            } else {
                // Si no se encuentra la foto física, dibuja un fondo de reemplazo.
                imagefilledrectangle($imagen, $fotoX + 8, $fotoY + 8, $fotoX + $fotoW - 8, $fotoY + $fotoH - 8, $grisOscuro);
            }
        } else {
            // Si no hay foto registrada, dibuja un fondo de reemplazo.
            imagefilledrectangle($imagen, $fotoX + 8, $fotoY + 8, $fotoX + $fotoW - 8, $fotoY + $fotoH - 8, $grisOscuro);
        }

        // Define los campos a pintar en el cuerpo del carnet.
        $campos = [
            ['NOMBRE:', $nombre, 'nombre'],
            ['CÓDIGO:', $codigo, 'codigo'],
            ['RANGO:', $rango, 'rango'],
            ['ESPECIALIDAD PRINCIPAL:', $especialidad, 'especialidad'],
            ['UNIDAD:', $unidad, 'unidad'],
            ['EDAD:', $edad, 'edad'],
        ];

        // Coordenada inicial vertical y separación entre filas.
        $y = 590;
        $altoFila = 112;

        // Recorre y dibuja cada uno de los campos informativos.
        foreach ($campos as $fila) {
            [$label, $valor, $tipoIcono] = $fila;

            // Define el contenedor del ícono asociado al campo.
            $iconX1 = 95;
            $iconY1 = $y - 58;
            $iconX2 = 205;
            $iconY2 = $y + 48;

            // Dibuja caja del ícono.
            $this->roundedRect($imagen, $iconX1, $iconY1, $iconX2, $iconY2, 14, $dorado, false);

            // Dibuja el ícono según el tipo de campo.
            $this->dibujarIconoCampo($imagen, $tipoIcono, $iconX1, $iconY1, $iconX2, $iconY2, $dorado);

            // Dibuja línea separadora horizontal.
            imageline($imagen, 210, $y + 58, 1380, $y + 58, $dorado);

            // Dibuja etiquetas y valores usando TTF si está disponible.
            if ($usarTTF) {
                if ($label === 'ESPECIALIDAD PRINCIPAL:') {
                    imagettftext($imagen, 28, 0, 240, $y - 12, $dorado, $fontBold, 'ESPECIALIDAD');
                    imagettftext($imagen, 28, 0, 240, $y + 24, $dorado, $fontBold, 'PRINCIPAL:');
                    $tamValor = 38;
                } else {
                    imagettftext($imagen, 36, 0, 240, $y + 10, $dorado, $fontBold, $label);
                    $tamValor = 40;
                }

                // Define ancho máximo del texto según el campo.
                $anchoMax = ($label === 'NOMBRE:') ? 770 : 740;

                // Limita el texto para que no se desborde visualmente.
                $valorMostrado = $this->limitarTextoTTF($valor, $fontBold, $tamValor, $anchoMax);

                // Dibuja el valor del campo.
                imagettftext($imagen, $tamValor, 0, 650, $y + 10, $blanco, $fontBold, $valorMostrado);
            } else {
                // Fallback para texto sin TTF.
                imagestring($imagen, 5, 240, $y - 15, $label, $dorado);
                imagestring($imagen, 5, 650, $y - 15, $valor, $blanco);
            }

            // Baja a la siguiente fila.
            $y += $altoFila;
        }

        



    // =============================
// BLOQUE QR EN VEZ DE BARRAS
// =============================

// Define posición y tamaño del bloque QR
$qrX = 1485;
$qrY = 755;
$qrSize = 450;

// Fondo del área QR
imagefilledrectangle($imagen, $qrX, $qrY, $qrX + $qrSize, $qrY + $qrSize, $blanco);

// Texto que llevará el QR
$contenidoQR = $codigo;

// Carga la librería QR
require_once ROOT . '/app/libs/phpqrcode/qrlib.php';

// Carpeta temporal para guardar el QR generado
$directorioTemp = ROOT . '/public/temp_qr/';
if (!is_dir($directorioTemp)) {
    mkdir($directorioTemp, 0777, true);
}

// Nombre temporal del archivo QR
$archivoQR = $directorioTemp . 'qr_' . md5($contenidoQR) . '.png';

// Genera el QR si no existe
if (!file_exists($archivoQR)) {
    QRcode::png($contenidoQR, $archivoQR, QR_ECLEVEL_H, 10, 2);
}

// Carga el QR generado
$qrImg = imagecreatefrompng($archivoQR);

if ($qrImg) {
    imagecopyresampled(
        $imagen,
        $qrImg,
        $qrX,
        $qrY,
        0,
        0,
        $qrSize,
        $qrSize,
        imagesx($qrImg),
        imagesy($qrImg)
    );
    imagedestroy($qrImg);
}






        //ACA FINALIZA EL QR

        // Dibuja polígono decorativo inferior central.
        imagefilledpolygon($imagen, [
            910, 1185,
            1240, 1185,
            1195, 1364,
            955, 1364
        ], 4, $negro);

        // Dibuja textos finales decorativos e informativos.
        if ($usarTTF) {
            imagettftext($imagen, 50, 0, 60, 1310, $negro, $fontEstrella, '★');
            imagettftext($imagen, 35, 0, 165, 1310, $negro, $fontBold, 'DISCIPLINA - HONOR - LEALTAD');
            imagettftext($imagen, 50, 0, 815, 1310, $negro, $fontEstrella, '★');

            imagettftext($imagen, 58, 0, 955, 1299, $dorado, $fontBold, 'ARMA 3');
            imagettftext($imagen, 20, 0, 957, 1340, $dorado, $fontBold, 'SIMULACIÓN MILITAR');

            imagettftext($imagen, 30, 0, 1370, 1300, $negro, $fontBold, 'ESTE DOCUMENTO ES PERSONAL');
            imagettftext($imagen, 30, 0, 1475, 1342, $negro, $fontBold, 'E INTRANSFERIBLE');
            imagettftext($imagen, 50, 0, 1945, 1310, $negro, $fontEstrella, '★');
        } else {
            imagestring($imagen, 5, 90, 1290, 'DISCIPLINA - HONOR - LEALTAD', $negro);
            imagestring($imagen, 5, 980, 1290, 'ARMA 3 - SIMULACION MILITAR', $dorado);
            imagestring($imagen, 4, 1420, 1290, 'DOCUMENTO PERSONAL E INTRANSFERIBLE', $negro);
        }

        // Construye un nombre de archivo seguro para la descarga/visualización.
        $nombreDescarga = 'carnet_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $codigo) . '.png';

        // Limpia cualquier buffer activo antes de enviar la imagen.
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Envía encabezados HTTP para mostrar la imagen PNG en navegador.
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $nombreDescarga . '"');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Imprime la imagen generada y libera memoria.
        imagepng($imagen);
        imagedestroy($imagen);
        exit;
    }

    /**
     * Busca y retorna la primera ruta de fuente válida encontrada.
     *
     * @param array $rutas Lista de posibles rutas de archivo.
     * @return string|null Retorna la ruta válida o null si no encuentra ninguna.
     */
    private function resolverRutaFuente(array $rutas)
    {
        // Recorre cada ruta en busca de una fuente existente.
        foreach ($rutas as $ruta) {
            if (file_exists($ruta)) {
                return $ruta;
            }
        }

        // Si ninguna existe, retorna null.
        return null;
    }

    /**
     * Carga una imagen usando GD según su extensión.
     *
     * Soporta:
     * - JPG / JPEG
     * - PNG
     * - WEBP (si la función está disponible)
     *
     * @param string $ruta Ruta física de la imagen.
     * @return resource|null Recurso de imagen GD o null si no puede cargarse.
     */
    private function cargarImagenGD($ruta)
    {
        // Si el archivo no existe físicamente, retorna null.
        if (!file_exists($ruta)) {
            return null;
        }

        // Obtiene la extensión del archivo en minúsculas.
        $extension = strtolower(pathinfo($ruta, PATHINFO_EXTENSION));

        // Carga la imagen según el tipo detectado.
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                return @imagecreatefromjpeg($ruta);

            case 'png':
                return @imagecreatefrompng($ruta);

            case 'webp':
                return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($ruta) : null;

            default:
                return null;
        }
    }

    /**
     * Dibuja un rectángulo con bordes redondeados.
     *
     * Puede dibujarlo relleno o solo contorneado.
     *
     * @param resource $img   Recurso GD.
     * @param int      $x1    Coordenada X inicial.
     * @param int      $y1    Coordenada Y inicial.
     * @param int      $x2    Coordenada X final.
     * @param int      $y2    Coordenada Y final.
     * @param int      $radio Radio de redondeo.
     * @param int      $color Color GD.
     * @param bool     $fill  Indica si debe ir relleno o solo borde.
     * @return void
     */
    private function roundedRect($img, $x1, $y1, $x2, $y2, $radio, $color, $fill = true)
    {
        // Dibuja el rectángulo relleno con esquinas redondeadas.
        if ($fill) {
            imagefilledrectangle($img, $x1 + $radio, $y1, $x2 - $radio, $y2, $color);
            imagefilledrectangle($img, $x1, $y1 + $radio, $x2, $y2 - $radio, $color);

            imagefilledellipse($img, $x1 + $radio, $y1 + $radio, $radio * 2, $radio * 2, $color);
            imagefilledellipse($img, $x2 - $radio, $y1 + $radio, $radio * 2, $radio * 2, $color);
            imagefilledellipse($img, $x1 + $radio, $y2 - $radio, $radio * 2, $radio * 2, $color);
            imagefilledellipse($img, $x2 - $radio, $y2 - $radio, $radio * 2, $radio * 2, $color);
        } else {
            // Dibuja únicamente el contorno redondeado.
            imageline($img, $x1 + $radio, $y1, $x2 - $radio, $y1, $color);
            imageline($img, $x1 + $radio, $y2, $x2 - $radio, $y2, $color);
            imageline($img, $x1, $y1 + $radio, $x1, $y2 - $radio, $color);
            imageline($img, $x2, $y1 + $radio, $x2, $y2 - $radio, $color);

            imagearc($img, $x1 + $radio, $y1 + $radio, $radio * 2, $radio * 2, 180, 270, $color);
            imagearc($img, $x2 - $radio, $y1 + $radio, $radio * 2, $radio * 2, 270, 360, $color);
            imagearc($img, $x1 + $radio, $y2 - $radio, $radio * 2, $radio * 2, 90, 180, $color);
            imagearc($img, $x2 - $radio, $y2 - $radio, $radio * 2, $radio * 2, 0, 90, $color);
        }
    }

    /**
     * Limita un texto para que no exceda un ancho máximo usando una fuente TTF.
     *
     * Si el texto supera el ancho permitido, se recorta progresivamente
     * y se agrega "..." al final.
     *
     * @param string $texto     Texto a limitar.
     * @param string $fontFile  Ruta del archivo de fuente.
     * @param int    $size      Tamaño de fuente.
     * @param int    $maxWidth  Ancho máximo permitido.
     * @return string Texto ajustado al ancho máximo.
     */
    private function limitarTextoTTF($texto, $fontFile, $size, $maxWidth)
    {
        // Normaliza el valor recibido como cadena y elimina espacios externos.
        $texto = trim((string) $texto);

        // Si no hay texto o no existe la fuente, retorna el texto sin procesar.
        if ($texto === '' || !file_exists($fontFile)) {
            return $texto;
        }

        // Reduce el texto hasta que entre dentro del ancho permitido.
        while (mb_strlen($texto) > 0) {
            $box = imagettfbbox($size, 0, $fontFile, $texto);
            $width = abs($box[2] - $box[0]);

            if ($width <= $maxWidth) {
                return $texto;
            }

            $texto = rtrim(mb_substr($texto, 0, mb_strlen($texto) - 1));
            if ($texto !== '') {
                $texto .= '...';
            }
        }

        // Si no quedó contenido visible, retorna cadena vacía.
        return '';
    }

    /**
     * Dibuja un ícono representativo para cada tipo de campo del carnet.
     *
     * Tipos soportados:
     * - nombre
     * - codigo
     * - rango
     * - especialidad
     * - unidad
     * - edad
     *
     * @param resource $img   Recurso GD.
     * @param string   $tipo  Tipo de ícono a dibujar.
     * @param int      $x1    Coordenada X inicial del contenedor.
     * @param int      $y1    Coordenada Y inicial del contenedor.
     * @param int      $x2    Coordenada X final del contenedor.
     * @param int      $y2    Coordenada Y final del contenedor.
     * @param int      $color Color GD.
     * @return void
     */
    private function dibujarIconoCampo($img, $tipo, $x1, $y1, $x2, $y2, $color)
    {
        // Calcula el centro del área donde se dibujará el ícono.
        $cx = (int) (($x1 + $x2) / 2);
        $cy = (int) (($y1 + $y2) / 2);

        // Dibuja cada ícono según el tipo solicitado.
        switch ($tipo) {
            case 'nombre':
                imageellipse($img, $cx - 10, $cy - 12, 18, 18, $color);
                imagerectangle($img, $cx - 28, $cy + 2, $cx + 8, $cy + 28, $color);
                imageline($img, $cx + 16, $cy - 18, $cx + 30, $cy - 18, $color);
                imageline($img, $cx + 16, $cy - 8, $cx + 30, $cy - 8, $color);
                imageline($img, $cx + 16, $cy + 2, $cx + 30, $cy + 2, $color);
                break;

            case 'codigo':
                imagepolygon($img, [
                    $cx, $y1 + 18,
                    $x2 - 20, $cy - 5,
                    $x2 - 30, $y2 - 18,
                    $x1 + 30, $y2 - 18,
                    $x1 + 20, $cy - 5
                ], 5, $color);
                break;

            case 'rango':
                imageline($img, $cx - 22, $cy + 18, $cx, $cy + 2, $color);
                imageline($img, $cx, $cy + 2, $cx + 22, $cy + 18, $color);
                imageline($img, $cx - 22, $cy - 4, $cx, $cy - 20, $color);
                imageline($img, $cx, $cy - 20, $cx + 22, $cy - 4, $color);
                imageline($img, $cx - 12, $cy - 28, $cx, $cy - 36, $color);
                imageline($img, $cx, $cy - 36, $cx + 12, $cy - 28, $color);
                break;

            case 'especialidad':
                imageellipse($img, $cx, $cy, 46, 46, $color);
                imageellipse($img, $cx, $cy, 22, 22, $color);
                imageline($img, $cx - 30, $cy, $cx + 30, $cy, $color);
                imageline($img, $cx, $cy - 30, $cx, $cy + 30, $color);
                break;

            case 'unidad':
                imageellipse($img, $cx, $cy - 16, 16, 16, $color);
                imageellipse($img, $cx - 20, $cy - 4, 14, 14, $color);
                imageellipse($img, $cx + 20, $cy - 4, 14, 14, $color);
                imagerectangle($img, $cx - 10, $cy - 2, $cx + 10, $cy + 20, $color);
                imagerectangle($img, $cx - 30, $cy + 4, $cx - 12, $cy + 24, $color);
                imagerectangle($img, $cx + 12, $cy + 4, $cx + 30, $cy + 24, $color);
                break;

            case 'edad':
                imagerectangle($img, $cx - 24, $cy - 24, $cx + 24, $cy + 20, $color);
                imageline($img, $cx - 14, $cy - 32, $cx - 14, $cy - 20, $color);
                imageline($img, $cx + 14, $cy - 32, $cx + 14, $cy - 20, $color);
                imageline($img, $cx - 24, $cy - 8, $cx + 24, $cy - 8, $color);
                imageline($img, $cx - 10, $cy + 2, $cx - 10, $cy + 10, $color);
                imageline($img, $cx, $cy + 2, $cx, $cy + 10, $color);
                imageline($img, $cx + 10, $cy + 2, $cx + 10, $cy + 10, $color);
                break;
        }
    }
}