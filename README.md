# hn

[hn](https://hn.cleberg.net) is a simple front-end alternative for Hacker
News, focusing on privacy and simplicity.

## Getting Started

These instructions will get you a copy of the project up and running on your
local machine for development and testing purposes. See deployment for notes on
how to deploy the project on a live system.

### Prerequisites

- A web server (e.g., Nginx or Apache)
- PHP (>= v8.0)
- Optional: minify

### Installing

Install the dependencies, using the web server of your choice:

```
sudo apt install nginx-full php php-cgi php-fpm minify
```

Clone the repo:

```
git clone https://git.sr.ht/~cmc/hn/
```

If you need to minify CSS changes:

```
# executed in the top-level `hn` dir
minify -o static/styles.min.css static/styles.css
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
* [minify](https://github.com/tdewolff/minify/tree/master/cmd/minify) - Used to
  minify CSS

## Contributing

Please read [CONTRIBUTING.md](./CONTRIBUTING.md) and
[CODE_OF_CONDUCT.md](./CODE_OF_CONDUCT.md) for details on our code of
conduct, and the process for submitting pull requests to us.

### TODO

A scratch pad of ideas that may be useful to implement:

- [x] Add minimal CSS.
- [x] Add functionality to view a user's profile.
- [x] Add functionality to view item-specific page with comments (`ConstructStoryDiscussion`).
    - [ ] Load recursive descendant threads.
- [ ] Add functionality to handle polls (`ConstructPoll` & `ConstructPollOpt`).
- [ ] Add functionality to load more items or paginate.

## Versioning

This project currently doesn't use versioning. See the git log instead.

## Authors

* **CMC** - *Literally everything* - [cmc](https://sr.ht/~cmc/)

## License

This project is licensed under the Unlicense - see the
[LICENSE.md](./LICENSE.md) file for details.
