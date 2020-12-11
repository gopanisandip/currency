php artisan migrate

command for store curruency data : php artisan ReadCurrencyData

command for add user : php artisan AddUsers {username} {password}

seeder php artisan db:seed --class=CurrencySeeder

List Api :

url: /currency
method: get

parameters: page
            page_size

History api :

url: /history
method: get

parameters: page
            page_size
            date_from
            date_to
            id | required

