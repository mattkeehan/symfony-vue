docker build (if needed)

docker run -p 8080:8000 -d -v /Users/mattkeehan/DEV/docker-php/www:/var/www/ app

docker exec -it 00e5 /bin/bash

(in docker bash shell) symfony server:start

(in docker bash shell) yarn encore dev --watch

visit http://localhost:8080/lucky/bumber

(an example of annotation based routing to controller)

make tables

RUN php bin/console doctrine:migrations:migrate
