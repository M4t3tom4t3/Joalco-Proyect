<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$query = "SELECT ID_usuario, nombre, apellido FROM usuarios";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
} else {
    $usuarios = [];
}
?>

<form id="form_firma" method="POST">
    <label for="usuario_id">Seleccionar Usuario:</label>
    <select name="usuario_id" id="usuario_id" required>
        <option value="">Seleccione un usuario</option>
        <?php foreach ($usuarios as $usuario): ?>
            <option value="<?php echo htmlspecialchars($usuario['ID_usuario']); ?>">
                <?php echo htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellido']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="firma">Firma:</label>
    <canvas id="signature-pad"  width="400" height="200" style="border: 1px solid #000;"></canvas>
    <button type="button" id="clear">Borrar</button>
    <button type="button" id="save">Guardar</button>

    <input type="hidden" name="fk_id" id="fk_id" />
</form>
<script>
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;

    canvas.width = 400;
    canvas.height = 200;
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';

    canvas.addEventListener('mousedown', (e) => {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener('mousemove', (e) => {
        if (isDrawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });

    canvas.addEventListener('mouseup', () => {
        isDrawing = false;
    });

    document.getElementById('clear').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    document.getElementById('save').addEventListener('click', () => {
        if (canvas.toDataURL().length > 0) {
            const signatureData = canvas.toDataURL('image/png');
            const userId = document.getElementById('usuario_id').value;

            if (userId) {
                const formData = new FormData();
                formData.append('firma', signatureData);
                formData.append('fk_id', userId);

                fetch('prba_fg.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error(error));
            } else {
                alert('Por favor, seleccione un usuario.');
            }
        } else {
            alert('Por favor, firme antes de guardar.');
        }
    });
</script>