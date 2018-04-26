<? /**
 * @var $errorsInSchedule
 * @var $breaksGreaterThirtyMinutes
 * @var $statisticsOnFilm
 * @var $countVisitorsAndProceeds
 **/ ?>

<div class="col-lg-8 col-lg-offset-2 administrator">
    <div class="page-header">
        <p>Oшибки в расписании</p>
    </div>
    <? if ($errorsInSchedule): ?>
        <table class="table table-hover">
            <th>Фильм 1</th>
            <th>Время начала</th>
            <th>Длительность</th>
            <th>Фильм 2</th>
            <th>Время начала</th>
            <th>Длительность</th>
            <tbody>
            <? foreach ($errorsInSchedule

            as $errorInSchedule): ?>
            <tr>
                <td>
                    <?= $errorInSchedule['filmOne'] ?>
                </td>
                <td>
                    <?= $errorInSchedule['beginningFilmOne'] ?>
                </td>
                <td>
                    <?= $errorInSchedule['durabilityFilmOne'] ?>
                </td>
                <td>
                    <?= $errorInSchedule['filmTwo'] ?>
                </td>
                <td>
                    <?= $errorInSchedule['beginningFilmTwo'] ?>
                </td>
                <td>
                    <?= $errorInSchedule['durabilityFilmTwo'] ?>
                </td>
            </tr>
            </tbody>
            <? endforeach; ?>
        </table>
    <? else: ?>
        <span>Ошибок нет :)</span>
    <? endif; ?>
    <hr>
    <div class="page-header">
        <p>Перерывы больше или равные 30 минут между фильмами</p>
    </div>
    <? if ($breaksGreaterThirtyMinutes): ?>
        <table class="table table-hover">
            <th>Фильм 1</th>
            <th>Время начала</th>
            <th>Длительность</th>
            <th>Время начала второго фильма</th>
            <th>Длительность перерыва</th>
            <tbody>
            <? foreach ($breaksGreaterThirtyMinutes

            as $breakGreaterThirtyMinutes): ?>
            <tr>
                <td>
                    <?= $breakGreaterThirtyMinutes['film'] ?>
                </td>
                <td>
                    <?= $breakGreaterThirtyMinutes['beginningFilmOne'] ?>
                </td>
                <td>
                    <?= $breakGreaterThirtyMinutes['durability'] ?>
                </td>
                <td>
                    <?= $breakGreaterThirtyMinutes['beginningFilmTwo'] ?>
                </td>
                <td>
                    <?= $breakGreaterThirtyMinutes['durationBreak'] ?>
                </td>
            </tr>
            </tbody>
            <? endforeach; ?>
        </table>
    <? else: ?>
        <span>Перерывов больше или равные 30 минут между фильмами нет :)</span>
    <? endif; ?>
    <hr>
    <div class="page-header">
        <p>Статистика по фильмам</p>
    </div>
    <? if ($statisticsOnFilm): ?>
        <table class="table table-hover">
            <th>Фильм</th>
            <th>Общее число посетителей</th>
            <th>Среднее число посетителей</th>
            <th>Сумма сбора</th>
            <tbody>
            <? foreach ($statisticsOnFilm

            as $statisticOnFilm): ?>
            <tr>
                <td>
                    <?= $statisticOnFilm['titleFilm'] ?>
                </td>
                <td>
                    <?= $statisticOnFilm['totalVisitors'] ?>
                </td>
                <td>
                    <?= $statisticOnFilm['averageVisitors'] ?>
                </td>
                <td>
                    <?= $statisticOnFilm['totalAmount'] ?>
                </td>
            </tr>
            </tbody>
            <? endforeach; ?>
        </table>
    <? else: ?>
        <span>Фильмов нет :(</span>
    <? endif; ?>
    <hr>
    <div class="page-header">
        <p>Число посетителей и кассовые сборы</p>
    </div>
    <? if ($countVisitorsAndProceeds): ?>
        <table class="table table-hover">
            <th>Интервал</th>
            <th>Число посетителей</th>
            <th>Сумма сбора</th>
            <tbody>
            <? foreach ($countVisitorsAndProceeds

            as $countVisitorAndProceeds): ?>
            <tr>
                <td>
                    <?= $countVisitorAndProceeds['timeInterval'] ?>
                </td>
                <td>
                    <?= $countVisitorAndProceeds['totalVisitors'] ?>
                </td>
                <td>
                    <?= $countVisitorAndProceeds['totalPrice'] ?>
                </td>
            </tr>
            </tbody>
            <? endforeach; ?>
        </table>
    <? else: ?>
        <span>Посетители и кассовые сборы отсутствуют :(</span>
    <? endif; ?>
</div>
<div class="col-lg-4 col-lg-offset-4">
    <a href="/" class="text-center btn btn-primary btn-block">Вернуться на главную</a>
</div>