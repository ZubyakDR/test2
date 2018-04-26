<?php

namespace controllers;

use models\Administrator as administratorModel;

class Administrator extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function action_index()
    {
        $this->title = 'Администрирование';
        $administratorModel = new administratorModel();
        $errorsInSchedule = $administratorModel->getErrorsInSchedule();
        $breaksGreaterThirtyMinutes = $administratorModel->getBreaksGreaterThirtyMinutes();
        $statisticsOnFilm = $administratorModel->getStatisticsOnFilm();
        $countVisitorsAndProceeds = $administratorModel->getCountVisitorsAndProceeds();
        $this->content = $this->template('administrator.php', [
            'errorsInSchedule' => $errorsInSchedule,
            'breaksGreaterThirtyMinutes' => $breaksGreaterThirtyMinutes,
            'statisticsOnFilm' => $statisticsOnFilm,
            'countVisitorsAndProceeds' => $countVisitorsAndProceeds
        ]);
    }
}