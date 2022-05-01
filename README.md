## Installation
Here is how you can run the project locally:
1. Clone this repo
    ```sh
    git clone https://github.com/dotmarn/glover-assessment.git
    ```
1. Go into the project root directory
    ```sh
    cd glover-assessment
    ```
1. Copy .env.example file to .env file
    ```sh
    cp .env.example .env
    ```
1. Create database `glover_assessment` (you can change database name)

1. Go to `.env` file 
    - set database credentials (`DB_DATABASE=glover_assessment`, `DB_USERNAME=root`, `DB_PASSWORD=`)
    > Make sure to follow your database username and password

1. Install PHP dependencies 
    ```sh
    composer install
    ```
1. Generate app key 
    ```sh
    php artisan key:generate
    ```
1. Run migration
    ```
    php artisan migrate
    ```
1. Run seeder
    ```
    php artisan db:seed
    ```
    this command will create 2 admin users:
     > email: admin00@sample.test , password: glover1234
     > email: admin01@sample.test , password: glover1234 
1. Run server 
    ```sh
    php artisan serve
    ``` 

## API Endpoints

1. Administrator login
    ```sh
    /api/auth/login
    ```
    ### payload
    ```json
    {
        "email": "admin00@sample.test",
        "password": "glover1234"
    }
    ```
    ### sample response
    ```json
    {
        "status": 200,
        "message": "Login is successful",
        "data": {
            "id": 1,
            "firstname": "Oliver",
            "lastname": "Jones",
            "email": "admin00@sample.test",
            "email_verified_at": null,
            "created_at": "2022-04-30T09:03:56.000000Z",
            "updated_at": "2022-04-30T09:03:56.000000Z",
            "token": "9|We78eFxqIzORUgdtg3PSbL4wI127qoXjCaqOw1hz"
        }
    }
    ```

1. Administrator logout
    ```
    /api/auth/logout
    ```
    ### Header
    ```json
    "Authorization": "Bearer {{ token }}"
    ```
