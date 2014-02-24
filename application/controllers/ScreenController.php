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
}
