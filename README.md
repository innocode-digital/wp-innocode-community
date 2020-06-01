# Community

### Description

Helps to integrate [Innocode Community](https://innocode.com/product/community/)
with a site.

### Install

- Preferable way is to use [Composer](https://getcomposer.org/):

    ````
    composer require innocode-digital/wp-innocode-community
    ````

    By default it will be installed as [Must Use Plugin](https://codex.wordpress.org/Must_Use_Plugins).
    But it's possible to control with `extra.installer-paths` in `composer.json`.

- Alternate way is to clone this repo to `wp-content/mu-plugins/` or `wp-content/plugins/`:

    ````
    cd wp-content/plugins/
    git clone git@github.com:innocode-digital/wp-innocode-community.git
    cd wp-innocode-community/
    composer install
    ````

If plugin was installed as regular plugin then activate **Community** from Plugins page 
or [WP-CLI](https://make.wordpress.org/cli/handbook/): `wp plugin activate wp-innocode-community`.

### Usage

Add required constants (usually to `wp-config.php`):

````
define( 'INNOCODE_COMMUNITY_INSTANCE_URL', '' );
define( 'INNOCODE_COMMUNITY_CONSUMER_TOKEN', '' );
````
    
### Documentation

**Get Innocode Community API object**:

````
innocode_community();
````

**Note**: it will trigger an error in case when required constants
`INNOCODE_COMMUNITY_INSTANCE_URL` and/or `INNOCODE_COMMUNITY_CONSUMER_TOKEN` are missing.

---

**Get a feed**:

````
innocode_community()->get_feed( int $id, array $query_args = [], array $args = [] );
````

- `$id` - Feed ID.
- `$query_args` - Query arguments.
- `$args` - Request arguments. See [WP_Http::request()](https://developer.wordpress.org/reference/classes/WP_Http/request/)
for more info.

---

**Perform an HTTP request to the API**:

````
// Performs any HTTP request
innocode_community()->request( string $method, string $path, array $query_args = [], array $args = [] );

// Performs GET HTTP request
innocode_community()->get( string $path, array $query_args = [], array $args = [] );
````

- `$method` - Request method. Accepts `GET`, `POST`, `HEAD`, `PUT`, `DELETE`, `TRACE`, `OPTIONS`, or `PATCH`.
- `$path` - Endpoint path.
- `$query_args` - Query arguments.
- `$args` - Request arguments. See [WP_Http::request()](https://developer.wordpress.org/reference/classes/WP_Http/request/)
for more details.
