# Single page registration and login application

## Installation

1. Update your hosts file:
    `127.0.0.1	spa-register.local`

2. Install
    - docker
    - docker compose

3. Add credentials to docker env
    `cp docker/.env.sample docker/.env`
    
4. Create symfony .env and add credentials
    `cp .env.sample .env`
    
5. Add your user to docker group
   `sudo gpasswd -a {your_username} docker && service docker restart`
   
6. Run docker container
    `cd docker && ./start.sh`

7. Update database and run migrations(to add countries to dropdown)
```
docker exec -it spa-register-php /bin/bash
php bin/console doctrine:schema:update --force
php bin/console doctrine:migrations:migrate
```

8. Install frontend (only if files are updated)
```
docker exec -it spa-register-npm /bin/bash
npm run build
```

## Useful docker/docker-compose commands
- ssh to php container:
`docker-compose exec -it spa-register-php /bin/bash`
- if dockerFile changed rebuild image
`docker-compose build`
- removing all containers
`docker rm $(docker ps -a -q)`
- list containers
`docker ps -a`
- list container images
`docker images`