# Show the routes
bin/console debug:router

# Match a specific route
bin/console router:match /lucky/number

# Clear the cache
bin/console cache:clear

# Show available commands
bin/console

# starta server
php -S localhost:8888 -t public

# Kontroller file och class måste heta exakt likadant
File: LuckyJsonController
Class: LuckyJsonController

# För att kompiliera css till SASS kod
npm run style

# För att använda styleSheet och javascript mha Encore
npm run build

## Detta skapar en public/build mapp där dina assets mappas
# för att även tömma cache
rm -rf node_modules/.cache

# Kör symfonys lokala server istället för php's
symfony server:start

# Add assets, flera alternativ
1. <header class="site-header" style="background-image: url({{ asset('img/background.jpg') }})"> - direkt i style 
2. <a href="{{ asset('img/glider.svg') }}">
        <img src="{{ asset('img/glider.svg') }}" alt="">
    </a>
    <img src="{{ asset('build/images/background.jpg') }}" alt=""> -- pga encore kan vi referera en bild via build, detta för att vi även uppdaterat .configFiles i webpack.config.js


3. <a href="{{ asset('img/glider.svg') }}"> -- sätts som url i css, som refereras av javacsript
        <img src="{{ asset('img/glider.svg') }}" alt="">
    </a>

# För att printa ett objekt, använd print_r

# PHPMD - För att kontrollera messy code, kör
tools/phpmd/vendor/bin/phpmd . text tools/phpmd/phpmd.xml
Felen som inleds med Depricated har med PHP själv att göra och kan ignoreras.

# PHPStan - find bugs before production
tools/phpstan/vendor/bin/phpstan analyse -l 8 src

# PHPDoc - Skapa dokumentation utifrån koden
tools/phpdoc/phpdoc --config=tools/phpdoc/phpdoc.xml

# COMPOSER RUN
Kör 'compser run lint' för att köra phpmd, phpstan och csfix 
Kör 'composer run doc' för att skapa dokumentation utifrån koden

# Debug the dotenv
php bin/console debug:dotenv

# DOCTRINE FLÖDE
Skapa databas: 
    php bin/console doctrine:database:create
Skapa entity (class): 
    php bin/console make:entity
Du får då dina klasser i src/Entity/klass.php
Repository (hanterar klassen mot databasen) i src/Repository

För varje klass får du en motsvarande Repository.
Repository i sig använder sig av 'ManagerRegistry' för att hantera koppling mellan Klass och Databas.
I Routes använder vi därför vår Repository för att interagera med databasen, det vi kan göra med databasen
defineras i vår Klass.

För att commita dina ändringar: 
    php bin/console make:migration
vilket skapar en version under migrations/
Om ok, för att "pusha" dina ändringar kör:
    php bin/console doctrine:migrations:migrate 

Skapa en Controller som använder din entity:
    php bin/console make:controller ProductController

Kolla att route fungerar:
    php bin/console debug:router
    php bin/console debug:router product
    php bin/console router:match /product

Om readonly error på databas:
    chmod 666 var/data.db

# Escape output i dina views
För att escapa output för att undika CSS attacker, använd Twigs funktion |e
Exempel:
    {{ product.getName|e }}
Ovan är alltså motsvarande som htmlentities()/htmlspecialchars()

# PHPmetrics
# Go to the root of your Symfony directory
mkdir --parents tools/phpmetrics
composer require --working-dir=tools/phpmetrics phpmetrics/phpmetrics
tools/phpmetrics/vendor/bin/phpmetrics --version
tools/phpmetrics/vendor/bin/phpmetrics --help
tools/phpmetrics/vendor/bin/phpmetrics --config=tools/phpmetrics/phpmetrics.json

