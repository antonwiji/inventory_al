<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perbulan</title>
</head>
<body>
    <?php 
    
    foreach($query->result_array() as $row) { ?>

        <h2><?= $row['name']; ?></h2>
        <h2><?= $row['date']; ?></h2>
        

    <?php } ?>
</body>
</html>