# Maria Dadalt's Inpsyde Assessment

This project is a test for the position of Full Stack Developer at Inpsyde. The scope of the plugin is to show in WordPress frontend an HTML table that lists "users", one per row. Each row can be clicked, showing a popup with more details about the user. The source data is provided by a 3rd-party API.

## Requirements
- [Composer](https://getcomposer.org/)
- [WordPress](https://br.wordpress.org/) - Preference for [WP Starter](https://wecodemore.github.io/wpstarter/)
- [Maria Dadalt's Plugin Core](https://github.com/mariacdadalt/plugin-core)

## Instalation

In the `composer.json` for the whole site code, add the following repository:
```
{
	"type": "composer",
	"url": "https://mariacdadalt.github.io/composer-satis/"
}
```
then, require the following package:
```
"mariacdadalt/inpsyde-assessment": "dev-main"
```
Now run `composer install`. Two plugins should have been installed. A MU plugin named `plugin-core` and a normal plugin called ìnpsyde-assessment`.

## Usage

After activating the plugin, ensure that you flush your permalinks in `Settings >> Permalinks`.

go to `user-table` endpoint in your root domain. A simple table with users should appear.

## Implementation choices
- Instead of using a link tag (`<a>`) to open the modal, I have decided to use Javascript to open the modal when the whole `<tr>`tag is clicked. I opted to do it this way to keep the result consistent across the whole line.
- For the caching approach, I decided to go with transients from WordPress, since it's the common approach in the platform. The main implementation is done inside the `plugin-core` in the [AbstractAPI](https://github.com/mariacdadalt/plugin-core/blob/main/src/Abstractions/AbstractAPI.php) file.
- The dependency of the **plugin-core** framework. Over my years of development with WordPress, I began to develop a `mu-plugin` that would eventually be used as a core to custom code in WordPress. The code is still in early stages, but I thought it would be a great idea to show its power while showing my skills, since I believe this framework has much of what I am capable to do. I took the liberty of explaining some of its key concepts directly on its readme file, so for a better understanding of why I decided to use it for this project, please refer to the [plugin-core plugin](https://github.com/mariacdadalt/plugin-core). 