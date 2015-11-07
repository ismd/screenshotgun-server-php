<?php

class DateFormatterViewHelper extends PsViewHelper {

    private $months = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

    public function showPageFormat(DateTime $dateTime) {
        return $dateTime->format('j ' . $this->months[$dateTime->format('n') - 1] . ' Y');
    }
}
