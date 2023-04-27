## Ambiente Docker

Foi utlizado a arquitetura abaixo para concepção do projeto.

Services, Repository, Rbac, Docker e outros padrões.

1. Clonar o repositório:
   `git clone git@github.com:nilbertooliveira/hyperf.git`

2. Rodar o comando abaixo para fazer o build do projeto e pulling das images:
   ```
   cp .env.example .env
   composer install --ignore-platform-reqs --no-scripts
   docker-compose up -d
   ```
4. Configurar a base de dados
```
docker-compose exec app-hyperf php bin/hyperf.php migrate
docker-compose exec app-hyperf php bin/hyperf.php db:seed
```

5. Utilizar o usuario com perfil admin abaixo e executar a request:
```
http://0.0.0.0:9501/set-policies
 ```

##### Usuário admin:
```
nilberto.oliveira@onfly.com.br
123456
```
##### Usuário somente de leitura:
```
readonly@onfly.com.br
123456
```

[Documentação Postman](https://documenter.getpostman.com/view/10569259/2s93eR6GF5)
