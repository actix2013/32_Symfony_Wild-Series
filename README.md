# 32_Symfony_Wild-Series

__Quest 09:__

Video link : https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST09-2020-05-20_21-39-49.mp4

***
***

__Quest 10:__


Video link : https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST10-2020-05-20_21-39-49.mp4

***
***
__Quest 11:__


Video link : https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST11-2020-05-23_00-52-40.mp4
***
***
__Quest 12:__

- [X] _**Crée plusieurs séries, saisons et épisodes (au moins 4)**_

[Video link CREATE 2 PROGRAM](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST12-01-CREATE.mp4)

[Video link CREATE ONE SEASON AND EPISODES](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST12-02-CREATE.mp4)
> _@1min27 , be back with solution after 2 hours._

***

- [x] _**Affiche toutes les séries / Modifie plusieurs séries (au moins 2)**_

[Video link SHOW-EDIT-RPOGRAM](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST12-03-SHOW-EDIT-RPOGRAM.mp4)

***

- [x] _**Efface plusieurs séries (au moins 2),**_

[Video link DELETTE-RPOGRAM](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST12-04-DEL-PROGRAM.mp4)

***

- [x] _**Affiche toutes les saisons / Modifie plusieurs saisons (au moins 2) / Efface plusieurs saisons (au moins 2)**_


[Video link SHOW MODIFY DELETE SEASON](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST12-05-SHOW-DELETE-MODIFY-SEASON.mp4)

***

- [x] _**Affiche tous les épisodes / Modifie plusieurs épisodes (au moins 2) / Efface plusieurs épisodes (au moins 2)**_

[Video link SHOW MODIFY DELETE EPISODE](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST12-06-SHOW-DELETE-MODIFY-EPISODE.mp4)

***
***
__Quest 13: VALIDATION__ 

- [X] _**Message erruer  maxLength sur le tilte**_
- [X] _**Message erruer  si un tilte existe deja**_
- [X] _**Message erruer  si un synopsis vide**_
- [X] _**[BONUS]Message erruer  plus belle la vie**_

[Video link all  errors  MSG CREATE PROGRAM](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST13-01-Validation.mp4)


***
***
__Quest 14: Many-To-Many__ 

- [X] _**Sur la page d’un acteur, la liste des séries associées s'affiche**_
- [X] _**Sur la page d’une série, la liste des acteurs associés s'affiche**_
- [X] _**Sur la page de l’acteur, lors du clic sur une série de la liste, l'utilisateur est redirigé vers la page de
 la série sélectionnée**_
- [X] _**Sur la page d’une série, lors du clic sur un acteur de la liste, l'utilisateur est redirigé vers la page de l’artiste sélectionné**_

[Video link ManyToMany Actors](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST14-01-ManyToMany.mp4)


***
***
__Quest 15: Entity-Type__ 

- [X] _**Le formulaire d’ajout d’une série affiche un champ acteur (EntityType).**_
   >_@17sec_ 
- [X] _**Ce champ apparaît sous la forme de cases à cocher.**_
   >_@17sec_ 
- [X] _**Lorsque l’on ajoute un acteur à une série, celui-ci est bien relié à la série en BDD.**_
    >_@32sec_
- [X] _**Les acteurs s’affiche sur la page de la série.**_
    >_@1 min 05 sec_

[Video link EntityType](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST15-01-EntityType.mp4)



***
***
__Quest 16: Fixtures__ 

- [X] _**Lorsque php bin/console doctrine:fixtures:load est exécuté, il n y a pas de message d'erreur,**_
   >_@6sec_ 
- [X] _**Les fixtures génèrent de nombreux acteurs répartis dans toutes les séries existant en base (en plus des acteurs créés à la main)**_
    >_@44sec to 1 min 25 sec_
- [X] _**Les fixtures génèrent de nombreuses saisons (à l’aide de Faker) réparties dans toutes les séries existant en base,**_
    >_@1 min 25 sec to 1 min 50 sec_
- [X] _**Les fixtures génèrent de nombreux épisodes (à l’aide de Faker) répartis dans les saisons existantes,**_
    >_@1 min 50 sec to 3 min 20 sec_
- [X] _**Les noms des catégories sont définis "à la main" dans la classe App\DataFixtures\CategoryFixtures,**_
    >_@3 min 20 sec to 3 min 32 sec_
- [X] _**Les séries sont définies "à la main" dans la classe App\DataFixtures\ProgramFixtures,**_
    >_@3 min 32 sec_
    

[Video link Fixtures](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST16-01-Fixtures.mp4)


***
***
__Quest 17: Service__ 

Paticularitée du service Slugify : il  utilise ( volontairement ) le titre ou le nom  de des items pour générer le
 slug. j'ai  mis seullement un echantillon des usages. ( trop long !!! )

- [X] _**Les entités Program, Episode, Actor comportent un champ slug,**_
   >_Not in video see code_ 
- [X] _**Les routes des différents contrôleurs relatifs aux séries, épisodes, et acteurs utilisent les slugs plutôt que les id,**_
    >_Not in video see code_
- [X] _**Le service est appelé à chaque niveau de l’application où il y a un ajout/modification de actor/episode/program**_
    >_Not in video see code_
- [X] _**Le service Slugify créé auparavant avec une méthode generate(), permet de générer un slug à partir d'une chaîne de caractères,**_
    >_Not in video see code_
- [X] _**Le SHOW program utilise un slug,**_
    >_@ 0 min 2 sec_
- [X] _**Le SHOW actor utilise un slug,**_
    >_@ 0 min 8 sec_
- [X] _**Le SHOW actor utilise un slug,**_
    >_@ 0 min 8 sec_
- [X] _**Le SHOW episode utilise un slug,**_
    >_@ 0 min 42 sec_  
- [X] _**Le EDIT episode utilise un slug,**_
    >_@ 1 min 05 sec_    
- [X] _**Le UPDATE episode utilise un slug et "slugify correctement la chaine "titre",**_
    >_@ 1 min 20 sec_    


[Video link Service](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST17-01-Service.mp4)

***
***
__Quest 19: User__ 

- [X] _**Le formulaire de login est fonctionnel,**_
    >_@ 0 min 3 sec_ 
- [X] _**Le lien de déconnexion est fonctionnel,**_
    >_@ 0 min 13 sec_
- [X] _**Lorsque tu rédiges un commentaire, l’auteur actuellement connecté est bien associé en base de données,**_
    >_ 0 min 39 sec to 1 min 20sec _
- [X] _**Les commentaires liés à l’épisode sont affichés dans l’ordre du plus vieux au plus récent,**_
    >_Not in video see code , pas compris la question , implicite vu que les commentaires sont retournés par id via
le (getComments) => seclectAll = by id,  par precaution j'ai ajouter un sorted explicite ... 

[Video link Service](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST19-01-User.mp4)

***
***
__Quest 18: SendEmail__ 

- [X] _**Le mail du destinataire (administrateur) est issu d'une variable d'environnement,**_
    >_@ 0 min 14 sec_ 
- [X] _**Le contenu des mails envoyés reprend l'apparence générale de l'application, à l'aide d'un layout de mail général et se trouve dans une vue Twig**_
    >_@ 1 min 05 sec_
- [X] _**Le contenu du mail indique le titre de la nouvelle série publiée, ainsi qu'un lien vers la nouvelle série.**_
    >_ 1 min 15 sec 

[Video link Service](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST18-01-Email.mp4)

***
***
__Quest 20: Symfony : Sécurisons nos routes.__ 

- [X] _**Le fichier security.yaml est configuré correctement avec une gestion de la hiérarchie,est configuré correctement avec une gestion des chemins sécurisée**_
    >_@ 0 min 01 sec_ 
- [X] _**Un utilisateur reconnu comme "anonymous" ne peut accéder qu'à la page d’accueil,  aux pages de listing détails des séries, saison, épisodes et acteur.**_
    >_@ 0 min 11 sec_ ( echantillon )
- [X] _**Un utilisateur reconnu comme "abonné" peut ajouter un commentaire, ne peut supprimer un commentaire que s’il
 est lui-même l’auteur.**_
    >_ 1 min 17 sec ( echantillon )
- [X] _**Un utilisateur reconnu comme "administrateur" peut accéder à l'ensemble du site, dont la modification de toutes les séries, saisons, épisodes, acteurs et la création de catégories.**_
    >_ 1 min 50 sec ( echantillon )

[Video link Service](https://filedn.com/lRT6JcS1sB0bW0nKVxQpO0b/WildCodeSchiool/GC-SYMFONY-QUEST20-01-User.mp4)

