This is a digital library project

# Author

 **Prabeg Shakya**

## Installation
Change .env file

```bash
composer intall
php aritsan migrate:fresh
php artisan serve
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
Please make sure to update tests as appropriate.

### API TASK 

# Auth
- [X] User Registration with email verification
- [X] Login via username and password (Sanctum Auth)
- [] Logout

# List books
- [X] the book has a title with author, cover, and genre
- [X] the book can have multiple authors and genres
- [X] paginate the results
- [X] Search for a book by title/author/genre

# Individual Book
- [X] must have description, user reviews and rating
- CRUD for reviews using policies

# Admin account
- [X] CRUD operation for books with middleware
- [X] CRUD operation for users

# User Account
- [X] Edit user profile
- [] Upload avatar
- [] Change the password
- [X] Add book to profile
- [X] View books added under ones profile 

# Misc
- [] API Documentation
