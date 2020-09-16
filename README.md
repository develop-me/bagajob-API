# BagaJob - The Definitive Job Hunting Management App
## Back-end Architecture - Laravel

### Collaborating:

**Never commit directly to the master branch. Create a new feature branch from the development branch, and make a pull request for a team-mate to review and merge.**

### Getting Started:

The Vagrant Box set up to use Laravel's Homestead image. To get started:

1. Clone this repo and `cd` into the new directory
1. In your new directory, run `composer install`
1. Run `vendor/bin/homestead make`
1. Copy the `.env.example` file to a new `.env` file:
`cp .env.example .env`

1. Update passwords in your `.env` file
    - The admin user is controlled by these environment variables and will be created when the database is seeded
        - ADMIN_USER_NAME="Bagajob Admin"
        - ADMIN_USER_EMAIL=bagajob.mail@gmail.com
        - ADMIN_USER_PASSWORD= *****
    - If you need email, set these api keys as well, they can be accessed from the [bagajob mailjet account](https://app.mailjet.com/account/api_keys)
        - MAILJET_APIKEY= *****
        - MAILJET_APISECRET= *****
    - 
1. Run `vagrant up`
1. ssh to the virtual machine: `vagrant ssh`
1. Navigate to new `code` folder: `cd code`
1. Run the database migrations: `artisan migrate`
1. Seed the database with example data: `artisan db:seed`
    - `UsersTableSeeder.php` adds the admin user 
    - `JobsTableSeeder.php` adds 10 Users, each with 10 jobs associated.
    - `AppNoteSeeder.php` adds 2 application notes to each job
    - `InterviewSeeder.php` adds 2 interviews to each job

1. Create the Passport authentication keys: `php artisan passport:install`


Visit `http://homestead.test` on Mac or `http://localhost:8000` on Windows:

![Default view on Start](https://imgur.com/qdBTCLp.jpg?)


### Troubleshooting:

### Q: When I run `composer install` I get a memory error
A: 

First, make sure you're only running this on your local machine and NOT the Vagrant box.

Second, run this command to increase your memory limit, you can use -1 to make it unlimited if neccessary.
`php -d memory_limit=-1 $(which composer) update`

Also see this page:
https://getcomposer.org/doc/articles/troubleshooting.md#memory-limit-errors

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

- Use the basename `https://homestead.test/`
- Be sent using JSON and with the `Accept: application/json` header.

## End points:
Registration and Login
- `POST /register`
- `POST /login`
- `POST /reset-password-without-token`
- `POST /reset-password-with-token`

Users
- `PATCH /user/:userId`
- `DELETE /user/:userId`

Jobs
- `GET /user/:userId/jobs`
- `POST /user/:userId/jobs`
- `GET /user/:userId/jobs/:jobId`
- `PATCH /user/:userId/jobs/:jobId`
- `DELETE /user/:userId/jobs/:jobId`

Interviews
- `GET /user/:userId/jobs/:jobId/interviews`
- `POST /user/:userId/jobs/:jobId/interviews`
- `GET /user/:userId/jobs/:jobId/interviews/:interviewId`
- `PATCH /user/:userId/jobs/:jobId/interviews/:interviewId`
- `DELETE /user/:userId/jobs/:jobId/interviews/:interviewId`

Application Notes
- `GET /user/:userId/jobs/:jobId/app-notes`
- `POST /user/:userId/jobs/:jobId/app-notes`
- `GET /user/:userId/jobs/:jobId/app-notes/:appNoteId`
- `PATCH /user/:userId/jobs/:jobId/app-notes/:appNoteId`
- `DELETE /user/:userId/jobs/:jobId/app-notes/:appNoteId`



### Register User - POST `/register`

#### Request
```json
{
    "name": "<user name>", // REQ, full name
    "email": "<email>", // REQ, valid email, not the same as another in the database
    "password": "<password>" // REQ, password
}
```

#### Responses

##### Success
```json
{  
    "success": {
        "token": "<token>"
    },
    "user": {
        "id": "<ID>",
        "name": "<user name>",
        "email": "<email>",
        "created_at": "2020-09-01 14:22:46"
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

### Login User - POST `/login`

#### Request
- ***NOTE: `username` maps to `email` in this case***
```json
{
    "username": "<user email>", // REQ, valid user email
    "password": "<password>" // REQ, password
}
```

#### Responses

##### Success
```json
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "<token>",
    "refresh_token": "<token>",
    "user": {
        "id": 20,
        "name": "<user name>",
        "email": "<email>",
        "created_at": "2020-09-01 14:22:46"
    }
}
```

##### Failures
- Missing username/password

```json
{
    "error": "invalid_request",
    "error_description": "The request is missing a required parameter, includes an invalid parameter value, includes a parameter more than once, or is otherwise malformed.",
    "hint": "Check the `< missing >` parameter",
    "message": "<same as error_description>"
}
```
- Invalid username/password

```json
{
    "error": "invalid_grant",
    "error_description": "The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.",
    "hint": "",
    "message": "<same as error_description>"
}
```

### Not Logged In/Unauthenticated
- If the frontend tries to make a request to any of the non-authentication workflow related routes without the proper Bearer Token, they will receive this response:
```json
{
    "message": "Unauthenticated."
}
```

### Forgot Password / Password Reset Routes

### `POST /reset-password-without-token`

#### Request
```json
{
    "email": "<email>", // REQ, valid user email
}
```

#### Responses

##### Success
```json
{
    "message": "Reset Password email successfully sent"
}
```

##### Failure
- No email supplied/invalid email format

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "An email is required to reset the password" // "A valid email must be used to reset the password"
        ]
    }
}
```

- User does not exist with that email

```json
{
    "message": "An account does not exist with this email address"
}
```

- Email failed
```json
{
    "message": "An error has occured sending the reset password email, please try again",
    "error": "<error message>"
}


```
### `POST /reset-password-with-token`

#### Request
```json
{
    "email": "<email>", // REQ, valid user email
    "password": "<new password>", // REQ, new password
    "token": "<reset token>", // REQ, valid reset token from email
}
```

#### Responses

##### Success
```json
{
    "message": "Password Reset Successful",
    "user": {
        "id": 21,
        "name": "<name>",
        "email": "<email>",
        "created_at": "2020-09-03 11:16:06"
    },
    "token": "<bearer token>"
}
```

##### Failure
- Similar email, password, token validation as before (required)
- Invalid token, or they've already reset their password
```json
{
    "message": "Password token invalid, please submit a new password reset request"
}
```

### Update User Account - PATCH `/user/{user id}`

#### Request
```json
{
    "email": "<email>", // OPT, valid user email, not duplicate
    "name": "<user name>" // OPT, string
}
```

#### Responses

##### Success
- Returns the user object
```json
{
    "user": {
        "id": 23,
        "name": "<name>",
        "email": "<email>",
        "created_at": "2020-09-04 14:15:57"
    }
}
```

##### Failures
- Trying to update a different user than you are logged in as
```json
{
    "message": "You cannot edit a user other than your own"
}
```

- Trying to update to a Duplicate email in the database

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "A user account exists already with this email"
        ]
    }
}
```

- Incorrect format(s) name or email
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email must be a valid email address."
        ]
    }
}
```

### DELETE User Account - DELETE `/user/{user id}`

#### Responses

##### Success
- Returns a 204 - No Content response

##### Failures
- Trying to delete a user other than your own
```json
{
    "message": "You cannot delete a user other than your own"
}
```
- Trying to delete a user that does not exist
```json
{
    "message": "No query results for model [App\\User] <ID>"
}
```



### Jobs

#### `GET /user/:userId/jobs`

Returns a subset of information from all of the specified user's jobs as JSON:

```json
{
    "data": [
        {
            "id": 21,
            "title": "Architect",
            "company": "Halvorson, Runolfsson and Gutmann",
            "active": 1,
            "stage": "1"
        },
        {
            "id": 22,
            "title": "Tire Builder",
            "company": "Spinka-Lubowitz",
            "active": 1,
            "stage": "1"
        },
    ]
}
```

**Does not return interviews or notes**

#### `POST /user/:userId/jobs`

##### Request

Adds a job to the database. The below is the minimum required JSON, all other fields optional.
```json
{
    "title" : "Senior Java Developer",
    "company" : "Green Software Inc.",
    "stage" : 1,
    "active": 1
}
```

##### Response
The newly created job with an Id (see GET request below) 

#### `GET /user/:userId/jobs/:jobId`

Returns an individual job as JSON object where `:jobId` is the job ID

```json
{
    "data": {
        "id": 21,
        "title": "Rental Clerk",
        "company": "Sauer, Witting and Osinski",
        "active": 1, // boolean (1 - true, 0 - false)
        "location": "Bergemouth",
        "salary": "56010.00",
        "closing_date": "2021-05-22 22:05:29",
        "date_applied": null,
        "description": "Dicta dolorem aut id porro ut porro sit. Expedita nemo vel natus eos ipsa quasi. Deleniti placeat non qui quibusdam adipisci amet et at.",
        "stage": "1",
        "interviews": ["..."],
        "application_notes": ["..."]
    }
}
```

#### `PATCH /user/:userId/jobs/:jobId`

##### Request
JSON with fields to update

##### Response
The updated job 

#### `DELETE /user/:userId/jobs/:jobId`

##### Response
`204 No Content`

### Interviews
#### `GET /user/:userId/jobs/:jobId/interviews`

Returns all of the specified job's interviews as JSON:

```json
{
    "data": [
        {
            "id": 41,
            "job_id": 21,
            "interview_date": "2019-12-04 00:00:00",
            "format": "video_call",
            "interviewer": "Prof. Ozella Stark II",
            "notes": "Quis aut commodi nam id consectetur. Et veniam magnam et incidunt est officiis magnam consequatur."
        },
        {
            "id": 42,
            "job_id": 21,
            "interview_date": "2008-07-14 00:00:00",
            "format": "online_testing",
            "interviewer": "Leonardo Bayer DVM",
            "notes": "Voluptatem numquam ea a quaerat sunt. Laudantium aperiam aut pariatur perferendis nisi possimus."
        }
    ]
}
```

#### `POST /user/:userId/jobs/:jobId/interviews`

##### Request
```json
{
    "interview_date": "2020-09-09", // REQ, date
    "format": "telephone", // REQ, set - 'online_testing','telephone', 'video_call', 'in_person'
    "interviewer": "Johnny", // OPT, string, max 250
    "notes": "Twas the night before xmas and all through the house" // OPT, string, max 500
}
```
#### Response
The newly created interview as JSON

#### `GET /user/:userId/jobs/:jobId/interviews/:interviewId`
Return 1 interview with the specified `:interviewId`
```json
{
    "data": {
        "id": 42,
        "job_id": 21,
        "interview_date": "2008-07-14 00:00:00",
        "format": "online_testing",
        "interviewer": "Leonardo Bayer DVM",
        "notes": "Voluptatem numquam ea a quaerat sunt. Laudantium aperiam aut pariatur perferendis nisi possimus."
    }
}
```

#### `PATCH /user/:userId/jobs/:jobId/interviews/:interviewId`

##### Request
JSON with fields to update

##### Response
The updated interview 

#### `DELETE /user/:userId/jobs/:jobId/interviews/:interviewId`

##### Response
`204 No Content`

### Application Notes
#### `GET /user/:userId/jobs/:jobId/app-notes`
Returns all of the specified job's application notes as JSON:

```json
{
    "data": [
        {
            "id": 41,
            "job_id": 21,
            "note_name": "distinctio",
            "date": "1998-06-17",
            "body": "Illo tempora sequi ea quos. Et ut praesentium aut. Perspiciatis voluptas natus nisi similique. Architecto animi unde eum doloribus voluptatum in."
        },
        {
            "id": 42,
            "job_id": 21,
            "note_name": "deleniti",
            "date": "2008-02-01",
            "body": "Est totam magnam ratione non ut ut qui. Sequi quia exercitationem ratione iure ullam et in et. Consequatur qui qui enim."
        }
    ]
}
```

#### `POST /user/:userId/jobs/:jobId/app-notes`

##### Request format
```json
{
    "date": "2020-10-10", // REQ, date
    "note_name": "NOTE", // REQ, string, max 50
    "body": "xmas and all through the house" // REQ, string, max 500
}
```

#### Response
The newly created application notes as JSON

#### `GET /user/:userId/jobs/:jobId/app-notes/:appNoteId`
Return 1 applicaiton note with the specified `:appNoteId`
```json
{
    "data": {
        "id": 42,
        "job_id": 21,
        "note_name": "deleniti",
        "date": "2008-02-01",
        "body": "Est totam magnam ratione non ut ut qui. Sequi quia exercitationem ratione iure ullam et in et. Consequatur qui qui enim."
    }
}
```

#### `PATCH /user/:userId/jobs/:jobId/app-notes/:appNoteId`
##### Request
JSON with fields to update

##### Response
The updated interview 

#### `DELETE /user/:userId/jobs/:jobId/app-notes/:appNoteId`

##### Response
`204 No Content`

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
