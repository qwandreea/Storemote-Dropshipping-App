$(document).ready(function(){

    $('#parola').keyup(function () {
        var parolaActuala=$('#parola').val();
        $.ajax({
            type:'get',
            url: '/admin/verificare_parola',
            data:{parola:parolaActuala},  //trimiterea mai multor campuri de date
            success:function (response) {
                   if(response==="false"){
                       $("#alertResponse").html("<font color='red' face='verdana'>Parola nu corespunde</font>");
                   }else if (response==="true"){
                       $("#alertResponse").html("<font color='green'>Parola este corecta</font>");
                   }
            },
            error:function () {
                alert("Cerere incorecta");
            }
        });
    });

	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();

	$('select').select2();

	$("#password_validate").validate({
		rules:{
            parola:{
                required: true,
                minlength:6,
                maxlength:255
            },
            parola_noua:{
				required: true,
				minlength:6,
				maxlength:255
			},
            parola_noua_confirm:{
				required:true,
				minlength:6,
				maxlength:255,
				equalTo:"#parola_noua"
			}
		},
        messages:{
            parola:{
                required: 'Completati campul',
                minlength: 'Parola trebuie sa contina mimim 6 caractere'
            },
            parola_noua: {
                required: 'Completati campul',
                minlength: 'Parola trebuie sa contina mimim 6 caractere'
            },
            parola_noua_confirm: {
                required: 'Completati campul',
                minlength: 'Parola trebuie sa contina mimim 6 caractere',
                equalTo: 'Cele 2 parole nu corespund'
            }
        },
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

    $("#adauga-categorie").validate({
        rules:{
            denumire:{
                required: true,
                maxlength:50
            },
            descriere:{
                required:true,
            },
            adr_url:{
                required:true,
                maxlength:200
            }
        }, messages:{
            denumire:{
                required: 'Completati campul',
                maxlength: 'Denumirea are un maxim de 50 de caractere'
            },
            descriere: {
                required: 'Completati campul',
            },
            adr_url: {
                required: 'Completati campul',
                maxlength: 'Adresa are un maxim de 200 de caractere'
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $("#editeaza-categorie").validate({
        rules:{
            denumire:{
                required: true,
                maxlength:50
            },
            descriere:{
                required:true,
                maxlength:150
            },
            adr_url:{
                required:true,
                maxlength:200
            }
        }, messages:{
            denumire:{
                required: 'Completati campul',
                maxlength: 'Denumirea are un maxim de 50 de caractere'
            },
            descriere: {
                required: 'Completati campul',
                maxlength: 'Descrierea are un maxim de 150 de caractere'
            },
            adr_url: {
                required: 'Completati campul',
                maxlength: 'Adresa are un maxim de 200 de caractere'
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $("tr.gradeX #de_inchiriat").change(function () {
        var prod_id = $(this).attr('relId');
        jQuery.ajax({
            type:'POST',
            url:'/admin/vizualizeaza-produse/enable/',
            data:{prod_id:prod_id},
            success:function(resp) {
                $("#responsecheckbox").css("visibility","visible");
                var diff = 1000,
                    totalTime = 0,
                    maxTime = 1000*60*60*10,
                    interval = setInterval(function() {
                        $("#responsecheckbox").css("visibility","hidden");
                        totalTime += diff;
                        if (totalTime >= maxTime) {
                            clearInterval(interval);
                        }
                    },diff);
            },error:function () {
                console.log("Fail enable/disable inchiriere");
            }
        })
    });

    $("tr.gradeX #status").change(function () {
        var prod_id = $(this).attr('relId');
        var status = $(this).val();

        jQuery.ajax({
            type:'POST',
            url:'/admin/modifica-status-inchiriere',
            data:{id:prod_id, sts:status},
            success:function(resp) {
               window.location.href = "/admin/solicitari-inchiriere";
            },error:function () {
                console.log("Fail enable/disable inchiriere");
            }
        })
    });

    $("tr.gradeX #taxa").change(function () {
        var id = $(this).attr('relId');
        var value = $(this).val();

        jQuery.ajax({
            type:'POST',
            url:'/admin/modifica-taxa',
            data:{id:id, taxa:value},
            success:function(resp) {
                if(resp=='updated') alert('updated');
                window.location.href = "/admin/vizualizare-taxe";
            },error:function () {
                console.log("Fail modificare taxa");
            }
        })
    });

    $('#filter_comenzi').change(function () {
       var by = $(this).val();
       var query = $(this).find(':selected').attr('attr');
      jQuery.ajax({
          type:'GET',
          url: '/admin/comenzi/lista-comenzi',
          data: { filtru:query , by:by},
          success:function(resp) {
              var content = '';
            resp.forEach(function (item, index) {
                content += '<tr class="gradeX">';
                content+='<td id="nrComanda">' + resp[index]['nr_comanda'] + '</td>';
                content+='<td id="status">' + resp[index]['status'] + '</td>';
                content+='<td id="data">' + resp[index]['created_at'] + '</td>';
                content+='<td id="plata">' + resp[index]['modalitate_plata'] + '</td>';
                content+='<td id="total">' + resp[index]['total'] + ' RON' + '</td>';
                var url = '/admin/comanda/'+resp[index]['id'];
                content+='<td><a class="btn btn-primary" href='+url+'>Detalii</a></td>';
                content +='</tr>';
            });
              $('#comenzi-table tbody').html(content);
          },error:function () {
              console.log("Fail filter comenzi");
          }
      });
    });

    $('#status-comanda').change(function () {
        var stare = $(this).val();
        var idComanda = $('#idComanda').val();
        jQuery.ajax({
            type:'POST',
            url: '/admin/comanda/'+idComanda+'/schimba-status',
            data: { stare:stare },
            success:function(resp) {
                if(resp === 'updated'){
                    window.location.href="/admin/comanda/"+idComanda;
                }
            },error:function () {
                console.log("Fail filter comenzi");
            }
        });
    })

    $(document).on('click','.stergeCategorie',function (event) {
        var idCat=$(this).attr('relId');
        var stergeCat=$(this).attr('relS');
        Swal.fire({
            title: 'Sunteti sigur ca doriti sa stergeti?',
            text: 'Toate produsele asociate vor fi sterse',
            showCancelButton: true,
            confirmButtonText: 'Confirma',
            cancelButtonText: 'Inchide'
        }).then((result)=>{
            if(result.value) {
                window.location.href="/admin/"+stergeCat+"/"+idCat;
            }
        });
    });

    $(document).on('click','.stergeSpecificatii',function (event) {
        var idSpec=$(this).attr('relId');
        var stergeSpec=$(this).attr('relS');
        Swal.fire({
            title: 'Sunteti sigur ca doriti sa stergeti?',
            showCancelButton: true,
            confirmButtonText: 'Confirma',
            cancelButtonText: 'Inchide'
        }).then((result)=>{
            if(result.value) {
                window.location.href="/admin/"+stergeSpec+"/"+idSpec;
            }
        });
    });


    $(document).on('click','.stergePromotie',function (event) {
        var idProm=$(this).attr('relId');
        var stergeProm=$(this).attr('relS');
        Swal.fire({
            title: 'Sunteti sigur ca doriti sa stergeti?',
            showCancelButton: true,
            confirmButtonText: 'Confirma',
            cancelButtonText: 'Inchide'
        }).then((result)=>{
            if(result.value) {
                window.location.href="/admin/"+stergeProm+"/"+idProm;
            }
        });
    });

    $(document).on('click','.stergeFurnizor',function (event) {
        var idF=$(this).attr('relId');
        var stergeF=$(this).attr('relS');
        Swal.fire({
            title: 'Sunteti sigur ca doriti sa stergeti?',
            text: 'Toate produsele asociate vor fi sterse',
            showCancelButton: true,
            confirmButtonText: 'Confirma',
            cancelButtonText: 'Inchide'
        }).then((result)=>{
            if(result.value) {
                window.location.href="/admin/"+stergeF+"/"+idF;
            }
        });
    });

    $(document).on('click','.stergeProdus',function (event) {
        var idP=$(this).attr('relId');
        var stergeP=$(this).attr('relS');
        Swal.fire({
            title: 'Sunteti sigur ca doriti sa stergeti?',
            text: 'Toate specificatiile vor fi sterse',
            showCancelButton: true,
            confirmButtonText: 'Confirma',
            cancelButtonText: 'Inchide'
        }).then((result)=>{
            if(result.value) {
                window.location.href="/admin/"+stergeP+"/"+idP;
            }
        });
    });

    $("#adauga-produs").validate({
        rules:{
            categorie_produs:{
                required:true
            },
            cod_produs:{
                maxlength:10
            },
            denumire_produs:{
                required:true,
                maxlength:30
            },
            descriere_produs:{
                required:true,
            },
            pret_produs:{
                required:true,
                number:true
            },
            pret_ora_produs:{
                number:true
            },
            pret_zi_produs:{
                number:true
            },
            imagine_produs:{
                accept: "jpg|jpeg|png",
                required: true
            }
        }, messages:{
            cod_produs:{
                maxlength : 'Codul are un maxim de 10 caractere'
            },
            denumire_produs:{
                required: 'Completati campul',
                maxlength : 'Denumirea are un maxim de 30 caractere'
            },
            descriere_produs:{
                required: 'Completati campul',
            },
            pret_produs:{
                required: 'Completati campul',
                number: 'Campul trebuie completat cu un numar valid'
            },
            pret_ora_produs:{
                number: 'Campul trebuie completat cu un numar valid'
            },
            pret_zi_produs:{
                number: 'Campul trebuie completat cu un numar valid'
            },
            imagine_produs:{
                required: 'Incarcati o imagine',
                accept: 'Se accepta doar fisiere jpg, jpeg si png'
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $("#editeaza-produs").validate({
        rules:{
            categorie_produs:{
                required:true
            },
            cod_produs:{
                maxlength:10
            },
            denumire_produs:{
                required:true,
                maxlength:30
            },
            descriere_produs:{
                required:true,
                maxlength:255
            },
            culoare_produs:{
                maxlength:10
            },
            greutate_produs:{
                number:true
            },
            pret_produs:{
                required:true,
                number:true
            },
            stoc_produs:{
                number:true
            },
            pret_ora_produs:{
                number:true
            },
            pret_zi_produs:{
                number:true
            }
        }, messages:{
            cod_produs:{
                maxlength : 'Codul are un maxim de 10 caractere'
            },
            denumire_produs:{
                required: 'Completati campul',
                maxlength : 'Denumirea are un maxim de 30 caractere'
            },
            descriere_produs:{
                required: 'Completati campul',
                maxlength : 'Descrierea are un maxim de 255 de caractere'
            },
            culoare_produs: {
                maxlength : 'Culoarea are un maxim de 10 caractere'
            },
            greutate_produs:{
                number: 'Campul trebuie completat cu un numar valid'
            },
            pret_produs:{
                required: 'Completati campul',
                number: 'Campul trebuie completat cu un numar valid'
            },
            stoc_produs:{
                number: 'Campul trebuie completat cu un numar valid'
            },
            pret_ora_produs:{
                number: 'Campul trebuie completat cu un numar valid'
            },
            pret_zi_produs:{
                number: 'Campul trebuie completat cu un numar valid'
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $.validator.addMethod( "phone", function( phone_number, element ) {
        phone_number = phone_number.replace( /\s+/g, "" );
        return this.optional( element ) || phone_number.length > 9 &&
            phone_number.match( /^(\+4|)?(07[0-8]{1}[0-9]{1}|02[0-9]{2}|03[0-9]{2}){1}?(\s|\.|\-)?([0-9]{3}(\s|\.|\-|)){2}$/ );
    }, "Introduceti un numar de telefon valid" );

    $("#adauga-furnizor").validate({
        rules:{
            denumire: {
                required: true,
                maxlength: 30
            },
            contact:{
                required:true,
                maxlength:20
            },
            email:{
                required:true,
                email:true
            },
            telefon:{
                phone:true,
                required:true,
                minlength:10,
                maxlength:10
            },
            adresa:{
                maxlength:30
            },
            oras:{
                maxlength:20
            }
        }, messages:{
            denumire: {
                required: 'Completati campul',
                maxlength: 'Denumirea are un maxim de 30 de caractere'
            },
            contact: {
                required: 'Completati campul',
                maxlength: 'Persoana de contact are un maxim de 200 de caractere'
            },
            email: {
                required: 'Completati campul',
                email: 'Adresa de email trebuie sa respecte formatul nume@domeniu.com'
            },
            telefon:{
                required: 'Completati campul',
                minlength: 'Minim 10 cifre',
                maxlength: 'Maxim 10 cifre',
                regex: 'Formatul numarului de telefon este invalid'
            },
            adresa:{
                maxlength: 'Adresa are un maxim de 30 de caractere'
            },
            oras:{
                maxlength: 'Orasul are un maxim de 20 de caractere'
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $('#adauga-produs-specificatii').validate({
        rules : {
            'culoare[]': {
                required: true,
                maxlength:255
            },
            'material[]':{
                required: true,
                maxlength:255
            },
            'stoc[]':{
                number:true,
                maxlength:11
            },
            'greutate[]':{
                required:true,
                number:true,
                maxlength:8
            },
            'masura[]':{
                required:true,
                maxlength:255
            },
            'lungime[]':{
                number:true
            },
            'latime[]':{
                number:true
            },
            'inaltime[]':{
                number:true
            },
            'unitate[]':{
                maxlength:255
            }
        },
        messages:{
            'culoare[]':{
                required:'Completati acest camp'
            },
            'material[]':{
                required:'Completati acest camp'
            },
            'stoc[]':{
                number:'Doar numere'
            },
            'greutate[]':{
                required:'Completati acest camp',
                number:'Doar numere'
            },
            'masura[]':{
                required:'Completati acest camp'
            },
            'lungime[]':{
                number:'Doar numere'
            },
            'latime[]':{
                number:'Doar numere'
            },
            'inaltime[]':{
                number:'Doar numere'
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $("#informatii-contact").validate({
        rules:{
            adresa: {
                required: true,
                maxlength: 255
            },
            email:{
                required:true,
                maxlength: 255,
                email : true
            },
            telefon:{
                required:true,
                phone:true
            },
            skype:{
                required:true,
                maxlength:255
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $("#adauga-promotie").validate({
        rules:{
            imagine: {
                required: true,
                maxlength: 255,
                accept: "jpg|jpeg|png"
            },
            titlu:{
                required: true,
                maxlength: 255
            },
            mesaj:{
                required: true,
                maxlength: 255
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });
});
$(document).ready(function () {
    var nrMaxim = 8;
    var buttonAdd = $('.adauga');
    var container = $('.container');
    var spatiu='<hr>';
    var rand = `<div>
            <input type="text" name="culoare[]"  id="culoare" placeholder="culoare" value="" required/>
            <input type="text" name="material[]"  id="material" placeholder="material" value="" required/>
            <input type="text" name="stoc[]"  id="stoc" placeholder="stoc" value=""/>
            <input type="text" name="greutate[]"  id="greutate" placeholder="greutate" value="" required/>
            <input type="text" name="masura[]"  id="masura" placeholder="unitate de masura greutate" value="" required/>
            <input type="text" name="lungime[]"  id="lungime" placeholder="lungime" value=""/>
            <input type="text" name="latime[]"  id="latime" placeholder="latime" value=""/>
            <input type="text" name="inaltime[]"  id="inaltime" placeholder="inaltime" value=""/>
            <input type="text" name="unitate[]"  id="unitate" placeholder="unitate de masura" value=""/>
            <a href="javascript:bulkAdd;" class="sterge"><img id="imgSterge"/></a></div>`;
    var count = 1;
    $(buttonAdd).click(function () {
        if(count<nrMaxim){
            count++;
            $(container).append(spatiu);
            $(container).append(rand);
        }
    });
    $(container).on('click','.sterge',function (event) {
        event.preventDefault();
        $('hr:last').remove();
        $(this).parent('div').remove();
        count--;
    });
});




