<?php

namespace App\Http\Services\File;


class FileService extends FileToolsService
{

    public function move($file, $directory = 'public')
    {
        if ($directory == 'public')
            return $this->moveToPublic($file);
        else
            return $this->moveToStorage($file);
    }

    public function moveToPublic($file)
    {
        //set File
        $this->setFile($file);
        //execute provider
        $this->provider();
        //save File
        $result = $file->move(public_path($this->getFinalFileDirectory()), $this->getFinalFileName());
        return $result ? $this->getFileAddress() : false;
    }


  public function moveToStorage($file)
    {
        //set File
        $this->setFile($file);
        //execute provider
        $this->provider();
        //save File
        $result = $file->move(storage_path($this->getFinalFileDirectory()), $this->getFinalFileName());
        return $result ? $this->getFileAddress() : false;
    }


    public function deleteFile($filePath, $storage = false)
    {
        if($storage){
            unlink(storage_path($filePath));
            return true;
        }

        if(file_exists($filePath))
        {
            unlink($filePath);
            return true;
        }
        else{
            return false;
        }

    }


    public function deleteDirectoryAndFiles($directory)
    {
        if(!is_dir($directory))
        {
            return false;
        }

        $files = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_MARK);
        foreach($files as $file)
        {
            if(is_dir($file))
            {
                $this->deleteDirectoryAndFiles($file);
            }
            else{
                unlink($file);
            }
        }
        $result = rmdir($directory);
        return $result;
    }


}
