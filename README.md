## Run the project
### Setup
- `docker-compose up -d`
- `docker-compose exec php composer install `

### Webservice
`http://localhost`
if you don't send data
it considers NOW as UTC

```php 
Method : GET 
Parameter: utc  //datetime in utc format
Response: Json
Path: http://localhost/{utc}
