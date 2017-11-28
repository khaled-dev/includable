## Includable 

This Package provides a simple way to load a model relation by require it in the request,
You must identify the relation you wish to be included if you require it in the request  

### Installation 

Install the package via Composer:

```
$ composer require khaled-dev/includable
```

### Usage

first use the trait in model:

```
namespace App;

use Khaled7\Includable\Includable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{   
    use Includable;
    
    /**
     * The attributes that are includable,
     * references to a relations method.
     *
     * @var array
     */
    protected $includable = [
        'posts',
        'votes',
    ];
   
    public function posts()
    {
        return $this->hasMany(Post::class);
    } 
    
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
    
    // Not includable, coz not in $includable
    public function subscribes()
    {
        return $this->hasMany(Subscribe::class);
    }  
}
```

In controller:

```
// Use to load all includable of all users
User::withRequestIncludes()->get()

// Use to load the includable of this instance
$user = User::first()
$user->loadRequestIncludes();
```

In Request:
```
localhost:8000/users?includes=posts,votes
```

To show the result:

````
// The method `loaded` comes with this package to easily load the included relation  
// Use to load the model 
$this->loaded('posts'); 

// Use to load the model to its laravel-resource
PostResource::collection($this->loaded('posts')),


// laravel-resource
// Use to Load an opptional model to its resource
PostResource::collection($this->when($this->loaded('posts'), $this->loaded('posts'))),

// laravel-resource
// Or semply you can use `WhenLoaded` laravel builtin method
PostResource::collection($this->whenLoaded('posts'))
````

> Better to use laravel-resource

 > In result it should help you to  only include the relations if you really need it, and usually use in APIs.
 
### License
MIT © Ben Constable 2017.
