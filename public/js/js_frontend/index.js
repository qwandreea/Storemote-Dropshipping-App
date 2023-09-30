function openform() {
    document.getElementById("mychat").style.display = "block";
}

function closeform() {
    document.getElementById("mychat").style.display = "none";
}

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 44.439663,
            lng: 26.096306
        },
        zoom: 14,
        styles: [{
            elementType: 'geometry',
            stylers: [{
                color: '#242f3e'
            }]
        },
            {
                elementType: 'labels.text.stroke',
                stylers: [{
                    color: '#242f3e'
                }]
            },
            {
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#746855'
                }]
            },
            {
                featureType: 'administrative.locality',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#d59563'
                }]
            },
            {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#d59563'
                }]
            },
            {
                featureType: 'poi.park',
                elementType: 'geometry',
                stylers: [{
                    color: '#263c3f'
                }]
            },
            {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#6b9a76'
                }]
            },
            {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{
                    color: '#38414e'
                }]
            },
            {
                featureType: 'road',
                elementType: 'geometry.stroke',
                stylers: [{
                    color: '#212a37'
                }]
            },
            {
                featureType: 'road',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#9ca5b3'
                }]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{
                    color: '#746855'
                }]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{
                    color: '#1f2835'
                }]
            },
            {
                featureType: 'road.highway',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#f3d19c'
                }]
            },
            {
                featureType: 'transit',
                elementType: 'geometry',
                stylers: [{
                    color: '#2f3948'
                }]
            },
            {
                featureType: 'transit.station',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#d59563'
                }]
            },
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{
                    color: '#17263c'
                }]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{
                    color: '#515c6d'
                }]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.stroke',
                stylers: [{
                    color: '#17263c'
                }]
            }
        ]
    });
}

function displayProfileLogin() {
    var buttons = document.getElementsByClassName('button-authenticate');
    for (i = 0; i < buttons.length; i++) {
        buttons[i].style.display = 'none';
    }

    var profile = document.getElementsByClassName('profile-stuf');
    for (i = 0; i < profile.length; i++) {
        profile[i].style.display = 'block';
    }

    let form = document.getElementsByClassName('modal-login');
    for (i = 0; i < form.length; i++) {
        form[i].style.display = 'none';
    }
}

jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
jQuery('.quantity').each(function () {
    var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

    btnUp.click(function () {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });

    btnDown.click(function () {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });

});

$(document).ready(function () {

    $('#formSolicita').validate({
        rules: {
            test: {
                required: true
            },
            dataInceput: {
                required: true
            },
            dataSfarsit: {
                required: true
            },
            cantitate: {
                required: true
            }
        },
        messages: {
            test: {
                required: 'Campul trebuie completat'
            },
            dataInceput: {
                required: 'Introduceti data'
            },
            dataSfarsit: {
                required: 'Introduceti data'
            },
            cantitate: {
                required: 'Selectati cantitatea'
            }
        },
        highlight: function (element) {
            $(element).closest('.md-form')
                .removeClass('success').addClass('error');
        },
        success: function (element) {
            $(element).addClass('valid').closest('.md-form')
                .removeClass('error').addClass('success');
        }
    });


    let multi = document.querySelectorAll('#select-tip');
    let result = [];
    $.each(multi, function (index, item) {
        result.push($(item).attr('data'));
    });

    document.querySelectorAll('#test').forEach(function (item, index) {
        document.querySelectorAll('#formModal' + result[index]).forEach(function (item) {
            item.addEventListener('change', event => {
                var idProd = $('#id' + result[index]).val();
                var dataInceput = $('#dataInceput' + result[index]).val();
                var dataSfarsit = $('#dataSfarsit' + result[index]).val();
                var tip = $('.select-tip' + result[index]).val();
                var cantitate = $('#cantitate' + result[index]).val();
                jQuery.ajax({
                    type: 'GET',
                    url: '/pret-produs-inchiriere/' + idProd,
                    data: {
                        "idProd": idProd,
                        "tip": tip,
                        "dataInceput": dataInceput,
                        "dataSfarsit": dataSfarsit,
                        "cantitate": cantitate,
                    },
                    success: function (resp) {
                        $('#total' + idProd).html('TOTAL ' + `<strong style="color: green;">` + resp + `</strong>` + ' LEI');
                        var obj = $.parseJSON(resp);
                        $('#subtotal' + idProd).val(obj);
                    }, error: function () {
                        console.log("Fail calculate total rent in modal");
                    }
                });
            });
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $("tr.gradeX #modifica-adresa").click(function () {
        var adr_id = $(this).attr('data');
        $("#adresa" + adr_id).removeAttr("disabled");
        $(this).css("display", 'none');
        $('#salveaza-adresa' + adr_id).show();
        var user = $('#idUser' + adr_id).val();

        $('#salveaza-adresa' + adr_id).click(function () {
            var newAddr = $("#adresa" + adr_id).val();
            jQuery.ajax({
                type: 'POST',
                url: '/modifica-adresa',
                data: {
                    "id": adr_id,
                    "value": newAddr,
                },
                success: function (resp) {
                    $("#adresa" + adr_id).attr("disabled", true);
                    // $("#adresa"+adr_id).val(resp);
                    $('#salveaza-adresa' + adr_id).css('display', 'none');
                    $('.modifica-adresa' + adr_id).show();
                    window.location.href = "/adresele-mele/" + user;
                }, error: function () {
                    console.log("Fail calculate total rent in modal");
                }
            });
        });
    });

    $("tr.gradeX #sterge-adresa").click(function () {
        var adr_id = $(this).attr('data');
        var user = $('#idUser' + adr_id).val();
        jQuery.ajax({
            type: 'POST',
            url: '/sterge-adresa',
            data: {
                "id": adr_id
            },
            success: function (resp) {
                window.location.href = "/adresele-mele/" + user;
            }, error: function () {
                console.log("Fail calculate total rent in modal");
            }
        });
    });


    var current_fs, next_fs, previous_fs;
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function () {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        next_fs.show();
        current_fs.animate({opacity: 0}, {
            step: function (now) {
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            },
            duration: 500
        });
        setProgressBar(++current);
    });

    $(".previous").click(function () {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        previous_fs.show();

        current_fs.animate({opacity: 0}, {
            step: function (now) {

                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
            .css("width", percent + "%")
    }

    $(".submit").click(function () {
        return false;
    })

    $("#adresa-existenta").change(function () {
        var adrId = $(this).val();
        jQuery.ajax({
            type: 'GET',
            url: '/adresa/' + adrId,
            data: {
                "id": adrId
            },
            success: function (resp) {
                $('#adresafield').val(resp['adresa']);
                $('#adresafield').prop("readonly", true);
                $('#codfield').val(resp['cod_postal']);
                $('#codfield').prop("readonly", true);
                $('#orasfield').append('<option selected>' + resp['oras'] + '</option>');
                $('.oras option:not(:selected)').attr('disabled', true);
                $('#regiunefield').append('<option selected>' + resp['regiune'] + '</option>');
                $('.regiune option:not(:selected)').attr('disabled', true);
            }, error: function () {
                console.log("Fail obtinere adresa existenta");
            }
        });
    });

    $("#orasfield").change(function () {
        var denumireOras = $(this).val();
        jQuery.ajax({
            type: 'GET',
            url: '/oras/' + denumireOras + '/regiuni',
            data: {
                "denumire": denumireOras
            },
            success: function (resp) {
                var select = $('select[name=regiune]');
                $.each(resp, function (i, resp) {
                    select.append($('<option/>', {text: resp['name']}));
                });
            }, error: function () {
                console.log("Fail obtinere adresa existenta");
            }
        });
    });

    $('#nextAdresa').click(function () {
        var numeOras = $('#orasfield').val();
        var idCos = $('#idCos').val();
        jQuery.ajax({
            type: 'GET',
            url: '/oras/taxa',
            data: {
                "numeOras": numeOras,
                "idCos": idCos
            },
            dataType: "json",
            success: function (resp) {
                var val = Math.round(resp['valoareCos'] * 100) / 100
                $('#valoareCos').html('<strong>' + val + '</strong>' + ' RON');
                $('#comanda-subtotal').val(resp['valoareCos']);
                $('#valoareTaxa').html('<strong>' + resp['taxa'] + '</strong>' + ' RON');
                $('#comanda-taxa').val(resp['taxa']);
                $('#totalPlata').html('<strong style="color:green;">' + resp['totalCos'] + '</strong>' + ' RON');
                $('#comanda-total').val(resp['totalCos']);
                $('#valoare-cos-initiala').val(resp['valoareCos']);
                $('#valoare-total-cos').val(resp['totalCos']);
            }, error: function () {
                console.log("Fail obtinere taxa comanda");
            }
        });
    });


    $('#cod-cupon').change(function () {
            var valoareCos = $('#valoare-cos-initiala').val();
            var cod_cupon = $(this).val();
            var total = $('#valoare-total-cos').val();
        jQuery.ajax({
            type: 'GET',
            url: '/aplica-cupon',
            data: {
                "valoareCos": valoareCos,
                "cod-cupon": cod_cupon,
            },
            success: function (resp) {
               if(resp==='neidentificat'){
                   $('#cod-cupon-err').removeAttr('hidden');
               }else{
                   var total_modificat = total-resp['sumaScazuta'];
                   $('#cod-cupon-err').hide();
                   $('#cod-cupon-success').removeAttr('hidden');
                   $('#cod-cupon').prop('disabled',true);
                   $('#valoareCos').html('<strong>' + resp['valoare'] + '</strong>' + ' RON');
                   $('#comanda-subtotal').val(resp['valoare']);
                   $('#totalPlata').html('<strong style="color:green;">' + total_modificat + '</strong>' + ' RON');
                   $('#comanda-total').val(total_modificat);
                   $('#codcupon').val(resp['cupon']);
               }
            }, error: function () {
                console.log("Fail obtinere cod cupon");
            }
        });
    });

    $('#termeni-conditii').click(function () {
        $('#trimite-submit').removeAttr("disabled");
    });

    $('#button-comenteaza').click(function () {
        var idParinte = $('#idParinte').val();
        var userId = $('#userId').val();
        var text = $('#textareacomment').val();
        jQuery.ajax({
            type: 'POST',
            url: '/forum/intrebare/' + idParinte + '/adauga-raspuns',
            data: {
                "idParinte": idParinte,
                "userId": userId,
                "continut": text
            },
            success: function (resp) {
                window.location.href = "/forum/intrebare/" + idParinte;
            }, error: function () {
                console.log("Fail adaugare comentariu");
            }
        });
    });
});

