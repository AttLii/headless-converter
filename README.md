# Wordpress Headless Plugin
A Wordpress plugin, that converts frontend to JSON response when request is done with certain conditions.

## Usage 
To enable JSON response, an environment needs to:
- Activate this plugin
- Create application password for a user with administrator role

After above steps have been made, make a request to a page with added [Authorization header](https://en.wikipedia.org/wiki/Basic_access_authentication).

### Examples

Using fetch 
```javascript
const username = "admin"
const password = "s9VJ 096n UPtE bu6F zJEY Jh9H"
const url = "http://localhost:3000/?page_id=2"
const opts = {
  headers: {
     'Authorization': 'Basic ' + btoa(`${username}: ${password}`) 
  }, 
}
fetch(url, opts).then(r => r.json()).then(console.log)
```

Using Axios
```javascript
const axios = require("axios")

const username = "admin"
const password = "s9VJ 096n UPtE bu6F zJEY Jh9H"
const url = "http://localhost:3000/?page_id=2"
const opts = {
  auth: {
    username,
    password
  }
}

axios(url, opts).then(r => r.data).then(console.log)
```

