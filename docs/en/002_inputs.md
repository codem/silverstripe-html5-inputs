## Input examples

> Note: the inputs are rendered by the browser native controls

## Colour field

> [Support Matrix](https://caniuse.com/input-color)

+ This field only supports 6chr hex values as per the W3C spec.

```php
// or ColorField if you are en-us
$fields->addFieldToTab(
        'Root.Main'
        ColourField::create('TertiaryColour')
);
```
### Example HTML

```html
<input type="color" id="field" name="field" value="#00bedf">
```
If your markdown interpreter renders this, you will see an HTML colour picker field:

<input type="color" id="field" name="field" value="#00bedf">

<hr>

![Colour Field output in Chrome](../img/colourfield.png)

<hr>

With a `<datalist>`, although note that browsers will allow other colours to be picked:

```html
<input type="color" id="field" name="field" value="#00bedf" list="colours">
<datalist id="colours">
  <option>#ff0000</option>
  <option>#0000ff</option>
  <option>#00ff00</option>
  <option>#ffff00</option>
  <option>#00ffff</option>
</datalist>
```

Again, an HTML example:

<input type="color" id="field" name="field" value="#00bedf" list="colours">
<datalist id="colours">
  <option>#ff0000</option>
  <option>#0000ff</option>
  <option>#00ff00</option>
  <option>#ffff00</option>
  <option>#00ffff</option>
</datalist>

<hr>

No need for fancy JS pickers when the browser can do it just as easily. Non supporting browsers will fallback to a text input field.

## URL Field

A good starting point is the `URLFieldTest` class:

```php
$url = 'ftp://www.example.com/path?foo=bar';
$field = UrlField::create('TestURL', 'Test URL', $url);
$pattern = "^ftp://.+\.com";
$phpPattern = "|^ftp://.+\.com|";
$field->setPattern($pattern, $phpPattern);
```

## Methods available

+ `setRequiredParts` - provide an array of URL parts the URL must have for validation to pass, the values being the keys from `parse_url()`
+ `setPattern` - set complex and mystifying URL regular expression patterns in both JS and PHP
+ `setSchemes` - set an array of schemes that the URL must start with (eg. `['blob', 'dict', 'dns']`)
+ `restrictToHttp` - shorthand method, the URL must start with http:// OR https://
+ `restrictToHttps` - shorthand method, the URL must start with https://
