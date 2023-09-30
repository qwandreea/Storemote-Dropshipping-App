<?php

Route::match(['get','post'],'/admin','AdminController@login');

Auth::routes();

Route::get('/','IndexController@index');
Route::any('/search','IndexController@search')->name('search');

Route::get('/produse','IndexController@paginaProduse');

Route::get('/produse/{urlcat}','IndexController@categoriiFilter');


Route::get('/produs/{id}','ProduseController@detaliiProdus');
Route::get('/produse/subcategorie/{urlsubcat}','IndexController@subcategoriiFilter');

Route::match(['get','post'], '/adauga-in-cos' , 'CosCumparaturiController@adaugaInCos');
Route::match(['get','post'], '/cos-de-cumparaturi' , 'CosCumparaturiController@cosDeCumparaturi');
Route::get('/cos-de-cumparaturi/sterge-produs/{id}' , 'CosCumparaturiController@stergeProdusCos' );
Route::get('/cos-de-cumparaturi/sterge-produs-inchiriat/{id}' , 'CosCumparaturiController@stergeProdusInchiriatCos' );
Route::get('/cos-de-cumparaturi/plus-cantitate/{id}' , 'CosCumparaturiController@adaugaCantitate');
Route::get('/cos-de-cumparaturi/minus-cantitate/{id}' , 'CosCumparaturiController@stergeCantitate');

Route::get('/furnizor/produse/{id}','FurnizoriController@vizualizeazaProduseFurnizor');

Route::match(['get','post'],'/trimite-intrebare-forum','IndexController@intrebareForum')->name('forum');
Route::get('/forum','IndexController@viewForum');
Route::get('/forum/intrebare/{id}','IndexController@raspunsuriForum');
Route::match(['get','post'],'/forum/intrebare/{id}/adauga-raspuns','IndexController@adaugaRaspuns');

Route::group(['middleware' => 'auth'],function (){
    Route::get('/profil','ProfilController@profilUtilizator');
    Route::get('/adresa/{id}','ProfilController@getAdresa');
    Route::get('/recenziile-mele/{id}','ProfilController@recenzii');
    Route::get('/adresele-mele/{id}','ProfilController@adrese');
    Route::get('/solicitarile-mele/{id}','ProfilController@solicitari');
    Route::get('/comenzile-mele/{id}','ProfilController@comenzi');
    Route::get('/comenzile-mele/comanda/{id}/factura','ProfilController@descarcaFactura');
    Route::get('/cupoanele-mele/{id}','ProfilController@cupoane');

    Route::match(['get','post'],'/anuleaza-solicitare/{id}','ProduseInchiriateController@anuleazaSolicitare');
    Route::match(['get','post'],'/sterge-adresa','ProfilController@sterge');
    Route::match(['get','post'],'/modifica-adresa','ProfilController@modifica');
    Route::match(['get','post'],'/profil/{id}','ProfilController@editeazaProfil');

    Route::match(['get','post'], '/adauga-recenzie/{id}', 'ProfilController@adaugaRecenzie');
    Route::match(['get','post'],'/solicita-inchiriere','ProduseInchiriateController@solicita');
    Route::get('/sectiune-inchiriere','IndexController@paginaProduseInchiriere');
    Route::get('/pret-produs-inchiriere/{id}','ProduseController@pretProdusInchiriere');

    Route::match(['get','post'],'/produs-inchiriere/adauga-la-comanda/{id}','ProduseInchiriateController@adaugaInchiriereComanda');
    Route::get('/aplica-cupon','ComenziController@aplicaCupon');
    Route::match(['get','post'],'/cos-cumparaturi/{id}/checkout-comanda','ComenziController@inregistrareComanda');
    Route::get('/paypal','ComenziController@paypal');
    Route::post('paypal', 'PaymentController@payWithpaypal');
    Route::get('status', 'PaymentController@getPaymentStatus')->name('status');
});
Route::get('/oras/taxa','ComenziController@getTaxaByAdresa');
Route::get('/oras/{denumire}/regiuni','ProfilController@getRegiuni');
Route::get('/cos-cumparaturi/{id}/checkout-page','ComenziController@checkout')->name('checkout');


//    Doar administratorul are acces
Route::group(['middleware' => 'admin'],function (){
//    Functii cont administrator
    Route::get('/admin/tablou','AdminController@tablou');
    Route::get('/admin/setari','AdminController@setari');
    Route::get('/admin/verificare_parola','AdminController@verificareParola');
    Route::match(['get','post'],'/admin/schimba-parola', 'AdminController@schimbaParola');

//    Functii gestiune categorii
    Route::match(['get','post'],'/admin/adauga-categorie','CategoriiController@adaugaCategorie');
    Route::match(['get','post'],'/admin/editeaza-categorie/{id}','CategoriiController@editeazaCategorie');
    Route::match(['get','post'],'/admin/sterge-categorie/{id}','CategoriiController@stergeCategorie');
    Route::get('/admin/vizualizeaza-categorii','CategoriiController@vizualizeazaCategorii');

//    Functii gestiune produse
    Route::match(['get','post'],'/admin/adauga-produs','ProduseController@adaugaProdus');
    Route::get('/admin/vizualizeaza-produse','ProduseController@vizualizeazaProduse');
    Route::match(['get','post'],'/admin/vizualizeaza-produse/enable','ProduseController@setDeInchiriat');
    Route::match(['get','post'],'/admin/editeaza-produs/{id}','ProduseController@editeazaProdus');
    Route::get('/admin/sterge-produs/{id}','ProduseController@stergeProdus');

//     Functii gestiune furnizori
    Route::match(['get','post'],'/admin/adauga-furnizor','FurnizoriController@adaugaFurnizor');
    Route::get('/admin/vizualizeaza-furnizori','FurnizoriController@vizualizeazaFurnizori');
    Route::match(['get','post'],'/admin/editeaza-furnizor/{id}','FurnizoriController@editeazaFurnizor');
    Route::get('/admin/sterge-furnizor/{id}','FurnizoriController@stergeFurnizor');

//    Functii gestiune specificatii
    Route::match(['get','post'],'/admin/produs/adauga-specificatii/{id}','ProduseController@adaugaSpecificatii');
    Route::get('/admin/produs/sterge-specificatii/{id}','ProduseController@stergeSpecificatii');
    Route::match(['get','post'],'/admin/produs/editeaza-specificatii/{id}','ProduseController@editeazaSpecificatii');

//    Functii CMS
    Route::get('/admin/promotii','AdminController@vizualizarePromotii');
    Route::match(['get','post'],'/admin/informatii-contact','AdminController@modificaInfoContact');
    Route::match(['get','post'],'/admin/adauga-promotie','AdminController@adaugaPromotie');
    Route::match(['get','post'],'/admin/editeaza-promotie/{id}','AdminController@editeazaPromotie');
    Route::match(['get','post'],'/admin/sterge-promotie/{id}','AdminController@stergePromotie');

//    Functii solicitari & comenzi
    Route::get('/admin/solicitari-inchiriere','AdminController@vizualizareSolicitari');
    Route::match(['get','post'],'/admin/modifica-status-inchiriere','AdminController@schimbaStatusSolicitare');
    Route::get('/admin/comenzi/lista-comenzi','AdminController@listaComenzi');
    Route::get('/admin/comanda/{id}','AdminController@detaliiComanda');
    Route::post('/admin/comanda/{id}/schimba-status','AdminController@schimbaStatus');

//    Functii comanda
    Route::get('/admin/vizualizare-taxe','AdminController@vizualizareTaxe');
    Route::match(['get','post'],'/admin/modifica-taxa','AdminController@modificaTaxa');

//    Functii forum
    Route::get('/admin/forum-clienti','AdminController@intrebariForum');
    Route::match(['get','post'],'/admin/raspunde-intrebare/{id}','AdminController@raspunsForum');

    Route::post('/admin/import-csv/produse','AdminController@importProduse');
});

Route::get('/logout','AdminController@logout');



