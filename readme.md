<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Sample Card Game API

There are N cards in the pack. Each card has a name (for example, King, Mag, Thief,
Dragon, etc). Each card can be stronger than one or more other cards and weaker than
some others at the same time (principle is a bit similar to extended “Rock–paper–scissors”
games), it should be defined in the game settings or in database. If cards don’t beat each
other - they are counted as equal. Cards in the pack are unique. 

## Example  
Thief stronger than Mag, Mag stronger than Dragon and King, King stronger than Thief, etc.
There can be different amount of players. On the game start players get equal amount of
cards from the pack in a random order. On each round every player select a card from his
“hand” to give out and result of the round gets calculated.
Player get 1 point for each card “weaker” than his card and -1 point for each stronger card.

## To Build
You need to build an application component/module/service which can serve described game logic.
Component interface should provide following:  
- Get current configuration in readable text format (or as an object, prepared for output) to see the
list of existing cards and cards they can beat.  
- Get a list of stronger cards for presented card name.  
- Get a list of cards, randomly distributed for presented amount of players, without storing it, so each  
call gives different distribution. Cards are unique, which means each card can be used only once
per game. Each player should have the same amount of cards.  
- Calculate a result of the game round for a list of cards on table. (Input: [King, Thief, Dragon],
Output: [1,-1,0] or [King: 1, Thief: -1, Dragon: 0]) Cards in the set can’t repeat.


## Implementation (Solution)
I have implemented the solution using a local card game named **Stu** invented in a little town named "Montorio al Vomano".  
The backend use a Sqlite database stored in the file database/database.sqlite built using Eloquent ORM Laravel, you can find the schema definition in the file 
stored in database/migrations files.
The database data are initially populated using "Laravel Seed" stored in the database/seeds/DatabaseSeeder.php file.  
The same seed is used to populate the "in memory" database used for the unit test (phpunit).  
The card are stored in a database table "cards" and the relation between on card to another is stored in the table "card_compares" that is used to calculate if a card 
is stronger o weaker than another.



Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
