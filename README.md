# Popular-Repositories-Assessment

Popular PHP Repositories on GitHub

## Assessment

Using whatever frameworks/technologies you feel most comfortable with, complete the following:

1. Using the GitHub API, retrieve the top 100 most starred public PHP projects and store the list of repositories in a MySQL table. The application must be able to create a new schema and table if they do not already exist. The table must contain the repository ID, name, owner username, URL, created date, last push date, description, and number of stars. This process should also be able to update existing project details.
2. Using the data in the table created in step 1, create an interface that displays a list of the GitHub repositories and allows the user to click through to view details on each one. Be sure to include all of the fields in step 1 – displayed in either the list or detailed view. For the interface, you may use any UI frameworks (Vue, React, etc) you see fit.
3. Be sure to publish your code to a public GitHub repository and make commits to show and document your process. Create a README file with a description of the architecture chosen and notes on installation of the application - and make sure to upload it to your GitHub repository.

## Dependencies

- [Laravel](https://laravel.com/docs/11.x)
- [Sail](https://laravel.com/docs/11.x/sail)
- [Tailwind CSS](https://tailwindcss.com)
- [Vue](https://vuejs.org)
- [Inertia](https://inertiajs.com)

## Project structure

```text
./
├── app/
│   ├── DataValueObjects
│   │   └── GitHub/  # Simple objects to represent GitHub API responses
│   ├── Http/ #
│   │   ├── Controllers/  # Controllers to handle Inertia and api requests
│   │   ├── Middleware
│   │   │   └── HandleInertiaRequests.php  # Middleware to handle Inertia requests for web routes
│   │   └── Resources/  # Resources to transform Eloquent models and the JSON responses
│   ├── Models/ # Eloquent models
│   ├── Providers
│   │   └── AppServiceProvider.php  # Controls Laravel application bootstrapping. It will register application services
│   └── Services/  # Application services. These will communicate our controllers to the models and GitHub API
├── resources/
│   ├── css
│   │   └── app.css  # Main css file to specify styling for web application
│   ├── js
│   │   ├── Components/  # Other custom Vue components
│   │   ├── Pages/  # Inertia pages components 
│   │   ├── app.js  # Main script to boot Vue & Inertia application
│   │   ├── bootstrap.js  # Script to setup axios
│   │   └── ssr.js  # Server entry point for server-side rendering server
│   └── views
│       └── app.css  # Root template that will be loaded on the first page visited to application
├── routes/
│   ├── api.php  # Api routes
│   ├── console.php # Artisan console commands
│   └── web.php  # Inertia routes
└── ....
```

## Setup

1. Clone the [Popular-Repositories-Assessment](https://github.com/Podvysotskyi/Popular-Repositories-Assessment) locally

```shell
git clone git@github.com:Podvysotskyi/Popular-Repositories-Assessment.git
```
2. Setup [PHP](https://www.php.net/manual/en/install.php) and [Docker](https://docs.docker.com/engine/install/) on your system

3. Run `make init` command

```shell
make init
```

* In the background `make init` will:
  * Create `.env` file if it doesn't exist
  * Install all PHP dependencies
  * Build Docker containers
  * Generate Laravel application key
  * Install all JavaScript dependencies

4. Run migrations

```shell
make migrate
```

### Start service

```shell
make start
```

### Stop service

```shell
make stop
```

### Run tests

```shell
make test
```
