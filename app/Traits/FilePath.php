<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 05.10.18
 * Time: 11:12
 */

namespace App\Traits;


trait FilePath
{

    public function makeFolder($path, $mode = 0775)
    {
        $folders = explode('/', $path);

        $currentFolder = '';
        foreach ($folders as $folder) {
            $currentFolder .= $folder . DIRECTORY_SEPARATOR;
            if (!file_exists($currentFolder)) {
                mkdir($currentFolder, $mode);
            }
        }
    }

    /**
     * @param string|array $file
     */
    public function deleteFile($file)
    {
        if (is_string($file)) {
            if (file_exists($file)) {
                unlink($file);
            }
        } else {
            foreach ((array)$file as $item) {
                if (file_exists($item)) {
                    unlink($item);
                }
            }
        }

    }

}