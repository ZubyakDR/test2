<? /**
 * @var $films
 **/ ?>

<div class="col-lg-4 col-lg-offset-1">
    <p class="lead">Список фильмов</p>
    <table class="table table-hover">
        <th>Название фильма</th>
        <th>Продолжительность</th>
        <tbody>
        <? foreach ($films

        as $film): ?>
        <tr>
            <td>
                <?= $film['title'] ?>
            </td>
            <td>
                <?= $film['durability'] ?>
            </td>
        </tr>
        </tbody>
        <? endforeach; ?>
    </table>
</div>
<div class="col-lg-4 col-lg-offset-1">
    <p class="lead">Добавить фильм</p>
    <form method="post" class="form-horizontal" id="formForAddFilm">
        <div class="form-group form-group-sm">
            <label class="col-sm-4 control-label" for="title">Название</label>
            <div class="col-sm-6">
                <input name="title" class="form-control" minlength="2" id="title" placeholder="Название" required>
            </div>
        </div>
        <div class="form-group form-group-sm">
            <label class="col-sm-4 control-label" for="durability">Продолжительность</label>
            <div class="col-sm-6">
                <input name="durability" min="0" class="form-control" type="number" id="durability" required
                       placeholder="Продолжительность">
            </div>
        </div>
        <button class="btn btn-success" id="addFilm">Добавить</button>
    </form>
    <hr>
    <p class="lead">Генератор сеансов</p>
    <button class="btn btn-success" id="generateSeances">Сгенерировать</button>
    <p id="generate-text"></p>
</div>
<div class="col-lg-4 col-lg-offset-4">
    <a href="/" class="text-center btn btn-primary btn-block">Вернуться на главную</a>
</div>