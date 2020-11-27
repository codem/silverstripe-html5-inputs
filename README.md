# HTML5 field classes for Silverstripe

This is module *under development* to provide a set of bare bones HTML5 inputs with no Javascript or CSS.

You can use these fields in your projects as-is or extend them to provide additional features or shims.

The supported inputs are listed at https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input tagged 'HTML5'

+ colour (color)
+ date, datetime, time
+ email (extends core EmailField)
+ month, week
+ number
+ range
+ search
+ tel
+ url

Browser support for these fields is varying although nearly all modern browsers will support these fields to a decent extent.

Date, datetime and time fields are particularly difficult to support, due to locale differences and even different user expectations within those locales.

### Datalist

Certain inputs support a `<datalist>`, [e.g the colour field](./docs/en/002_inputs.md) to restrict initial selection. Browser implementation varies.


## Requirements

+ silverstripe/framework ^4

## Installation

```shell
composer require codem/silverstripe-html5-inputs
```

## License

BSD-3-Clause

See [License](./LICENSE.md)

## Documentation

* [Documentation](./docs/en/001_index.md)


## Configuration

Hopefully none !

## Maintainers

+ Codem


## Bugtracker

Please use the Github issue tracker to report bugs and request features

## Development and contribution

Pull requests and features are most welcome. If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.
