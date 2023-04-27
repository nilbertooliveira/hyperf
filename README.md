## Ambiente Docker

Foi utlizado a arquitetura abaixo para concepção do projeto.

Services, Repository, Rbac, Docker e outros padrões.

1. Clonar o repositório:
   `git clone git@github.com:nilbertooliveira/hyperf.git`

2. Rodar o comando abaixo para fazer o build do projeto e pulling das images:
   `docker-compose up -d`

3. Instalar as dependências:
 ```
 docker-compose exec app-hyperf composer install
 ```

6. Configurar a base de dados
```
docker-compose exec app-hyperf php bin/hyperf.php migrate
docker-compose exec app-hyperf php bin/hyperf.php db:seed
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

[Documentação Postman](https://documenter.getpostman.com/view/10569259/2s93eR5wJ3)
