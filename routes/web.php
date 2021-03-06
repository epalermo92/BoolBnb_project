<?php

Route::get('/', 'homepageController@homeRental')->name('homepage');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/rentals', 'HomeController@showUserRentals')->name('user.rentals');
// Route::get('/rentals/sponsored', 'RentalController@sponsoredRentals')->name('rental.sponsored');

//Rental
Route::get('/rentals/new', 'RentalController@createRental')->name('rental.create')->middleware('auth');;
Route::post('/rentals', 'RentalController@storeRental')->name('rental.store')->middleware('auth');;
Route::get('/rental/edit/{id}', 'RentalController@editRental')->name('edit.rental')->middleware('auth');;
Route::patch('/rental/edit/{id}', 'RentalController@updateRental')->name('update.rental')->middleware('auth');
Route::get('/rental/{id}', 'RentalController@showRental')->name('show.rental');

//Messages
Route::get('/inbox', 'MessagesController@getInbox')->name('printMess')->middleware('auth');
Route::delete('/inbox/{id}', 'MessagesController@destroyMess')->name('destroyMess')->middleware('auth');
Route::post('/sendMessage', 'MessagesController@storeMessage')->name('message.store');
Route::get('/inbox/{id}', 'MessagesController@getMessageById')->name('message.get')->middleware('auth');

//sponsor and payment
Route::get('/payment/sponsor/{id}', 'PaymentsController@selectSponsor')->name('payment.sponsor')->middleware('auth');;
Route::post('/payment/process/{id}', 'PaymentsController@process')->name('payment.process')->middleware('auth');;

// Search
Route::get('/search', 'SearchController@searchIndex')->name('search.index');
Route::get('/search/action', 'SearchController@action')->name('search.action');

//Statistics
Route::get('/rental/statistics/{id}','RentalController@showStat')->name('rental.statistics');
