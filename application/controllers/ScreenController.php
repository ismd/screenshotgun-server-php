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
        $this->processShow();
    }

    /**
     * Show user's screenshot page
     * @throws Exception
     */
    public function showUserAction() {
        $this->processShow();
        $this->view->render('screen/show');
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

    /**
     * Sets view variables
     * @throws Exception
     */
    protected function processShow() {
        $args = $this->parseArgs($this->getArgs());

        $filepath = '/files/' . (!is_null($args['user']) ? $args['user'] . '/' : '')
            . $args['date']->format('Y/m/d') . '/' . $args['filename'] . '.png';

        if (!is_file(realpath(APPLICATION_PATH . '/../public' . $filepath))) {
            throw new Exception("File doesn't exists'");
        }

        $this->view->date = $args['date'];
        $this->view->fileUrl = $filepath;
        $this->view->meta([
            'og:site_name' => 'Screenshotgun',
            'og:description' => 'Скриншот загружен ' . $this->view->getHelper('dateFormatter')->showPageFormat($this->view->date),
            'og:image' => (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off' ? 'http://' : 'https://') . $_SERVER['SERVER_NAME'] . $filepath,
        ]);
    }

    /**
     * Parsing GET-parameters
     * @param mixed[] $args
     * @return mixed[]
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

        list($year, $month, $day) = explode('-', $date);

        // Old links
        if (4 == strlen($day)) {
            $tmp = $day;
            $day = $year;
            $year = $tmp;
        }

        return [
            'date' => new DateTime(implode('-', [$year, $month, $day])),
            'user' => isset($user) ? $user : null,
            'filename' => $filename,
        ];
    }
}
