# Todo
* Path pour la sous-hiérarchie (dans le titre de la page/ bread)
* Créations d'une page => fermeture du popup
* Création de page => redirect
* Tinymce: add page links
* Liste des pages inline
* File modal XL
* SELECT * FROM `texts` WHERE content_en LIKE '%../%'
* Redirect when page name is edited
* Cron pour http://localhost/edsa-work/smag2/public/Congr%C3%A8s--Conf%C3%A9rences--Cours--Ateliers?import
* Message erreur du login invalide
* Pages
** Adhésion
*** Existing email error
** Calendrier
*** full calendar
*** date de fin
** Mode d'emploi Mettre à jour
** Pv réunon du comité: check links
** Boite à suggestion
* comité visible par comité
* mailing list
* users counter
* backups
* [RTE]current format not display in toolbar

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
