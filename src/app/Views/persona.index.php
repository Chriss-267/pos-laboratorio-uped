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
    <?php foreach ($personas as $persona) ?>
        <tr>
        <td><?= $persona->id ?></td>
        <td><?= $persona->nombre ?></td>
        <td><?= $persona->correo ?></td>
        <td><?= $persona->contraseña ?></td>
        </tr>

    <?php ?>
    </table> 
</body>
</html>