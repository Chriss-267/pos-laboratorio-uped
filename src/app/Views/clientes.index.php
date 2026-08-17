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
    </tr>
    <?php foreach ($cliente as $cliente) ?>
        <tr>
        <td><?= $cliente->id ?></td>
        <td><?= $cliente->nombre ?></td>
        <td><?= $cliente->correo ?></td>
        <td><?= $cliente->contraseña ?></td>
        </tr>

    <?php ?>
    </table> 
</body>
</html>