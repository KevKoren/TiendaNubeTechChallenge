# Faker

[![Monthly Downloads](https://poser.pugx.org/fakerphp/faker/d/monthly.png)](https://packagist.org/packages/fakerphp/faker)
[![Continuous Integration](https://github.com/FakerPHP/Faker/workflows/Continuous%20Integration/badge.svg?branch=1.10)](https://github.com/FakerPHP/Faker/actions)
[![StyleCI](https://github.styleci.io/repos/307658860/shield?branch=1.10&style=plastic)](https://github.styleci.io/repos/307658860?branch=1.10)

Faker is a PHP library that generates fake data for you. Whether you need to bootstrap your database, create good-looking XML documents, fill-in your persistence to stress test it, or anonymize data taken from a production service, Faker is for you.

Faker is heavily inspired by Perl's [Data::Faker](http://search.cpan.org/~jasonk/Data-Faker-0.07/), and by ruby's [Faker](https://rubygems.org/gems/faker).

Faker requires PHP >= 7.1.


# Table of Contents

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Formatters](#formatters)
	- [Base](#fakerproviderbase)
	- [Lorem Ipsum Text](#fakerproviderlorem)
	- [Person](#fakerprovideren_usperson)
	- [Address](#fakerprovideren_usaddress)
	- [Phone Number](#fakerprovideren_usphonenumber)
	- [Company](#fakerprovideren_uscompany)
	- [Real Text](#fakerprovideren_ustext)
	- [Date and Time](#fakerproviderdatetime)
	- [Internet](#fakerproviderinternet)
	- [User Agent](#fakerprovideruseragent)
	- [Payment](#fakerproviderpayment)
	- [Color](#fakerprovidercolor)
	- [File](#fakerproviderfile)
	- [Image](#fakerproviderimage)
	- [Uuid](#fakerprovideruuid)
	- [Barcode](#fakerproviderbarcode)
	- [Miscellaneous](#fakerprovidermiscellaneous)
	- [Biased](#fakerproviderbiased)
	- [Html Lorem](#fakerproviderhtmllorem)
- [Modifiers](#modifiers)
- [Localization](#localization)
- [Populating Entities Using an ORM or an ODM](#populating-entities-using-an-orm-or-an-odm)
- [Seeding the Generator](#seeding-the-generator)
- [Faker Internals: Understanding Providers](#faker-internals-understanding-providers)
- [Real Life Usage](#real-life-usage)
- [Language specific formatters](#language-specific-formatters)
- [Third-Party Libraries Extending/Based On Faker](#third-party-libraries-extendingbased-on-faker)
- [License](#license)


## Installation

```sh
composer require fakerphp/faker
```

## Basic Usage

### Autoloading

Faker supports both `PSR-0` as `PSR-4` autoloaders.
```php
<?php
# When installed via composer
require_once 'vendor/autoload.php';
```

You can also load `Fakers` shipped `PSR-0` autoloader
```php
<?php
# Load Fakers own autoloader
require_once '/path/to/Faker/src/autoload.php';
```

*alternatively, you can use any another PSR-4 compliant autoloader*

### Create fake data
Use `Faker\Factory::create()` to create and initialize a faker generator, which can generate data by accessing properties named after the type of data you want.

```php
<?php
// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

// generate data by accessing properties
echo $faker->name;
  // 'Lucy Cechtelar';
echo $faker->address;
  // "426 Jordy Lodge
  // Cartwrightshire, SC 88120-6700"
echo $faker->text;
  // Dolores sit sint laboriosam dolorem culpa et autem. Beatae nam sunt fugit
  // et sit et mollitia sed.
  // Fuga deserunt tempora facere magni omnis. Omnis quia temporibus laudantium
  // sit minima sint.
```

Even if this example shows a property access, each call to `$faker->name` yields a different (random) result. This is because Faker uses `__get()` magic, and forwards `Faker\Generator->$property` calls to `Faker\Generator->format($property)`.

```php
<?php
for ($i = 0; $i < 10; $i++) {
  echo $faker->name, "\n";
}
  // Adaline Reichel
  // Dr. Santa Prosacco DVM
  // Noemy Vandervort V
  // Lexi O'Conner
  // Gracie Weber
  // Roscoe Johns
  // Emmett Lebsack
  // Keegan Thiel
  // Wellington Koelpin II
  // Ms. Karley Kiehn V
```

**Tip**: For a quick generation of fake data, you can also use Faker as a command line tool thanks to [faker-cli](https://github.com/bit3/faker-cli).

## Formatters

Each of the generator properties (like `name`, `address`, and `lorem`) are called "formatters". A faker generator has many of them, packaged in "providers". Here is a list of the bundled formatters in the default locale.

### `Faker\Provider\Base`

    randomDigit             // 7
    randomDigitNot(5)       // 0, 1, 2, 3, 4, 6, 7, 8, or 9
    randomDigitNotNull      // 5
    randomNumber($nbDigits = NULL, $strict = false) // 79907610
    randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL) // 48.8932
    numberBetween($min = 1000, $max = 9000) // 8567
    randomLetter            // 'b'
    // returns randomly ordered subsequence of a provided array
    randomElements($array = array ('a','b','c'), $count = 1) // array('c')
    randomElement($array = array ('a','b','c')) // 'b'
    shuffle('hello, world') // 'rlo,h eoldlw'
    shuffle(array(1, 2, 3)) // array(2, 1, 3)
    numerify('Hello ###') // 'Hello 609'
    lexify('Hello ???') // 'Hello wgt'
    bothify('Hello ##??') // 'Hello 42jz'
    asciify('Hello ***') // 'Hello R6+'
    regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'); // sm0@y8k96a.ej
