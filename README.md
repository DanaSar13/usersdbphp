## Instructions:

### User Upload Script:
To run the user upload script, execute the following command:
```bash
php user_upload.php --file users.csv --create_table -u root -p [DB_Password] -h localhost --database usersdb
```

Sample Result of the User Table Update by User Upload Script:
```
Data insertion completed
Users Table:
-----------------------------------------
| Name    | Surname | Email             |
-----------------------------------------
| Daley   | Thompson | daley@yahoo.co.nz |
| Hamish  | Jones   | ham@seek.com      |
| William | Smythe  | happy@ent.com.au  |
| Johnny  | O'hare  | john@yahoo.com.au |
| John    | Smith   | jsmith@gmail.com  |
| Kevin   | Ruley   | kevin.ruley@gmail.com |
| Mike    | O'connor | mo'connor@cat.net.nz |
-----------------------------------------
```
### Foobar Script:
To run the foobar script, execute the following command:
```bash
php foobar.php
```
Sample result of the Foobar script:
```
1, 2, foo, 4, bar, foo, 7, 8, foo, bar, 11, foo, 13, 14, foobar, 16, 17, foo, 19, bar, foo, 22, 23, foo, bar, 26, foo, 28, 29, foobar, 31, 32, foo, 34, bar, foo, 37, 38, foo, bar, 41, foo, 43, 44, foobar, 46, 47, foo, 49, bar, foo, 52, 53, foo, bar, 56, foo, 58, 59, foobar, 61, 62, foo, 64, bar, foo, 67, 68, foo, bar, 71, foo, 73, 74, foobar, 76, 77, foo, 79, bar, foo, 82, 83, foo, bar, 86, foo, 88, 89, foobar, 91, 92, foo, 94, bar, foo, 97, 98, foo, bar
```
