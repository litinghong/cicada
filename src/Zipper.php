<?php

namespace qxb\cicada;

use ZipArchive;

class Zipper extends ZipArchive
{

    public function addDir($path, $parent_dir = '')
    {
        if ($parent_dir != '') {
            $this->addEmptyDir($parent_dir);
            $parent_dir .= '/';
            print '<br>adding dir ' . $parent_dir . '<br>';
        }
        $nodes = glob($path . '/*');
        foreach ($nodes as $node) {
            if (is_dir($node)) {
                $this->addDir($node, $parent_dir . basename($node));
            } else if (is_file($node)) {
                $this->addFile($node, $parent_dir . basename($node));
            }
        }
    }
}