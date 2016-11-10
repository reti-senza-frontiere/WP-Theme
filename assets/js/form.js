
jQuery(document).ready(function() {
    /**
     * Switch button behaviours
     */
    jQuery(".switch").on("click", function() {
        setTimeout(function() {
            if(jQuery("#reg_person_type").is(":checked")) {
                jQuery("#company_data").removeClass("hide");
            } else {
                jQuery("#company_data").addClass("hide");
            }
        }, 100);
    });

    /**
     * Birthdate nad dates control
     */
    var date = new Date(),
        max_date = ((date.getDate() < 10) ? "0" : "") + date.getDate() + "/" + (date.getMonth() + 1) + "/" + (date.getFullYear() - 18);
    jQuery.validator.addMethod("check_date_of_birth", function(value, element) {
        var adult_date = new Date(),
            current_date = new Date(),
            day = value.split("/")[0],
            month = value.split("/")[1],
            year = value.split("/")[2],
            age =  18;

    	adult_date.setFullYear(year, month, day);
    	current_date.setFullYear(current_date.getFullYear() - age);
        console.log((date - adult_date < 0 ? false : true));
    	return (date - adult_date < 0 ? false : true);
    });
    jQuery.validator.addMethod("partita_iva", function (value) {
        return /^[0-9]{11}$/.test(value);
    });
    jQuery.validator.addMethod("phone_number", function (value) {
        return /^[0-9\-\(\)\s\+]+$/.test(value);
    });
    jQuery.validator.addMethod("codice_fiscale", function (value) {
        return /^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/.test(value);
    });
    jQuery("#reg_birth_date.datepicker").pickadate({
        selectMonths: true,
        selectYears: 20,
        format: "dd/mm/yyyy",
        min: "01/01/1900",
        max: max_date,
        monthsFull: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
        monthsShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
        weekdaysFull: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"],
        weekdaysShort: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"],
        labelMonthNext: "Mese prossimo",
        labelMonthPrev: "Mese scorso",
        labelMonthSelect: "Seleziona un mese",
        labelYearSelect: "Seleziona un anno",
        today: "Oggi",
        clear: "Pulisci",
        close: "Chiudi"
    });
    jQuery(".datepicker").pickadate({
        selectMonths: true,
        selectYears: 10,
        format: "dd/mm/yyyy",
        monthsFull: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
        monthsShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
        weekdaysFull: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"],
        weekdaysShort: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"],
        labelMonthNext: "Mese prossimo",
        labelMonthPrev: "Mese scorso",
        labelMonthSelect: "Seleziona un mese",
        labelYearSelect: "Seleziona un anno",
        today: "Oggi",
        clear: "Pulisci",
        close: "Chiudi"
    });

    /**
     * Form validation
     */
    jQuery.validator.setDefaults({
        ignore:":not(:visible)",
        errorClass: "invalid",
        validClass: "valid",
        errorPlacement: function (error, element) {
            // jQuery("#personal_data").find("button").addClass("disabled");
            jQuery(element)
                .closest("form")
                .find("label[for='" + element.attr("id") + "']")
                .attr('data-error', error.text());
        },
        submitHandler: function(form) {
            // form.preventDefault();
            console.log("form ok");
            var $this = jQuery(".tab-content:visible:last"),
                $button = $this.find("button.btn"),
                data_activate = $button.data("activate");
            if(data_activate !== "save") {
                jQuery("#tab_" + data_activate).removeClass("disabled");
                jQuery("ul.tabs").tabs("select_tab", data_activate);
                return false;
            } else {
                jQuery("#registration_form").submit();
            }
            // jQuery("#personal_data").find("button").removeClass("disabled");
        }
    });
    require_config("registration_form_validation_settings.json", function(config) {
        console.log(config);
        jQuery("#registration_form").slideDown();
        jQuery("#registration_form").validate(config);
    });

    jQuery("#reg_net_member").click(function() {
        if(jQuery("#reg_net_member").is(":checked")) {
            jQuery("#reg_net_member_why").slideDown();
        } else {
            jQuery("#reg_net_member_why").slideUp();
        }
    });
    jQuery("#reg_net_member_other_reason").on("click keyup", function() {
        if(!jQuery("#reg_net_member_other").is(":checked")) {
            jQuery("#reg_net_member_other").click();
        }
    });
    jQuery("#reg_net_member_other").click(function() {
        jQuery("#reg_net_member_other_reason").focus();
    });
});
