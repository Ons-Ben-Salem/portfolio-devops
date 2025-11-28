FROM php:8.2-apache

# Copier tous les fichiers du portfolio dans le dossier web d'Apache
COPY . /var/www/html/

# Donner les permissions (optionnel mais propre)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
