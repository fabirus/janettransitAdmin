function common() {

    /**
     * DateTimepicker For date
     */
    var date = function date() {
        $('.datetimepicker').datetimepicker({
            'locale'            : 'fr',
            format              : 'L',
            daysOfWeekDisabled  : [0,7],
            showClear           : true,
            showClose           : true,
            ignoreReadonly      : true,
            useCurrent          : false
        });
    };


    /**
     * DateTimepicker For Hour
     */
    var heure = function heure() {
        $('.hourpicker').datetimepicker({
            'locale'            : 'fr',
            format              : 'LT',
            showClear           : true,
            showClose           : true,
            ignoreReadonly      : true,
            defaultDate         : 'moment',
            useCurrent          : false

        });
    };

    /**
     * DateTimepicker For Period month/year
     */
    var periode = function periode() {
        $('.periodepicker').datetimepicker({
            'locale'            : 'fr',
            viewMode            : 'years',
            format              : 'MM/YYYY',
            showClear           : true,
            showClose           : true,
            ignoreReadonly      : true,
            defaultDate         : 'moment',
            useCurrent          : false

        });
    };

    var readOnly = function readOnly(){
        $('.dateFormat').on("focusin", function() {
            console.log('here');

            $(this).prop('readonly', true);

        }).on("focusout", function() {

            $(this).prop('readonly', false);

        });
    };


    /**
     * Function for put search and tri of table
     * @param order
     */
    var dataTable = function dataTable(order, locale){
        //console.log(locale);
        var lang = 'French.json';

        if(locale === 'en'){
            lang = 'English.json'
        }
        else {
            lang = 'French.json';
        }
        $('.dataTable').DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/"+lang
            },
            "order": [[ order, "desc" ]] // mettre cet ordre pour les dates 4 represente le numero 5 de la colonne puisqu'il s'agit d'un tableau

            //"pagingType": "full_numbers" // pour la pagination premier et dernier
        });
    };


    var notice = function notice (text, type, delay) {
        var noticeTimeout;

        /**
         * Show notice
         * @param {String} text - notice text
         * @param {String} [type] - (optional) : ok, ko, info (default = ok)
         * @param {number} [delay] - (optional) : (default = 2500 ms)
         */
        type        = type || "ok";
        delay       = delay || 2500;
        var $notice = $('#notice');

        $notice.one('click', function () {
            $notice.css("top", "-120px");
        });

        clearTimeout(noticeTimeout);
        $notice
            .off('webkitTransitionEnd otransitionend oTransitionEnd MSTransitionEnd transitionend')
            .removeClass('ok')
            .removeClass('ko')
            .addClass(type)
            .text(text)
            .css("top", "0");

        noticeTimeout = setTimeout(function() {
            $notice
                .css("top", "-120px")
                .off('webkitTransitionEnd otransitionend oTransitionEnd MSTransitionEnd transitionend')
                .one('webkitTransitionEnd otransitionend oTransitionEnd MSTransitionEnd transitionend',
                function (e) {
                    $notice.off('webkitTransitionEnd otransitionend oTransitionEnd MSTransitionEnd transitionend');
                    $notice.text("").removeClass(type);
                });
        }, delay);

    };


    /**
     * Init Popover
     */
    var initPopover = function initPopover(){
        $('[data-toggle="popover"]').popover({
            html : true,
            content: function() {
                return $('#popoverDeleteContent').html();
            }
        });
    };


    /**
     * Close Popover
     */
    var closePopover = function closePopover() {
        $('[data-toggle="popover"]').popover('hide');
    };

    /**
     * File View
     */
    var fileShow = function fileShow() {

        $('.fileUpload').hover(function(){
            $('.removeFile').css({'display': 'block'});
            $('.upload').css({'display': 'none'});
        }, function(){
            $('.removeFile').css({'display': 'none'});
            $('.upload').css({'display': 'block'});

        });

        $('.fileUpload1').hover(function(){
            $('.removeFile1').css({'display': 'block'});
            $('.upload1').css({'display': 'none'});
        }, function(){
            $('.removeFile1').css({'display': 'none'});
            $('.upload1').css({'display': 'block'});

        });

        $('.delete').click(function(){
            $('.fileType').show();
            $('.fileUpload').hide();
        });

        $('.delete1').click(function(){
            $('.fileType1').show();
            $('.fileUpload1').hide();
        });
    };


    /**
     * delete Entity, put the Entity del Field to 1
     */
    var deleteEntity = function  deleteEntity(id, idRefresh, idRefresh2, idRefresh3) {
        if(!_.isUndefined(idRefresh)) {
            if(!_.isUndefined(idRefresh2)) {
                if(!_.isUndefined(idRefresh3)) {
                    if ($('.popover-content #responseDel').val() === 'OK') {
                        window.location.href = Routing.generate($('[data-toggle="popover"]').attr('data-route'), {'id' : id, 'del' : 1, 'idRefresh' : idRefresh, 'idRefresh2' : idRefresh2, 'idRefresh3' : idRefresh3 });
                    }
                }
                else{
                    if ($('.popover-content #responseDel').val() === 'OK') {
                        window.location.href = Routing.generate($('[data-toggle="popover"]').attr('data-route'), {'id' : id, 'del' : 1, 'idRefresh' : idRefresh, 'idRefresh2' : idRefresh2 });
                    }
                }
            }
            else {
                if ($('.popover-content #responseDel').val() === 'OK') {
                    window.location.href = Routing.generate($('[data-toggle="popover"]').attr('data-route'), {'id' : id, 'del' : 1, 'idRefresh' : idRefresh });
                }
            }
        }
        else{
            if ($('.popover-content #responseDel').val() === 'OK') {
                window.location.href = Routing.generate($('[data-toggle="popover"]').attr('data-route'), {'id' : id, 'del' : 1 });
            }
        }

    };





    /**
     * Validation of Form
     */
    var validForm = function validForm(){
        var form = $("form");
        form.validate();
        console.log(form.valid())
    };


    /**
     * Search Entity
     */
    var searchForm = function searchForm(){
        var searchText = $('.searchForm').val();

        $.ajax({
            type: "GET",
            url : Routing.generate($('.result').data('route')),
            cache: false,
            dataType: 'json',
            data: {searchText : searchText},
            success : function(response)
            {
                $('.result').html(response['view']);
                //console.log(response['view']);
                //$('.result_search').fadeIn('slow');
            },
            error : function(err){
                console.log(err);
            }
        });

    };

    /**
     * Search Animate Form
     */
    var searchFormAnimate = function searchFormAnimate(){
        $('.searchForm').animate({
            width   : '200%',
            right   : '100%'
        },500).blur(function(){
            $(this).animate({
                width: '100%',
                right: '0%'
            });
            //$(this).val('');
        });
    };


    /**
     * Select All Poste for Service
     */
    var selectPoste = function selectPoste() {
        $.ajax({
            type: "GET",
            url : Routing.generate('poste_of_service', {'id' : $('.selectService').val() }),
            cache: false,
            dataType: 'json',
            success : function(response){
                $('.selectPoste').html(response['view']);
            },
            error : function(err){
                console.log(err);
            }
        });
    };


    /**
     * Search existing file in BDD
     */
    var checkFileBDD = function checkFileBDD(router, file){
        $.ajax({
            type: "GET",
            url : Routing.generate(router, {'file' : $('.'+file)[0].files[0].name }),
            cache: false,
            dataType: 'json',
            success : function(response){
                if(response === true){
                    $('.register').prop('disabled', true);
                    $('.'+file).parent().next().show('slow');
                    //alert('Ce nom de fichier est déja présent, veuillez le renommer')
                }
                else {
                    $('.register').prop('disabled', false);
                    $('.'+file).parent().next().hide('slow');
                }
            },
            error : function(err){
                console.log(err);
            }
        });
    };


    /**
     * Search existing date in BDD
     */
    var checkDateBDD = function checkDateBDD(router, date){
        $.ajax({
            type: "GET",
            url : Routing.generate(router, {'idEmploye' : $('#checkDate').data('employe') }),
            cache: false,
            dataType: 'json',
            data: {date : $('.'+date).val()},
            success : function(response){
                console.log(response);
                if(response === true){
                    $('.register').prop('disabled', true);
                    $('.'+date).parent().next().show('slow');
                    //alert('Cette date/période existe déja pour cet employé')
                }
                else {
                    $('.register').prop('disabled', false);
                    $('.'+date).parent().next().hide('slow').css('display','none');
                }
            },
            error : function(err){
                console.log('erreur',err);
            }
        });
    };

    /**
     * Search qte in BDD
     */
    var checkQte = function checkQte(router, qte, stockId){
        $.ajax({
            type: "GET",
            url : Routing.generate(router, {'idStock' : $('.'+stockId).val() }),
            cache: false,
            dataType: 'json',
            data: {qte : $('.'+qte).val()},
            success : function(response){
                console.log(response);
                if(response !== false){
                    $('.register').prop('disabled', true);
                    if(response == 0) {
                        $('.error_qte').html('Le stock est vide').show('slow');
                    }
                    else {
                        $('.error_qte').html('Il ne reste plus que '+response+' en stock').show('slow');

                    }
                }
                else {
                    $('.register').prop('disabled', false);
                    $('.error_qte').hide('slow').css('display','none');
                }
            },
            error : function(err){
                console.log('erreur',err);
            }
        });
    };

    /**
     * Search existing date in BDD
     */
    var checkDateCustomBDD = function checkDateCustomBDD(router, date){
        $.ajax({
            type: "GET",
            url : Routing.generate(router, {'idContrat' : $('#checkDate').data('contrat'), 'idTypeDepense' : $('#checkDate').data('typedepense') }),
            cache: false,
            dataType: 'json',
            data: {date : $('.'+date).val()},
            success : function(response){
                console.log(response);
                if(response === true){
                    $('.register').prop('disabled', true);
                    $('.'+date).parent().next().show('slow');
                    //alert('Cette date/période existe déja pour cet employé')
                }
                else {
                    $('.register').prop('disabled', false);
                    $('.'+date).parent().next().hide('slow').css('display','none');
                }
            },
            error : function(err){
                console.log('erreur',err);
            }
        });
    };

    var print = function print(noprint, titre) {
        $(".print").print({
            globalStyles: true,
            mediaPrint: false,
            stylesheet: null,
            noPrintSelector: "."+noprint,
            iframe: true,
            //append: 'Liste des contrats',
            prepend: '<h4 style="text-decoration: underline; text-align: center"><b>'+titre+'</b> </h4>',
            //manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 250
        });
    };


    //var print = function print(div, titre) {
    //    //var form = $('.'+div),
    //    //    cache_width = form.width(),
    //    //    //a4  =[ 341.89, 595.28];
    //    //    a4  =[ 595.28,  841.89];  // for a4 size paper width and height
    //    //
    //    //$('body').scrollTop(0);
    //    //createPDF();
    //    //function createPDF(){
    //    //    getCanvas().then(function(canvas){
    //    //        var
    //    //            img = canvas.toDataURL("image/png"),
    //    //            doc = new jsPDF({
    //    //                unit:'px',
    //    //                format:'a4'
    //    //            });
    //    //        doc.addImage(img, 'JPEG', 20, 20);
    //    //        doc.save(titre);
    //    //        form.width(cache_width);
    //    //    });
    //    //}
    //    //
    //    //function getCanvas(){
    //    //    form.width((a4[0]*1.33333) -80).css('max-width','none');
    //    //    return html2canvas(form,{
    //    //        imageTimeout:2000,
    //    //        removeContainer:true
    //    //    });
    //    //}
    //};


    var validation = function validation(){
        var number      = $(".number"),
            fileImage   = $(".fileImage"),
            filePdf     = $(".filePdf");

        $.validator.addMethod(
            "phone",
            function(value, element) {
                return this.optional(element) || /^\d{3}\-\d{2}\-\d{2}\-\d{2}$/.test(value);
            },
            "Mauvais format ex: 699-10-63-94"
        );

        $.validator.addMethod(
            "filesize",
            function(value, element, params) {
                //console.log(element.files[0].size/(1024*1024));
                return this.optional(element) || (element.files[0].size/(1024*1024) <= params);
            },
            "Taille maximale 2Mo"
        );

        if(number.length >0){
            $(".number").validate({
                rules: {
                    field: {
                        required: true,
                        number: true
                    }
                }
            });
        }

        if(fileImage.length >0){
            $('.fileImage').rules('add', {
                accept: "image/jpeg, image/png"
            });
        }

        if(filePdf.length >0){
            $('.filePdf').rules('add', {
                accept: "application/pdf"
            });
        }

      $.extend(jQuery.validator.messages, {
            required: "Ce champ est requis.",
            remote: "Please fix this field.",
            email: "Svp entrer une adresse email valide.",
            url: "Svp entrer une adresse URL valide.",
            date: "Svp entrer une date valide.",
            dateISO: "Please enter a valid date (ISO).",
            number: "Svp entrer un nombre valide.",
            digits: "Please enter only digits.",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            accept: "Svp entrer un extension de fichier valide.",
            maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
            minlength: jQuery.validator.format("Please enter at least {0} characters."),
            rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
            range: jQuery.validator.format("Please enter a value between {0} and {1}."),
            max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
            min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
        });
    };





    return {
        date  	            : date,
        heure  	            : heure,
        notice 	            : notice,
        initPopover         : initPopover,
        deleteEntity        : deleteEntity,
        closePopover        : closePopover,
        validForm           : validForm,
        searchForm          : searchForm,
        searchFormAnimate   : searchFormAnimate,
        selectPoste         : selectPoste,
        print               : print,
        dataTable           : dataTable,
        checkFileBDD        : checkFileBDD,
        checkDateBDD        : checkDateBDD,
        periode             : periode,
        readOnly            : readOnly,
        validation          : validation,
        checkDateCustomBDD  : checkDateCustomBDD,
        fileShow            : fileShow,
        checkQte            : checkQte
    };
}



//$(".infos_employe" ).hover(function(){
//    console.log('herhe');
//    $( this ).find('.description').css({
//        'display'       : 'block',
//        'margin-top'    : '-245px'
//    });
//}, function(){
//    $( this ).find('.description').css('display' ,'none');
//    //$( this ).removeClass( "hover" );
//});





