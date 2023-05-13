# Laravel Zoho Subscriptions

## Laravel Zoho Subscriptions API Client

Laravel Zoho Subscriptions API Package

## Installation

You can install the package via composer:

First you need to put repo in `composer.json` as we will install it from git

```json
  "repositories": [
    {
      "url": "https://github.com/bittlerr/laravel-zoho-subscriptions.git",
      "type": "git",
    },
    ...
  ]
```

And then we can install it using composer

```bash
composer require bittler/laravel-zoho-subscriptions:dev-slave
```

### Configuration file

Publish the configuration file

```bash
php artisan vendor:publish --provider="ZohoSubscriptions\Providers\ZohoSubscriptionsServiceProvider"
```

This will create a zoho.php config file within your config directory:-

```php
return [
	'baseUrl' => 'https://www.zohoapis.com/subscriptions/v1',
	'identityUrl' => 'https://accounts.zoho.com/',
    'oauth2' => [
		'clientId' => env('ZOHO_CLIENT_ID'),
		'clientSecret' => env('ZOHO_CLIENT_SECRET'),
		'urlAuthorize' => 'https://accounts.zoho.com/oauth/v2/auth',
    	'urlAccessToken' => 'https://accounts.zoho.com/oauth/v2/token',
        'urlResourceOwnerDetails' => 'https://accounts.zoho.com/oauth/v2/resource'
	],
	'options' => [
		'scope' => [env('ZOHO_OAUTH_SCOPE')],
		'access_type' => 'offline'
	],
	'tokenModel' => '\ZohoSubscriptions\Support\Token\DB',
    'tokenProcessor' => '\ZohoSubscriptions\Support\AuthorisationProcessor',
	'authorisedRedirect' => '',
	'failedRedirect' => '',
];
```

You need to add `ZOHO_CLIENT_ID`, `ZOHO_CLIENT_SECRET` and `ZOHO_OAUTH_SCOPE` vars into your .env file.

That should be it.

## Usage

Everything has been set up to be similar to Laravel syntax. So hopefully using it will be similar to Eloquent, right down to relationships.

At present we cover the following modules

-   Customers

### Connecting

To get an access point you can simply create a new instance and the resource.

```php
    $customer = ZohoSubscriptions::customer();
```

### Accessing models

There are 2 main ways to work with models, to call them directly from the access entry point via a facade, or to call them in the standard php 'new' method and pass in the access entry point

```php
    $customer = Zoom::customer();

    //or

    $zoho = new \ZohoSubscriptions\Support\Entry;
    $customer = new \ZohoSubscriptions\Customer($zoho);
```

### Working with models

As noted we are aiming for functionality similar to Laravel, so most things that you can do in Laravel you can do here, with exception to any database specific functionality, as we are not using databases.

```php
    $customer = ZohoSubscriptions::customer()->create([...]);

    $customer = ZohoSubscriptions::customer()->find(...);

    $customer = ZohoSubscriptions::customer()->all();

    $subscriptions = ZohoSubscriptions::customer()->find(...)->subscriptions;

    // Even this

    $customer = ZohoSubscriptions::customer()->find(...);
    $subscription = ZohoSubscriptions::subscription()->make([...]);
    $customer->meetings()->save($subscription);
```

### Common get functions

#### First

We utilise the first function to return the first record from the record set. This will return an instantiated model.

```php
    $customer = ZohoSubscriptions::customer()->where('status', 'active')->first();
```

#### Find

We utilise the find function to return a record by searching for it by a unique attribute. This will return an instantiated model.

```php
    $customer = ZohoSubscriptions::customer()->find('id');

    //or

    $customer = ZohoSubscriptions::customer()->find('email@address.com');

    // for most models this is only the id.  The past models utilise the uuid instead of the id.
```

#### All

The find all function returns a customised Laravel Collection, which we call a resultset.

```php
  $customers = ZohoSubscriptions::customer()->all();
```

When calling the all function we will make up to 5 API calls to retrieve all the data, so 5 x 300 records (the max allowed), i.e. up to 1500 records per request. This can be amended in the config by updating 'max_api_calls_per_request'.

More info below in ResultSets.

#### Get

We utilise the get function when we want to retrieve filtered records. So check the documentation.

```php
    $customers = ZohoSubscriptions::customer()->where('status', 'active')->get();

    // We can also pass

    $customers = ZohoSubscriptions::customer()->where('status', '=', 'active')->get();
```

When using the get call we will automatically paginate results, which by default is 30 records. You can increase/decrease this by calling the paginate function.

```php
    $customers = ZohoSubscriptions::customer()->where('status', 'active')->paginate(100)->get(); // will return 100 records
```

You can disable the pagination, so it behaves the same as the all() function

```php
    $customers = ZohoSubscriptions::customer()->where('status', 'active')->setPaginate(false)->setPerPage(300)->get(); // will return 300 records * 5 request (or amount set in config) = 1500 records
```

#### resultSet

The all and get functions return a resultSet which is an enhanced Laravel Collection. Like collections, we can call the toArray and toJson functions, which places the data in a 'data' field and adds some meta information on total records and page information.

```php
    // toArray()
    array:5 [
        "current_page" => 1
        "data" => array:5 [
            0 => array:11 [
              "phone" => "...",
              "mobile" => "...",
              "website" => "..."
            ]
            1 => array:11 [
              "phone" => "...",
              "mobile" => "...",
              "website" => "..."
            ]
            2 => array:11 [
              "phone" => "...",
              "mobile" => "...",
              "website" => "..."
            ]
            3 => array:11 [
              "phone" => "...",
              "mobile" => "...",
              "website" => "..."
            ]
            4 => array:11 [
              "phone" => "...",
              "mobile" => "...",
              "website" => "..."
            ]
        ]
        "last_page" => 1
        "per_page" => 1500
        "total" => 5
    ]

```

There are a few additional helper functions.

If our data set is larger than the returned records then we call the nextPage() function to return the next page of records.

```php
    $customers->nextPage();
```

We can then also navigate back a page by calling the previousPage() function. When doing this we will return cached results rather than querying the API.

```php
    $customers->previousPage();
```

There is also a function to accumulate more records, if you call the getNextRecords() function it will retrieve the next 1500 results and add them to the current records, so you can then run through 3000 records if required.

```php
    $customers->getNextRecords();
```

It is not advisable to mix the page navigation with the accumulating records function.

There are also a number of helper functions.

```php
    $customers->hasMorePages();
    $customers->isFirstPage();
    $customers->totalRecords();
    $customers->currentPage();
    $customers->lastPage();
    $customers->nextPageNumber();
    $customers->previousPageNumber();
    $customers->firstPage(); // returns first page number which in this case will always be 1
    $customers->perPage(); // returns how many results we return per page
```

As noted above we are using collections as the base for the record sets, so anything that is possible in collections is possible here. As Zoom's ability to filter is limited we can use the collections 'where' function for example.

### Persisting Models

Again, the aim is to be similar to laravel, so you can utilise the save, create, update and make methods.

#### Save

To save a model we will use the save method, this will determine if the model is a new model or an existing and insert or update the model as needed.

```php
    $customer = ZohoSubscriptions::customer()->find('id');

    $customer->first_name = 'changed';

    $customer->save();
```

#### Create

Currently, only the User model and Role model can be created directly, most other models need to be created as part of a relationship, see below for details.

To create a user.

```php
    ZohoSubscriptions::customer()->create([
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'test@test.com',
        'password' => 'secret'
    ]);
    // will return the created model so you can capture it if required.
    $user = ZohoSubscriptions::customer()->create([
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'test@test.com',
        'password' => 'secret'
    ]);
```

#### Make

Make is similar to create except it will not persist the model to the API. This is handy for relationship models, more on this below.

```php
    $customer = ZohoSubscriptions::customer()->make([...]);

    ZohoSubscriptions::subscription()->find('id')->customer()->save($customer);
```

#### Update

We can also mass update attributes.

```php
    $customer = ZohoSubscriptions::customer()->find('id')->update(['field' => 'value', 'another_field' => 'value']);
```

### Relationships

A major change to the newer versions of our API client is we use Relationships similar to Laravel. To retrieve all subscriptions associated to a user we would call like so.

```php
    $subscriptions = ZohoSubscriptions::customer()->find(...)->subscriptions;
```

In the Zoho Subscriptions API some relationships get returned direct with the parent model, some we have to make additional API calls for (this is worthwhile knowing for performance reasons and API rate limits).

Its also worth pointing out that we are returning the resultset by calling ->subscriptions. If we call the function ->subscriptions() we receive the relationship object which can be further queried.

```php
    $meetings = Zoom::user()->find(...)->subscriptions(); // Returns HasMany relationship model
```

## To Do's

-   Implement all endpoints

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email [constantin@codegod.dev](mailto:constantin@codegod.dev) instead of using the issue tracker.

## Credits

-   [Constantin Cuciurcă](https://github.com/bittlerr)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
