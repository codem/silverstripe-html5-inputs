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

<input type="color" id="field" name="field" value="#00bedf" list="colours">
<datalist id="colours">
  <option>#ff0000</option>
  <option>#0000ff</option>
  <option>#00ff00</option>
  <option>#ffff00</option>
  <option>#00ffff</option>
</datalist>
