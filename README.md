# HTML5 field classes for Silverstripe

This module provides a set of bare bones HTML5 inputs with no Javascript or CSS.

You can use these fields in your projects as-is or extend them to provide additional features or shims.

The supported inputs are listed at https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input:

+ colour (color)
+ date, datetime-local, time
+ email (extends core Silverstripe EmailField)
+ month, week
+ number
+ range
+ search
+ tel
+ url

Browser support for these fields is varying although nearly all modern browsers will support these fields to a decent extent.

Date, datetime and time fields are particularly difficult to support, due to locale differences and even different user expectations within those locales.

## Traits

Various field types support certain traits that allow setting/getting of common attributes

+ Step - https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#step
+ DataList - https://developer.mozilla.org/en-US/docs/Web/HTML/Element/datalist
+ Spellcheck - https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/spellcheck
+ Min/Max - https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#min / max
+ Pattern - https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#pattern
+ Multiple - https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#multiple

### Datalist

Certain inputs support a `<datalist>`, [e.g the colour field](./docs/en/002_inputs.md) to restrict initial selection.

This works somewhat like a `<select>` element, except that browser implementation and support varies.


## Requirements

+ silverstripe/framework ^5 (>= v1)
+ silverstripe/framework ^4 (< v1)

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
