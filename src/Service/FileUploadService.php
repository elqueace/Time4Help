<?php
/**
 * Created by PhpStorm.
 * User: gambierolivier
 * Date: 01/03/2019
 * Time: 01:04
 */

namespace App\Service;


class FileUploadService
{
    public function uploadFile($file, $path)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
            $path,
            $fileName
        );
        return $path.$fileName;
    }

}