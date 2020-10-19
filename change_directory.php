<?php

class Path
{
    public $root_path = "/";
    public $current_path;

    public function __construct($original_path)
    {
        $this->ValidatePath($original_path);
        $this->current_path = $original_path;
    }



    public function cd($path)
    {
        $this->ValidatePath($path);
        $current_path_directories = explode("/", $this->current_path);
        $paths = explode("/", $path);

        $current = current($paths);

        while($current) {
            if($current == "..") {
                $len = count($current_path_directories);
                $current_path_directories = array_slice($current_path_directories, 0, $len - 1);
            } else {
                $current_path_directories[] = $current;
            }

            $current = next($paths);
        }

        // At root
        if(count($current_path_directories) == 1) {
            $this->current_path = $this->root_path;
            return;
        }

        $this->current_path = implode("/", $current_path_directories);
        return;
    }

    protected function validatePath($path)
    {
        $directory_names = explode("/", $path);

        foreach ($directory_names as $directory_name) {
            // Doing || empty to take care of the leading slash
            if($directory_name == ".." || empty($directory_name)) continue;

            // Match against alphabet. Case Insensitive
            if (! preg_match('/^[A-Z]+$/i', $directory_name)) {
                throw new \Exception("Directory names should only contain letters from the alphabet", 1);
            }
        }

        return true;
    }
}

$path = new Path('/a/b/c/d');
$path->cd('../../../../d');
echo $path->current_path;

