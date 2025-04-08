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

# För att använda styleSheet och javascript mha Encore
npm run build
## Detta skapar en public/build mapp där dina assets mappas
# för att även tömma cache
rm -rf node_modules/.cache
npm run build


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