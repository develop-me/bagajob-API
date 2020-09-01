# BagaJob - The Definitive Job Hunting Management App
## Back-end Architecture - Laravel

### Collaborating:

**Never commit directly to the master branch. Create a new feature branch from the development branch, and make a pull request for a team-mate to review and merge.**

### Getting Started:

The Vagrant Box set up to use Laravel's Homestead image. To get started:

1. Clone this repo and `cd` into folder
1. In your new directory, run `composer install`
1. Run `vendor/bin/homestead make`
1. Copy the `.env.example` file to a new `.env` file:
`cp .env.example .env`

1. Update password your `.env` file
1. Run `vagrant up`
1. Login to the virtual machine: `vagrant ssh`
1. Navigate to new `code` folder: `cd code`
1. Run the database migrations: `artisan migrate`
1. Seed the database with example data: `artisan db:seed`

Visit `http://homestead.test` on Mac or `http://localhost:8000` on Windows:

![Default view on Start](https://imgur.com/qdBTCLp.jpg?)


### Troubleshooting:

#### Q: When I visit `http://homestead.test` on Mac or `http://localhost:8000` on Windows, I get an Error 500: Internal Server Error
A:

Reload the vagrant box and provision it:

`vagrant reload --provision`

Generate a new app key:

`php artisan key:generate`

#### Q: When I run `vagrant up`, I get the following error:
```
Vagrant was unable to mount VirtualBox shared folders. This is usually
because the filesystem "vboxsf" is not available. This filesystem is
made available via the VirtualBox Guest Additions and kernel module.
Please verify that these guest additions are properly installed in the
guest. This is not a bug in Vagrant and is usually caused by a faulty
Vagrant box. For context, the command attempted was:

mount -t vboxsf -o dmode=777,fmode=666,uid=1000,gid=1000 var_www /var/www

The error output from the command was:

: No such device
```
A:

First, install the `vagrant-vbguest` plugin:

`vagrant plugin install vagrant-vbguest`


Next, initialise the plugin:

`vagrant vbguest`

---

# Bagajob API

## General

All requests should:

- Use the basename `https://homestead.test/api/`
- Be sent using JSON and with the `Accept: application/json` header.

## End points:
### Register User - POST `/api/register`

#### Request
```json
{
    "name": "Test User 1", // REQ, full name
    "email": "test@test2.com", // REQ, valid email, not duplicate
    "password": "iliketurtles" // REQ, password
}
```

#### Responses

##### Success
```json
{
    "success": {
        "token": "<token>"
    }
}
```

##### Failures
- Missing name
- Missing email
- Missing password
- Duplicate User (email must be unqiue)

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "A name is required to create a user account"
        ],
        "email": [
            "A email is required to create a user account"
        ],
        "password": [
            "A password is required to create a user account"
        ],
        "email": [
            "A user account exists already with this email"
        ],
    }
}
```

### Jobs - `/api/jobs`

#### `GET /api/jobs`

Returns all jobs as JSON object:

```json
{
        "id": 2,
        "job_title": "Compacting Machine Operator",
        "company": "McLaughlin, Johnston and Koepp",
        "active": 1,
        "location": "East Kaceybury",
        "salary": "20444.00",
        "closing_date": "2020-09-05 10:02:52",
        "application_date": null,
        "description": "Sunt ratione velit cumque ipsam nihil soluta. Ut asperiores ab excepturi laboriosam porro. Error voluptatibus beatae non. Et sunt omnis sed velit. Quia qui corrupti autem facilis.",
        "recruiter_name": null,
        "recruiter_email": null,
        "recruiter_phone": null,
        "stage": "1",
        "created_at": "2020-08-27T13:17:46.000000Z",
        "updated_at": "2020-08-27T13:17:46.000000Z"
    },
    {
        "id": 3,
        "job_title": "Power Distributors OR Dispatcher",
        "company": "Kuphal-Wunsch",
        "active": 1,
        "location": "Larissachester",
        "salary": "59962.00",
        "closing_date": "2020-12-08 13:56:00",
        "application_date": null,
        "description": "Numquam dolor voluptas quia et temporibus aut facilis. Quam assumenda in cum ducimus enim. Sit sapiente et magni et blanditiis. Accusantium est porro voluptatibus velit nostrum. Laborum quas optio quod pariatur.",
        "recruiter_name": null,
        "recruiter_email": null,
        "recruiter_phone": null,
        "stage": "1",
        "created_at": "2020-08-27T13:17:46.000000Z",
        "updated_at": "2020-08-27T13:17:46.000000Z"
    },
```

**Does not return interviews, notes or users associated with those jobs.**

#### `GET /jobs/:id`

Returns an individual job as JSON object where `:id` is a job ID

```json
{
        "id": 17,
        "job_title": "Electrotyper",
        "company": "Satterfield-Dach",
        "active": 1,
        "location": "Archland",
        "salary": "30601.00",
        "closing_date": "2021-01-20 07:00:04",
        "application_date": null,
        "description": "Nihil illum quam id et natus deserunt. Et eius porro ex. Deleniti nulla libero doloribus et laudantium eius. Quos voluptatem maxime soluta. Repellendus voluptatem neque est facere facere atque.",
        "recruiter_name": null,
        "recruiter_email": null,
        "recruiter_phone": null,
        "stage": "1",
        "created_at": "2020-08-27T13:17:46.000000Z",
        "updated_at": "2020-08-27T13:17:46.000000Z"
    },
```

#### `POST /api/jobs`

Adds a job to the database. The below is the minimum required JSON, all other fields optional.
```json
{
    "job_title" : "Senior Java Developer",
    "company" : "Green Software Inc.",
    "stage" : 1,
    "active": 1
}
```
---

## Laravel

## Documentation

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

---

## Scotch Box

## Documentation

* Check out the official docs at: [box.scotch.io](https://box.scotch.io)
* [Read the getting started article](https://scotch.io/bar-talk/introducing-scotch-box-a-vagrant-lamp-stack-that-just-works)
* [Read the 3.5 release article](https://scotch.io/bar-talk/announcing-scotch-box-v35-and-scotch-box-pro-v15-the-big-switcheroo)
