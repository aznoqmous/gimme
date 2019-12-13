# Gimme
PHP save file from URL + recreate url directories

## Usage
```php
<?php

require './vendor/autoload.php'

use Aznoqmous\Gimme;

// chose folder where to put images
$g = new Gimme([
  'dir' => 'public'
]);

// save img.jpg under public/a/b/c/img.jpg
$g->save('https://domain.org/a/b/c/img.jpg');

```
