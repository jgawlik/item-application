# Item application

A client application that allows you to add, modify and delete records from `items` table.
In addition, it displays all records and allows you to download csv files with different record filtering options. 
Possible options are:
- all items,
- items in stock,
- items not in stock
- items in amount greater than 5

Application does not have access to the database. It uses `api-item-client` composer package to communicate with item REST API.
