# How to run
Para a execução do projeto são necessários alguns pré-requisitos:
Laravel
VueJs,
node,
npm e Composer

API.
- Clone diretório "api_rest" 
- Execute "composer update"
- Crie o banco de dados MySql com nome "automaticket"
- Execute o comando "php artisan migrate:fresh --seed" 
- Execute "php artisan jwt:secret" para gerar sua chave "JWT_SECRET", necessário para funcionamento do token JWT. 
- Se não houver um servidor apache, poderá executar o serviço "php artisan serve", para estabelecer os serviços.

APP
- Clone o diretório "app_vue" 
- Execute o comando "npm install" 
- Após a instalação execute o comando "npm rum dev" dentro do diretório "app_vue", podem também criar uma build para simular o serviço em produção "npm run build".
