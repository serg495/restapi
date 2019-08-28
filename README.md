##Installation
1. `git clone https://github.com/serg495/restapi.git`
2. `cd project/directory`
3. `composer install`
4. `php artisan key:generate`
5. `cp .env.example .env`

After executing these commands configurate your .env file and run `php artisan serve`.

##API Requests

HTTP Method |API Token | URL | Required Params | Description |
--- | --- | --- | --- | --- |
POST | - | api/register | email, name, password, password_confirmation | Register a new user |
POST | - | api/login | email, password | Authorize a user |
POST | - | api/logout |  | Deauthorize a user |
GET | + | api/user/invites/sent |  | Get all invites were sent |
GET | + | api/user/invites/received |  | Get all invites were received |
POST | + | api/user/invite/send | recipient_id, body | Send invite |
PATCH | + | api/user/invite/{invite}/cancel |  | Cancel sent invite |
PATCH | + | api/user/invite/{invite}/confirm | confirmation (bool) | Confirm or reject received invite |