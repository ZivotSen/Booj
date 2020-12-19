Steps:
1- Create a clean database named booj in MySQL
2- Configure correctly your .env parameters for default connection (copy the basics from .env.example).
3- Run: composer install
4- Run: npm install && npm run dev
5- Run: php artisan migrate


To use the external API:
1- This version is connected with https://openlibrary.org/api/books
2- On this version you can only use the endpoints to consult an specifyc book
3- You can get a book providing the correct ISBN (an example will be provided over Postman collection)
4- You can request for more details related to a book passing parameter jscmd
5- Oficial API doccumentation can be found here: https://openlibrary.org/dev/docs/api/books
6- An access point (/api/book/library) example is provided in the Postman collection


To use the api endpoints:
1- Change the starting route with the url defined in your host for the site.
2- Take a look to the example collection provided by Postman.
3- You have available funtions to list all books, create a new book, show an specic book, update (change order) of an specific book providing the correct id, and remove a book from the list as well.
4- You can change the order of the items in the list updating a book with a new sort order.