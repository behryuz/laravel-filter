# Laravel Filter

Simple Laravel Filter.

## Installation

```bash
composer require behryuz/filter
```

## Usage

To create new node-filter run

>PS: Node filter is a filter, that you can reuse in every filter you want 
```bash
php artisan model:filter-node StatusNodeFilter
```
> You are able to skip 'NodeFilter' suffix if you want

```php
<?php

namespace App\Filters\Nodes\User;

use App\Filters\NodeFilter;
use Illuminate\Database\Eloquent\Builder;

class StatusNodeFilter implements NodeFilter
{
    public function handle(Builder $query, $input): Builder
    {
        return $query->where('status_id', $input);
    }
}

```

To create new filter run

```bash
php artisan model:filter UserFilter
```

> You are able to skip 'Filter' suffix if you want

Add as many filters as you need

```php
<?php

namespace App\Filters\Users;

class UserFilter extends Filter
{
    protected array $filters = [
       'status_id' => StatusNodeFilter::class
    ];

}
```

Add ```Filter/Filterable``` to ```Models/User```

```php
<?php

namespace App\Models;

class User extends Model
{
   use Filterable;
}
```

Then you can use filter scope method when calling ```User``` model

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::filter(UserFilter::class)->get();

        return $users;
    }

}
```


## License
[MIT](https://choosealicense.com/licenses/mit/)
