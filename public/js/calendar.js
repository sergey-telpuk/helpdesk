var now = new Date();

jQuery('#datetimepicker').datetimepicker({
    lang:'ru',
    i18n:{
        de:{
            months:[
                'Январь','Февраль','Март','Апрель',
                'Май','Июнь','Июль','Август',
                'Сентябрь','Октябрь','Ноябрь','Сентябрь',
            ],
            dayOfWeek:[
                "Вск.", "Пнд", "Втр", "Срд",
                "Чтв", "Птн", "Сбт",
            ]
        }
    },
    datepicker: true,
    inline:false,
    format:'d-m-Y H:00'
});
