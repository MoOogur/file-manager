<?php
    require 'vendor/autoload.php';
    
    use FileManager\FileManager;
       
    $fileManager = FileManager::getInstance('/profiles/m/mo/moo/moogur/test-app.zzz.com.ua');
    
    $data = $fileManager->getSortedData('descendingly', 'ascending');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Файловый менеджер</title>
        <link href="public/css/bootstrap.min.css" rel="stylesheet">
        <link href="public/css/fontawesome-all.min.css" rel="stylesheet">
        <link href="public/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1 class="display-4">Файловый менеджер</h1>
               
                <table class="table table-dir table-sm noselect-text">
                    <tr class="sort">
                        <th id="icon"></th>
                        <th id="name" class="sort-active"><i class="fas fa-arrow-up icon-sort"></i>Имя</th>
                        <th id="type">Тип</th>
                        <th id="size">Размер</th>
                        <th id="time">Дата</th>
                    </tr>
                    <?php foreach($data['folders'] as $folder) { ?>
                    <tr class="folder">
                        <td class="icon">
                        <?php if($folder['name'] == '..') { ?>
                            <i class="fas fa-reply icon"></i>
                        <?php } else { ?>
                            <i class="fas fa-folder icon-folder icon"></i>
                        <?php } ?>
                        </td>
                        <td><?= $folder['name']; ?></td>
                        <td></td>
                        <td><Папка></td>
                        <td><?= $folder['time']; ?></td>
                    </tr>
                    <?php } ?> 
                    <?php foreach($data['files'] as $file) { ?>
                    <tr class="file">
                        <td class="icon"><i class="fas fa-file icon-file"></i></td>
                        <td><?= $file['name']; ?></td>
                        <td><?= $file['type']; ?></td>
                        <td><?= $file['size']; ?></td>
                        <td><?= $file['time']; ?></td>
                    </tr>
                    <?php } ?> 
                </table>
       
            </div>
        </div>
        <script src="public/js/jquery-3.3.1.min.js"></script>
        <script src="public/js/bootstrap.min.js"></script>
        <script src="public/js/transition.js"></script>
        <script src="public/js/sort.js"></script>
    </body>
</html>

