## Projekto įrašymas
- Įsisirašyti Node.js (kartu bus ir npm), PHP, Composer ir XAMPP (galima ir kitą vietoj XAMPP), bet paleidimas bus aprašomas su XAMPP
- Pasisiųsti projekto failus
- Nukopijuoti ".env.example" failą į lokalų failą ".env"
- Projekto direktorijoje paleisti komandą "composer install", kad būtų įrašyti visi composer paketai
- Projekto direktorijoje paleisti komandą "npm install", kad būtų įrašyti visi npm paketai
- Projekto direktorijoje paleisti komandą "php artisan key:generate"
- Pasileisti XAMPP Control Panel ir įjungti "Apache" ir "MySQL"
- Nuėjus į "http://localhost/phpmyadmin" sukurti naują DB pavadinimu "nuotrauku_db" ir nustatyti "utf8_lithuanian_ci"
- Projekto direktorijoje paleisti komandą "php artisan migrate", kad būtų sukurtos visos lentelės lokalioje duomenų bazėje
- "storage/app/public" direktorijoje sukurti "images" direktoriją, kuri būtų pasiekiama per "storage/app/public/images" (bus reikalinga lokaliam nuotraukų saugojimui)
- Kad būtų galima pasiekti nuotraukas, įvykdyti komandą "php artisan storage:link", kad būtų sukurtas simbolinis susiejimas su "storage/app/public" direktorija ir "public" direktorija

## Projekto paleidimas
- Paleisti XAMPP Control Panel bent "MySQL", o jei norima naudoti ir phpmyadmin, tada paleisti ir "Apache" serverį
- Projekto direktorijoje paleisti komandą "npm run watch", kad būtų kompiliuojami stiliai po kiekvieno .css failo išsaugojimo. (jei sukuriami nauji css failai jau veikiant npm run watch, komandą reikia paleisti iš naujo, kad pamatytų naujus failus ir juos pradėtų kompiliuoti).
- Projekto direktorijoje paleisti komandą "php artisan serve", po kurios konsolėje bus parodomas adresas, kuriuo galima pasiekti paleistą projektą.

-- Norint pamatyti kode atliktus pakeitimus, reikia perkrauti puslapį
-- Norint pamatyti visus routes, projekto direktorijoje paleisti komandą "php artisan route:list"

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
