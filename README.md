# hn

[hn](https://hn.cleberg.net) is a simple front-end alternative for Hacker 
News, focusing on privacy and simplicity.

## Getting Started

These instructions will get you a copy of the project up and running on your 
local machine for development and testing purposes. See deployment for notes on 
how to deploy the project on a live system.

### Prerequisites

- A web server (e.g., Nginx or Apache)
- PHP

### Installing

Install the dependencies, using the web server of your choice:

```
sudo apt install nginx-full php
```

Clone the repo:

```
git clone https://git.sr.ht/~cmc/hn/
```

## Deployment

Deployment is as easy as copying the code to your webroot. No special packages 
or tools required.

To deploy, ensure you have a publicly-available web server and configure it to 
fallback with all errors to the `index.php` file rather than returning a `404` 
error.

For nginx, include the following snippet in your website's conf file:

```conf
location / {
        # First attempt to serve request as file, then
        # as directory then fall back to index.php
        try_files $uri $uri/ /index.php?$args;
}
```

For Apache, you can include the following snippet in a `.htaccess` file within 
the directory you're serving the PHP file from:

```conf
FallbackResource /index.php
```

## Built With

* [PHP](https://www.php.net/) - The scripting language
* [HTML](https://html.spec.whatwg.org/multipage/) - The markup language

## Contributing

Please read [CONTRIBUTING.md](./CONTRIBUTING.md) for details on our code of 
conduct, and the process for submitting pull requests to us.

## Versioning

This project currently doesn't use versioning. See the git log instead.

## Authors

* **CMC** - *Literally everything* - [cmc](https://sr.ht/~cmc/)

## License

This project is licensed under the Unlicense - see the 
[LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

* Hat tip to anyone whose code was used
* Inspiration
* etc

------------------------------------

# hn


## TODO

A scratch pad of ideas that may be useful to implement:

- [ ] Add functionality to view item-specific page with comments.
- [ ] Add functionality to view a user's profile.
- [ ] Add functionality to load more items or paginate?
- [ ] Add minimal CSS.

## Development

This just uses plain PHP and HTML, no special package managers or development 
tools needed. Just start editing the files with your favorite editor and use a 
server with PHP if you want to view the results or deploy your own version.

## Deployment

