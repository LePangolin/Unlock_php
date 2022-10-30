# Groupe

- Sacquard Julien
- Cordurié Lucas
- Schloesser Adrien

# Trello

https://trello.com/b/sMLUD0oV/unlock


# Mise en place du projet

1. Cloner le projet

2. Aller dans le dossier du projet

3. Lancer la commande
 ```
 powershell > docker-compose up -d
```

4. Allez dans le container avec la commande : 
```bash
 powershell >  docker-compose exec --workdir /app php /bin/bash
```

5. Lancer la commande 
```bash
powershell > composer install
```

6. Créez la base de données avec la commande 
```bash
powershell > php vendor/bin/doctrine orm:schema-tool:create
```

7. Lancez le serveur avec la commande 
```bash
powershell > ./vendor/bin/doctrine-migrations migrate
```

8. L'application est disponible à l'adresse `http://localhost:8080`

# Lien Ressources

https://www.slimframework.com/docs/v4/cookbook/database-doctrine.html
