# VGreen Application - Vcore Module

## Installation
```bash
composer require willvrd/vcore-module
```

## Steps

    1. Install laravel localization (Config Files, Register Middleware)
https://github.com/mcamara/laravel-localization#installation

    2. Change true 'hideDefaultLocaleInURL' => true

    3. Publish config/translatable.php
```bash  
php artisan vendor:publish --tag=translatable
``` 
        
## Assets Module

    - Install and Setup:
https://nwidart.com/laravel-modules/v6/basic-usage/compiling-assets


## Frontend Components

### Loading

    - Add in your component:

```html
<section v-if="loading"><loading></loading></section>
```

### Alert

    - Add in your component:

```html
<alert :alert="{status:true,type:'alert-danger',text: 'Error sorry',dismissible:true}"></alert>
```
