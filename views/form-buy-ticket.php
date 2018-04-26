<br>
<?php
/**
 * @var $film
 */
?>
<h3><?= $film['title'] . ' - ' . $film['beginning'] ?></h3>
<br>
<form method="post" class="form-horizontal">
    <div class="form-group form-group-sm">
        <label class="col-sm-4 control-label" for="costOneTicket">Стоимость билета</label>
        <div class="col-sm-6">
            <input name="costOneTicket" class="form-control" id="costOneTicket" disabled value="<?= $film['price'] ?>">
        </div>
    </div>
    <div class="form-group form-group-sm">
        <label class="col-sm-4 control-label" for="countTickets">Колличество билетов</label>
        <div class="col-sm-6">
            <input name="countTickets" class="form-control" min=1 max=<?= $film['quantity_seats'] ?> type="number"
                   id="countTickets" value="1">
        </div>
    </div>
    <div class="form-group form-group-sm">
        <label class="col-sm-4 control-label" for="totalCost">Общая стоимость</label>
        <div class="col-sm-6">
            <input class="form-control" id="totalCost" name="totalCost" disabled value="<?= $film['price'] ?>">
        </div>
    </div>
    <input type="hidden" name="idSeance" value="<?= $film['id'] ?>">
    <button class="btn btn-success" id="buy-ticket">Купить</button>
</form>