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
- [] User Registration
- [] login via username and password (Sanctum Auth)
- [] logout

# List books
- [] the book has a title with author, cover, and genre
- [] the book can have multiple authors and genres
- [] paginate the results
- [] Search for a book by title/author/genre

# List Individual Book
- [] must have description, user reviews and rating

# Admin account
- [] CRUD operation for books with middleware
- [] CRUD operation for users

# User Account
- [] Edit user profile
- [] Upload avatar
- [] Change the password
- [] Review on a book (stars + comments)
- [] Add book to profile
- [] View books added under ones profile 
