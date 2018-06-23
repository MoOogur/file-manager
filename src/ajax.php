<?php

require '../vendor/autoload.php';

use FileManager\FileManager;

if(isset($_POST)){
    if($_POST['action'] == 'transition') {
        session_start();
        
        $fileManager = FileManager::getInstance($_SESSION['current_path'] . '/' .$_POST['dir']);
        
        $result = $fileManager->getSortedData($_POST['field'], $_POST['sortType']);
    } else if($_POST['action'] == 'sort') {
        session_start();
        
        if($_SESSION['current_path']) {
            $fileManager = FileManager::getInstance($_SESSION['current_path']);
        } else {
            $fileManager = FileManager::getInstance('/');
        }
        
        $result = $fileManager->getSortedData($_POST['field'], $_POST['sortType']);
    }
    
    echo json_encode($result);
}

