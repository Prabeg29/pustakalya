# Foobar

This is a digital library project

# Author

 **By Prabeg Shakya**

## Installation
Change .env file

```bash
composer intall
php aritsan migrate:fresh --seed
php artisan serve
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
Please make sure to update tests as appropriate.

### API TASK 

# Auth
- [X] User Registration
- [X] login via username and password (Sanctum Auth)
- [] logout

# List books
- [X] the book has a title with author, cover, and genre
- [X] the book can have multiple authors and genres
- [X] paginate the results
- [] Search for a book by title/author/genre

# List Individual Book
- [] must have description, user reviews and rating

# Admin account
- [X] CRUD operation for books with middleware
- [X] CRUD operation for users

# User Account
- [X] Edit user profile
- [X] Upload avatar
- [] Change the password
- [] Review on a book (stars + comments)
- [] Add book to profile
- [] View books added under ones profile 
