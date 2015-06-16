<?php

/**
 * Controller for screenshots
 * @author ismd
 */
class ScreenController extends PsController {

    /**
     * Shows screenshot page
     * @throws Exception
     */
    public function showAction() {
        $this->view->fileUrl = $this->parseArgs($this->getArgs());
    }

    /**
     * Show user's screenshot page
     * @throws Exception
     */
    public function showUserAction() {
        $this->view->fileUrl = $this->parseArgs($this->getArgs());
        $this->view->render('screen/show');
    }

    /**
     * Parsing GET-parameters
     * @param mixed[] $args
     * @return string Path to the file
     * @throws Exception
     */
    protected function parseArgs($args) {
        $countArgs = count($args);

        if (2 != $countArgs && 3 != $countArgs) {
            throw new Exception('Bad request');
        }

        if (3 == $countArgs) {
            list($user, $date, $filename) = $args;
        } else {
            list($date, $filename) = $args;
        }

        list($day, $month, $year) = explode('-', $date);

        $filepath = '/files/' . (isset($user) ? "$user/" : '') . "$year/$month/$day/$filename.png";
        if (!is_file(APPLICATION_PATH . '/../public' . $filepath)) {
            throw new Exception("File doesn't exists'");
        }

        return $filepath;
    }

    public function uploadAction() {
        if (!$this->getRequest()->isPost()) {
            throw new Exception('Bad request');
        }

        PsLogger::getInstance()->log([
            'action' => 'Uploading',
            'file'   => $_FILES['image'],
        ]);

        if (UPLOAD_ERR_OK != $_FILES['image']['error']) {
            $this->view->json([
                'status' => 'error',
            ]);
        }

        try {
            $path = (new Screenshot)->save($_FILES['image']['tmp_name']);
        } catch (Exception $e) {
            $this->view->json([
                'status' => 'error',
            ]);
        }

        $this->view->json([
            'status' => 'ok',
            'url'    => $this->getHelper('server')->url() . $path,
        ]);
    }
}
