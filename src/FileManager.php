<?php

namespace FileManager;

use DirectoryIterator;

/**
 * Class FileManager is used for viewing folders and files in directory.
 */
class FileManager
{
    /**
     * @var Singleton
     */
    protected static $instance;
    
    /**
     * DirectoryIterator.
     * @var DirectoryIterator
     */
    protected $iterator;

    /**
     * Costructor.
     */
    private function __construct($dir) 
    {
        $this->iterator = new DirectoryIterator($dir); 
    }
    
    private function __clone() {}
    
    private function __wakeup() {}
    
    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance($dir)
    {
        if(is_null(self::$instance)) {
            self::$instance = new self($dir);
        }
        
        return self::$instance;
    }
    
    /**
     * This method returns data(folders and files in directory).
     * @return array
     */
    public function getData()
    {
        $data = $this->scanDir();
        
        return $data;
    }
    
    /**
     * This method returns sorted data(folders and files in directory) by fields(name, size, type, date).
     * @param string $field
     * @param string $sortType
     * @return array
     */
    public function getSortedData($field, $sortType)
    {
        $data = $this->scanDir();
        
        $data['files'] = $this->sortData($data['files'], $field, $sortType);
        $data['folders'] = $this->sortData($data['folders'], $field, $sortType);
        
        return $data;
    }
    
    /**
     * This method sorts the data.
     * @param array $data
     * @param string $field
     * @param string $sortType
     * @return array
     */
    public function sortData($data, $field, $sortType)
    {
        if($sortType == 'ascending') { //Ascending sort
            for($i = 0; $i < count($data); $i++) {
                for($j = 0; $j<count($data); $j++) { 
                    if(mb_strtolower($data[$i][$field]) > mb_strtolower($data[$j][$field]) && $data[$j]['name'] != '..' && $data[$i]['name'] != '..') {
                        $hold = $data[$i];
                        $data[$i] = $data[$j];
                        $data[$j] = $hold;
                    }
                }
            }
        } else { //Descendingly sort
            for($i = 0; $i < count($data); $i++) {
                for($j = 0; $j<count($data); $j++) { 
                    if(mb_strtolower($data[$i][$field]) < mb_strtolower($data[$j][$field]) && $data[$j]['name'] != '..' && $data[$i]['name'] != '..') {
                        $hold = $data[$i];
                        $data[$i] = $data[$j];
                        $data[$j] = $hold;
                    }
                }
            }
        }
        
        return $data;
    }
    
    /**
     * This method scanning directory and returns folders and files.
     * @return array
     */
    public function scanDir()
    {
        session_start();

        $files = [];
        $folders = [];

        foreach ($this->iterator as $entry) {
            if($entry->isDir()) { //If entry is folder
                if(strpos($entry, '..') === 0) { //.. folder
                    $file = [
                        'name' => $entry->getFilename(),
                        'time' => date('d.m.Y H:i', $entry->getMTime())
                    ];

                    $currentPath = $entry->getPath();
                    
                    array_unshift($folders, $file);
                } else if(strpos($entry, '.') !== 0) { //plain older
                    $file = [
                        'name' => $entry->getFilename(),
                        'time' => date('d.m.Y H:i', $entry->getMTime())
                    ];

                    $currentPath = $entry->getPath();
                    
                    array_push($folders, $file);
                }   
            } else { //If entry is file
                $file = [
                    'name' => $entry->getFilename(), 
                    'type' => $entry->getExtension() , 
                    'size' => $entry->getSize(), 
                    'time' => date('d.m.Y H:i', $entry->getMTime())
                ];
                
                array_push($files, $file);
            }
        }
        
        $_SESSION['current_path'] = $currentPath;
        
        return ['folders' => $folders, 'files' => $files];
    }  
}


