<?php

/**
 * Model for screenshot
 * @author ismd
 */
class Screenshot extends PsModel {

    /**
     * Saves file to public directory
     * @param string $filepath
     * @return string Relative path (url)
     */
    public function save($filepath) {
        $path = APPLICATION_PATH . '/../public/files/';

        do {
            $dt      = new DateTime;
            $seconds = substr($dt->getTimestamp(), -5);

            $file = $path . $dt->format('Y/m/d') . '/' . $seconds . '.png';
        } while (is_file($file));

        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0700, true);
        }

        move_uploaded_file($filepath, $file);
        return '/' . $dt->format('d-m-Y') . '/' . $seconds;
    }
}
