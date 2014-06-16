<?php
/**
 * Контроллер для работы со скриншотами
 * @author ismd
 */

class ScreenController extends PsController {

    /**
     * Отображает страницу со скриншотом
     * @throws Exception
     */
    public function showAction() {
        $args = $this->getArgs();

        if (count($args) != 2) {
            throw new Exception('Bad request');
        }

        list($user, $file) = $args;

        $filepath = '/files/' . $user . '/' . $file . '.png';

        if (!is_file(APPLICATION_PATH . '/../public' . $filepath)) {
            throw new Exception("File doesn't exists'");
        }

        $this->view->file_url = $filepath;
    }

    public function uploadAction() {
        if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->view->json('error');
            return;
        }

        move_uploaded_file($_FILES['image']['tmp_name'], APPLICATION_PATH . '/../public/files/usr/tmp.png';// . $_FILES['image']['name']);
        $this->view->json('ok');
    }
}
