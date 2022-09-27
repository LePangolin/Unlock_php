# Groupe

- Sacquard Julien
- Cordurié Lucas
- Schloesser Adrien

# Trello

https://trello.com/b/sMLUD0oV/unlock


# docker-compose PHP MariaDB slim4 Boilerplate

1. start and get logs

```
docker-compose up
```

2. open an new terminal and get into PHP container

```
docker-compose exec --workdir /app php /bin/bash
```

3. within the PHP container, install compose dependencies

```
composer update
```

4. slim app runs on http://localhost:8080


# Lien Ressources

https://www.slimframework.com/docs/v4/cookbook/database-doctrine.html
