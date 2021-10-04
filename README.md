# Wordpress Headless Plugin
A Wordpress plugin, that converts frontend to JSON response when request is done with certain conditions.

## Inspiration
After creating a bunch of headless Wordpress + Web app stacks, I wanted to find a standard and a all-round solution for fetching per page information for web applications inside Wordpress. Built-in rest api works fine in basic cases, but it doesn't support querying by path. Usually this meant that for each project developers would create a custom rest endpoint which would return expected content using content type and slug parameters.

Wordpress has few built-in functions to retrieve content by path, [url_to_postid](https://developer.wordpress.org/reference/functions/url_to_postid/) and [get_page_by_path](https://developer.wordpress.org/reference/functions/get_page_by_path/), but they don't seem to work with multilanguage plugins, taxonomy or archive pages, which means that WP doesn't have a reliable way to fetch content this way through rest api.

This plugin converts frontend to JSON which seems after above solution the best way to do things, with added layer of security through application passwords (Wordpress v5.6 feature) and a filter, which let's developers alter outgoing data.

## Usage 
To enable JSON response, an environment needs to:
- Install and activate this plugin
- Create application password for a user with administrator role

After above steps have been made, make a request to a page with added [Authorization header](https://en.wikipedia.org/wiki/Basic_access_authentication).

## Modifying the output
Plugin outputs current page's Post object or null. This can be modified using `headless-plugin-modify-data`-filter. You can either modify passed in post object or do your own logic like in the example below.

```php
/**
 * Modifies Headless Plugin's output.
 * 
 * @param WPPost|null $post - Current template's post object 
 */
function modify_headless_plugin_output($post) {
  if(is_404()) {
    return "this block renders 404 page content";
  } else if(is_page()) {
    return "this block renders page post types content";
  } else if (is_singular('post')) {
    return "this block renders single post content";
  } else if(is_home()) {
    return "this block renders post archive";
  } else {
    return $post;
  }
}

add_filter('headless-plugin-modify-data', 'modify_headless_plugin_output');
```

### Examples

Get data using fetch
```javascript
const username = "admin"
const password = "1111 1111 1111 1111 1111"
const url = "http://localhost:3000/?page_id=2"
const opts = {
  headers: {
     'Authorization': 'Basic ' + btoa(`${username}: ${password}`) 
  }, 
}
fetch(url, opts).then(r => r.json()).then(console.log)
```

Get data using axios
```javascript
const axios = require("axios")

const username = "admin"
const password = "1111 1111 1111 1111 1111"
const url = "http://localhost:3000/?page_id=2"
const opts = {
  auth: {
    username,
    password
  }
}

axios(url, opts).then(r => r.data).then(console.log)
```

