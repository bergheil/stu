<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Return the list of all cards
Route::get('/card', 'CardController@index');

// Return the list of all cards and cards that can beat
Route::get('/card/canbeat', 'CardController@canbeat');

// Return the list of all cards that can beat a given card
Route::get('/card/canbeatcard/{card}', 'CardController@canbeatcard');


// Return the list of all cards and card stronger
Route::get('/card/stronger', 'CardController@stronger');

// Create a new Game given a number of players
Route::get('/game/new/{playersNumber}', 'RoundController@createGame');

// Given a presented card and a set of card calculate the points
Route::get('/game/roundpoint/{cardName}/{cardList}', 'RoundController@getRoundPoint');
