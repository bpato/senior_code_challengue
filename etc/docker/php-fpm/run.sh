#!/bin/sh

# Ir al directorio raíz del proyecto
cd /var/www/app

# Esperar a que MySQL esté listo
echo "Esperando a que MySQL esté disponible..."
until php -r "new PDO('mysql:host=application_db;port=3306;dbname=app', 'app', '!ChangeMe!');" > /dev/null 2>&1; do
  sleep 1
done

echo "Base de datos lista. Ejecutando migraciones..."

composer install --no-scripts --no-autoloader --prefer-dist --no-interaction

php /var/www/app/bin/console doctrine:database:create --if-not-exists
php /var/www/app/bin/consoledoctrine:schema:create --no-interaction
php /var/www/app/bin/console doctrine:migrations:migrate --no-interaction
php /var/www/app/bin/console doctrine:fixtures:load --no-interaction

php /var/www/app/bin/console doctrine:database:create --env=test --no-interaction
php /var/www/app/bin/consoledoctrine:schema:create --env=test --no-interaction
php /var/www/app/bin/console doctrine:migrations:migrate --env=test --no-interaction
php /var/www/app/bin/console doctrine:fixtures:load --env=test --no-interaction

set -e
exec php-fpm
