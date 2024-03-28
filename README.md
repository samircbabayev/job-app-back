# Jobb Application

After pulling the project run in project directory: 

`composer install`

Create a configuration file named .env in project directory, and replicate the contents present in the `/.env.example` file.

For the purpose of acknowledgment, presented below are significant constants essential for the project's operation in .env file:

Database:
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Run `php artisan migrate` in directory

You can run project with `php artisan serve` command

Now you should see project in your app url.

For importing via curl, command: `curl -X POST \
  --url 'http://127.0.0.1:8001/api/employee' \
  --header 'Content-Type: text/csv' \
  --header 'Accept: application/json' \
  --data-binary @"/path/to/file/import.csv"`

## Additional Info
1. Utilizing the "insert on duplicate" method ensures that the employee_id column remains unique, preventing the insertion of duplicate data. If a record already exists, it will be updated instead.

2. During CSV import, preserving the original data as strings allows for flexibility in handling data types. For instance, if the data type is uncertain, columns like birth_date can be added to reflect the original format in MySQL. Adaptations are made based on the available information in the CSV.

3. Soft delete functionality is employed for deletion operations, ensuring that records are retained in the database but marked as deleted.

4. The addition of an import history feature allows tracking of data changes and import counts. Future enhancements could include fields like creator ID, import type, and descriptions for more comprehensive analysis.

5. Beyond basic functionality, further enhancements such as authentication, authorization, logging, and performance optimization can be implemented. This includes database optimization, code efficiency improvements, and network optimization to handle larger datasets efficiently, considering potential limitations when running on local servers like PHP's artisan serve.

## Existing API's

Post. Import: ```http://127.0.0.1:8001/api/employee``` Import batch Csv

Get.
List: ```http://127.0.0.1:8001/api/employee```
Details employee: ```http://127.0.0.1:8001/api/employee/:id/details```

Delete. Delete employee: ```http://127.0.0.1:8001/api/employee/:id/delete```
