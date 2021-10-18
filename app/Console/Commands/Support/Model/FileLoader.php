<?php

namespace App\Console\Commands\Support\Model;

class FileLoader
{
    public function save($items)
    {
       $file ='';
       $this->files->put($file, '<?php return ' . var_export($items, true) . ';');
    }
}
