# PHP-Warehouse-CRUD-App
A Warehouse stock manager built with PHP (group project)


This is a PHP group project that i contributed to the back-end development for!

It resolves around a stores / warehouse database. The admin can Insert, update or delete products, while employees can change the amount in stock using a QR code.

A login screen on startup determines if you're an employee or admin.
Thanks to the checklogin.php, you will be redirected if try to open the mainscreen and never logged in succesfully.

Features for the admin:
- An overview of every product in the database with it's information.
- The ability to DELETE each product, by pressing on the red cross.
- The ability to INSERT a new product, by pressing on "Product toevoegen". A QR code will automatically get generated for the product.
- The ability to UPDATE an existing product, by pressing "aanpassen".
- The ability to see total sales of the week in a graph, by pressing "grafiek info bekijken".
- The ability to see only one product's sales of the week by pressing "statestiek bekijken".
- The ability to view, edit, insert and delete users. These could be admins or employees.
- The admin has file uploads for product picture and user pictures. I emptied the folder however.
- The admin gets a warning to restock a product if the current stock gets below it's configured minimum in the database.


Features for the employee:
- Once the employee has logged in, he/she gets the ability to scan a QR code inside the app with their cameras. As employees would use mobile devices to quickly scan.
- When a QR code of a product is scanned, he/she can change the stock.


Libraries i used:
- Quickchart (QR generation and graphs)
- html5qrcode (QR scanner)


I'm not very fond of the front-end design. I might change that myself if my group allows it.

  

