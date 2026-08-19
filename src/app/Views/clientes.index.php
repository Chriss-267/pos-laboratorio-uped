<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<table style="background-color: green;">
    <tr style="background-color: black; color:white">
    <th>ID</th>
    <th>Nombre</th>
    <th>Correo</th>
    <th>Contraseña</th>
    <th>Acciones</th>
    </tr>

    <?php foreach ($cliente as $item) { ?>
        <tr>
        <td><?= $item->id ?></td>
        <td><?= $item->nombre ?></td>
        <td><?= $item->correo ?></td>
        <td><?= $item->contraseña ?></td>
        <td>
            <a href="index.php?accion=eliminar&id=<?= $item->id ?>"
               onclick="return confirm('¿Está seguro de eliminar este cliente?');">
                Eliminar
            </a>
        </td>
        </tr>
    <?php } ?>

    </table> 
</body>
</html>