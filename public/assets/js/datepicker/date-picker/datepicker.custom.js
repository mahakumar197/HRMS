"use strict";
(function ($) {
    "use strict";
    //Minimum and Maxium Date
    $('#minMaxExample').datepicker({
        language: 'en',
        minDate: new Date() // Now can select only dates, which goes after today
    })

    //Disable Days of week
    var disabledDays = [0, 6];

    $('#disabled-days').datepicker({
        language: 'en',
        onRenderCell: function (date, cellType) {
            if (cellType == 'day') {
                var day = date.getDay(),
                    isDisabled = disabledDays.indexOf(day) != -1;
                return {
                    disabled: isDisabled
                }
            }
        }
    })

    //Select Only one month

    var CurrentTime = new Date()
    var MinDate = new Date(CurrentTime.getFullYear(), CurrentTime.getMonth(), +1);
    var MaxDate = new Date(CurrentTime.getFullYear(), CurrentTime.getMonth() + 1, +0);


    //one day next before month

    // one day before next month   
    $("#currentmonth").datepicker({
        language: 'en',
        setDate: new Date(),
        dateFormat: 'dd-mm-yyyy',
        showOn: "focus",
        minDate: MinDate,
        maxDate: MaxDate,
        autoclose: true,
    });

    $("#currentmonth2").datepicker({
        language: 'en',
        setDate: new Date(),
        dateFormat: 'dd-mm-yyyy',
        showOn: "focus",
        minDate: MinDate,
        maxDate: MaxDate,
        autoclose: true,


    });

    // attendance 

    var currentTime = new Date()

    var Tenth_of_month = new Date(currentTime.getFullYear(), currentTime.getMonth(), +10);

    if (currentTime > Tenth_of_month) {
        var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), +1);
        var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 1, +0);
    }
    else {
        var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth() - 1);
        var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 1, +0);

    }

    $("#attendance_picker").datepicker({
        language: 'en',
        setDate: new Date(),
        dateFormat: 'dd-mm-yyyy',
        showOn: "focus",
        minDate: minDate,
        maxDate: maxDate,
        autoclose: true,
        onRenderCell: function (date, cellType) {
            if (cellType == 'day') {
                var day = date.getDay(),
                    isDisabled = disabledDays.indexOf(day) != -1;
                return {
                    disabled: isDisabled
                }
            }
        }


    });



    // Leave 


    var LeaveminDate = new Date(currentTime.getFullYear(), currentTime.getMonth() - 1,);
    var LeavemaxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 1, +0);


    $(".leave_picker").datepicker({
        language: 'en',
        setDate: new Date(),
        dateFormat: 'dd-mm-yyyy',
        showOn: "focus",
        minDate: LeaveminDate,
        maxDate: LeavemaxDate,
        autoclose: true,
        allowInputToggle: true,
        onRenderCell: function (date, cellType) {
            if (cellType == 'day') {
                var day = date.getDay(),
                    isDisabled = disabledDays.indexOf(day) != -1;
                return {
                    disabled: isDisabled
                }
            }
        }


    });



    $("#future").datepicker({ maxDate: new Date(), format: 'dd-mm-yyyy', });
       
    $("#past_date").datepicker({minDate: new Date(),});


    var currentDate = new Date();
    $('.disableFuturedate').datepicker({
        autoclose: true,
        endDate: "currentDate",
        maxDate: currentDate
    }).on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });
    $('.disableFuturedate').keyup(function () {
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9^-]/g, '');
        }
    });









})(jQuery);