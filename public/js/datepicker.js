$(document).ready(function () {
    $.fn.datepicker.dates['fr'] = {
        days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
        months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Jully", "Août", "Septembre", "Octobre", "Novembre", "Decembre"],
        monthsShort: ["Jan", "Fev", "Mar", "Avr", "Mai", "Jun", "Jul", "Au", "Sep", "Oct", "Nov", "Dec"],
        today: "Aujourd'hui",
        clear: "Effacer",
        format: "dd/MM/yyyy",
        titleFormat: "MM yyyy", //Leverages same syntax as 'format'
        weekStart: 7
    };

    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd',
        language: 'fr',
        todayBtn: "linked",
        todayHighlight: true,
        startDate: "now",
        daysOfWeekDisabled: "0, 2",
        daysOfWeekHighlighted: "0, 2",
        autoclose: true,
    });


});