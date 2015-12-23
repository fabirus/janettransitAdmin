
//================================================upload==================================================
// validation des uploads coté client.
$('.file').change(function(){
//$(this).tooltip('destroy');
//console.log(Math.round(this.files[0].size)/(1024*1024));
var size = Math.round(this.files[0].size)/(1024*1024);
if(size > 2 ){
    console.log('here');
    $('.register').prop('disabled', true);
    $(this).tooltip({'delay' : {
        "show"      : 50,
        "hide"      : 500000
    }}).attr('data-original-title', 'Taille maximale 2 Mo');
    return;
}


    var valid   = upload(this),
        length  = _.uniq(valid);

    if (length.length >= 2 || (length.length === 1 && length[0] === false)) {
        $('.register').prop('disabled', true);
    }
    else if (length.length === 1 && length[0] === true) {
        $('.register').prop('disabled', false);
    }

});

// founction de verification
function upload(){
    var valid   = [];
    $('.file').each(function(item, file){
        var ext  = file.value.split('.').pop().toLowerCase();
        var extension = [];

        if ($(file).attr('data-name') == 'imageFile' ){
            extension = ['png','jpg','jpeg'];
        }

        if ($(file).attr('data-name') == 'file' ){
            extension = ['pdf'];
        }

        if ($.inArray(ext, extension) === -1 && file.value !== '') {
            $(file).tooltip({'delay' : { "show": 50, "hide": 500000 }});
            valid.push(false);
        }
        else {
            valid.push(true);
            $(file).tooltip('destroy');
        }
    });
    return valid;
}


//================================================date validation==================================================
//$('.dateFormat').focusin(function(){
//    console.log('here');
//    console.log(this.value);
//    if (this.value.match(/^\d{2}\/\d{2}\/\d{4}$/)) {
//        console.log('here');
//
//    }
//    //var valid   = upload(this),
//    //    length  = _.uniq(valid);
//    //
//    //if (length.length >= 2 || length.length === 1 && length[0] === false) {
//    //    $('.register').prop('disabled', true);
//    //}
//    //else if (length.length === 1 && length[0] === true) {
//    //    $('.register').prop('disabled', false);
//    //}
//
//});

////================================================phone validation==================================================
////'697-89-46-61'.match(/^\d{3}\-\d{2}\-\d{2}\-\d{2}$/)
//$('.phoneNumber').focusout(function(){
//    console.log(this.value);
//    if (_.isNull(this.value.match(/^\d{3}\-\d{2}\-\d{2}\-\d{2}$/))) {
//        $(this).css({'border-color' : 'red'});
//        $(this).tooltip({'delay' : { "show": 1, "hide": 500000 }});
//        $(this).tooltip('enable');
//        $('.register').prop('disabled', true);
//        //$(this).tooltip('show');
//    }
//    else{
//        $(this).css({'border-color' : 'green'});
//        //$(this).data('tooltip', false);
//        $(this).tooltip('destroy');
//        $(this).tooltip('disable');
//        $('.register').prop('disabled', false);
//    }
//
//});
//
//
//var form = $("form");
//form.validate();
//console.log(form.valid());

