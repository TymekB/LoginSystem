cd back || exit
docker-compose up -d

cd ..

cd front || exit
ng serve
