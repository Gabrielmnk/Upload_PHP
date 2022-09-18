<?php


$number = "13450";

$number_format = 'R$ ' . number_format($number, 2, ',', '.');


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <?php echo $number ?><br>
    <?php echo $number_format ?>



</body>

</html>