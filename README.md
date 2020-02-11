# tech_test
Projet pour test technique.

Pour tester le projet:
- ouvrir un terminal
- Faire la commande git clone https://github.com/marjolion10/tech_test.git
- Entrer dans le dossier tech_test, puis test
- Faire un composer install

- Pour récupérer la base de données:
	- Penser à changer le port dans le .env (8889=mac / 3306=default)

	Faire les commandes:
	-  php bin/console doctrine:database:create
	-  php bin/console make:migration
	-  php bin/console doctrine:migrations:migrate (il peut y avoir des erreurs mais cela fonctionne)
- Taper la commande symfony server:start
- Coller l'url proposée dans la barre d'adresse
