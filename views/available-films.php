<? /**
 * @var $seances
 **/ ?>
<? if ($seances): ?>
    <table class="table table-hover">
        <th></th>
        <th>Название фильма</th>
        <th>Продолжительность</th>
        <th>Время</th>
        <th>Стоимость</th>
        <th>Колличество свободных мест</th>
        <tbody>
        <? foreach ($seances

        as $seance): ?>
        <tr>
            <td>
                <label for="input-radio"></label>
                <input id="input-radio" type="radio" name="id" data-seance="change"
                       <? if ($seance['quantity_seats'] == 0): ?>disabled<? endif; ?> value="<?= $seance['id'] ?>">
            </td>
            <td>
                <?= $seance['title'] ?>
            </td>
            <td>
                <?= $seance['durability'] ?>
            </td>
            <td>
                <?= $seance['time'] ?>
            </td>
            <td>
                <?= $seance['price'] ?>
            </td>
            <td>
                <?= $seance['quantity_seats'] ?>
            </td>
        </tr>
        </tbody>
        <? endforeach; ?>
    </table>
<? else: ?>
    <p>На выбранную дату сеансы отсутствуют</p>
<? endif; ?>
