# Todo
* Path pour la sous-hiérarchie (dans le titre de la page/ bread)
* Liste des pages inline
* File modal XL
* SELECT * FROM `texts` WHERE content_en LIKE '%../%'
* Création de page => redirect
* Redirect when page name is edited
* Créations d'une page => fermeture du popup (+ selection dans dd)
* Cron pour http://localhost/edsa-work/smag2/public/Congr%C3%A8s--Conf%C3%A9rences--Cours--Ateliers?import
* Adhésion: Existing email error
* Calendrier: full calendar
* Boite à suggestion
* mailing list
* users counter
* backups
* Tinymce: add page links
* Tinymce: current format not display in toolbar

#Done
* Forumulaire d'adhésion

# Questions
* Liste des membres

http://sfar.org
http://www.sgar-ssar.ch

# Clear the old boostrap/cache/compiled.php
php artisan clear-compiled

# Recreate boostrap/cache/compiled.php
php artisan optimize

# Migrate any database changes
php artisan migrate

php artisan cache:clear
php artisan config:cache
php artisan route:cache
