$(document).ready(function () {
    $('#for_from').datepicker({
        'format': "dd-mm-yyyy"
    });

    $('input[name=interesting_date]').on('change', function () {
        let date = $(this).val();
        getSeances(date);
    });

    function getSeances(date) {
        $.ajax({
            url: '/ajax/getSeances',
            type: "POST",
            dataType: "json",
            data: {date: date},
            success: function (data) {
                if (data) {
                    addingAfterRequest('#seance-list', data.template)
                } else {
                    $('#seance-list').empty();
                }
            }
        });
    }

    function addingAfterRequest(element, template) {
        $(element).empty().html(template);
    }

    $('#seance-list').on('click', '[type="radio"]', function () {
        let idSeance = this.value;
        getFilm(idSeance);
    });

    function getFilm(idSeance) {
        $.ajax({
            url: '/ajax/getFilm',
            type: "POST",
            dataType: "json",
            data: {idSeance: idSeance},
            success: function (data) {
                if (data) {
                    addingAfterRequest('#form-buy-ticket', data.template)
                } else {
                    $('#form-buy-ticket').empty();
                }
            }
        });
    }

    $('#form-buy-ticket').on('change', '#countTickets', function () {
        let costOneTicket = $('#costOneTicket').val(),
            countTicket = this.value,
            totalCost = $('#totalCost');
        totalCost.val(costOneTicket * countTicket);
    });

    $('#generateSeances').on('click', function (e) {
        e.preventDefault();
        let successText = $('#generate-text');
        successText.html();
        $.ajax({
            url: '/ajax/generateSeances',
            type: "POST",
            dataType: "json",
            beforeSend: function() {
                $('#generateSeances').html("<img class=\"loader\" src=\"/media/images/generate-loader.gif\">");
            },
            complete: function() {
                $('#generateSeances').html("Сгенерировать");
            },
            success: function (data) {
                if (data) {
                    successText.html('Сеансы успешно сгенерированы');
                } else {
                    successText.html('Произошла ошибка, попробуйте еще раз');
                }
            }
        });
    })
});