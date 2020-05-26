### Ver 1.0

### LIMITATIONS

Tables should be pre-created in phpmyadmin
We will add table create, alter functionality in version 2.0

### Sample Implementation

This code is beneficial for those who want to do crud operations using php and MySQLi with 0 knowledge of php.

# 1. Insert Data API - only column clause

Method 1 - GET
``` http://localhost:8080/?action=insert&tableName=qrcodes&column[]=userid&columnval[]=xX65av8IzSNsiEDV6S6KhSMVoUA2&column[]=redirecturl&columnval[]=http://instagram.com&column[]=qrstring&columnval[]=653gdfge
```

Method 2 - POST
```
url - localhost:8080/
action=insert
tableName=qrcodes
column[]=['userid','redirecturl','qrstring']
columnval[]=['xX65av8IzSNsiEDV6S6KhSMVoUA2','http://instagram.com','9e6f3213']
```


# 2. Update Data API- column and where clause

Method 1 - GET
```
http://localhost:8080/get.php?action=update&tableName=qrcodes&column[]=userid&columnval[]=xX65av8IzSNsiEDV6S6KhSMVoUA2&column[]=redirecturl&columnval[]=http://facebook.com&column[]=qrstring&columnval[]=653gdfge&where[]=userid&whereval[]=xX65av8IzSNsiEDV6S6KhSMVoUA2&where[]=qrstring&whereval[]=653gdfge
```

Method 2 - Using URL non-string
```
url - localhost:8080/post.php
action=update
tableName=qrcodes
column[]=['redirecturl','qrstring']
columnval[]=['http://instagram.com','9e6f3213']
where[]=['userid','qrstring']
whereval[]=['xX65av8IzSNsiEDV6S6KhSMVoUA2','9e6f3213']
```

# 3. Delete Data API - only where clause

Method 1 - GET
```
http://localhost:8080/get.php?action=delete&tableName=qrcodes&where[]=userid&whereval[]=xX65av8IzSNsiEDV6S6KhSMVoUA2&where[]=qrstring&whereval[]=653gdfge
```

Method 2 - POST
```
localhost:8080/post.php
action=insert
tableName=qrcodes
where[]=['userid','qrstring']
whereval[]=['xX65av8IzSNsiEDV6S6KhSMVoUA2','9e6f3213']
```

# 4. Fetch Data API - select (optional) and where clause (optional)

Method 1 - GET
```localhost:8080/get.php?action=get&tableName=qrcodes&select=redirecturl&where[]=userid&whereval[]=xX65av8IzSNsiEDV6S6KhSMVoUA2&where[]=qrstring&whereval[]=653gdfge
```

Method 2 - POST
```
url - localhost:8080/post.php
action=get
tableName=qrcodes
select=redirecturl
where[]=['userid','qrstring']
whereval[]=['xX65av8IzSNsiEDV6S6KhSMVoUA2','9e6f3213']
```

## Other Advanced Fetch API Implementations

# 5. Fetch Data - distinct select

Method 1 - GET
```localhost:8080/get.php?action=get&tableName=qrcodes&select=redirecturl&distinct=true
```

Method 2 - POST
```
url - localhost:8080/post.php
action=get
tableName=qrcodes
select=redirecturl
distinct=true
```

# 6. Fetch Data - fetch data count

Method 1 - GET
```localhost:8080/get.php?action=get&tableName=qrcodes&returntype=count
```

Method 2 - POST
```
url - localhost:8080/post.php
action=get
tableName=qrcodes
returntype=count
```

# 7. Fetch Data - fetch data with by order and sort them

Method 1 - GET
```localhost:8080/get.php?action=get&tableName=qrcodes&orderby=id&sortby=DESC
```

Method 2 - POST
```
url - localhost:8080/post.php
action=get
tableName=qrcodes
orderby=id
sortby=DESC
```

# 8. Fetch Data - fetch data and group them

Method 1 - GET
```localhost:8080/get.php?action=get&tableName=qrcodes&groupby=userid
```

Method 2 - POST
```
url - localhost:8080/post.php
action=get
tableName=qrcodes
groupby=userid
```

# 9. Fetch Data - fetch limited data

Method 1 - GET
```localhost:8080/get.php?action=get&tableName=qrcodes&limit=5
```

Method 2 - POST
```
url - localhost:8080/post.php
action=get
tableName=qrcodes
limit=5
```
