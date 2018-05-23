MukadiSettingsBundle
=======================

this bundle provide a global app settings form fully customisable.

You can render the settings form in admin page for example. The form building is centralized under the bundle configuration.

Features:

- Settings can be stored via Doctrine ORM.
- Form building centralized in config files (e.g: config.xml or an imported settings.yml file)
- A Service for querying stored settings.


Installation
------------

if you want to use symfony flex run the following command in your project:

``` bash
$ composer config extra.symfony.allow-contrib true
```

Install the bundle via composer by running the command:

``` bash
$ composer require mukadi/settings-bundle
```

If you're not using Symfony Flex, you must follow next instructions to configure the bundle yourself.

Configuration
-------------

## Enable the bundle in the kernel:

``` php
<?php
// config/bundles.php
return [
        // ...
       Mukadi\SettingsBundle\MukadiSettingsBundle::class => ['all' => true],
    ];
```
## Create the Param class

First, create your Param class by extending the base `Param` class (the class to use depends of your storage)

``` php
<?php
// src/Entity/Param.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mukadi\SettingsBundle\Entity\Param as Base;
/**
 * Param
 *
 * @ORM\Table(name="param")
 */
class Param extends Base
{

}
```

## Add packages configuration file

Configure the bundle for using this class, and optionnaly specifying the current Object Manager used by the application, if 'manager' key is missing the default Doctrine entity manager will be used:

``` yaml
# config/packages/mukadi_settings.yaml
mukadi_settings:
    manager: app.my_custom_manager
    param_class: App\Entity\Param
```

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a new entity.
For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

Build the form
--------------

Below is a minimal example of the necessary configuration for build a settings form:

``` yaml
# config/packages/mukadi_settings.yaml
mukadi_settings:
    param_class: App\Entity\Param
    settings:
        currency: # the setting key
            type: choice # the form field type
            options: # options to provide to the field
                label: Devise
                choices: '(USD: Dollar US,CDF: Francs Congolais)' # use this notation for setting up the choice list
        bio:
            type: textarea
            options:
                label: 'About me'
        age:
            type: integer
            options:
                label: Age
        post:
            type: entity
            options:
                label: Article
                choice_label: title
                class: App\Entity\Post
```

The currently supported types are:

- text : simple text field, save setting as plain text in the database
- integer : input for integer
- toggle : a simple checkbox
- number: input for number (decimals and float)
- textarea: multi-lines text input
- entity: for select an entity in the database. The bundle store only the `id`.

Usage
-----

Now that you have properly create your settings form. You can render it a custom `SonataAdminBundle` action page, or in any view in your application:
In the controller use the `mukadi_settings.setting` service for getting the form (Or use the `Mukadi\SettingsBundle\Model\Setting` class if you're using the autowiring)

``` php
<?php
// src/Controller/AppController.php

...
$setting = $this->get('mukadi_settings.setting');
$form = $setting->getForm();
```

And in your view, render the form like any other form:

``` html+jinja
{# app/Resources/views/default/form.html.twig #}
{{ form_start(form) }}
    {{ form_widget(form) }}
    <button type="submit">save settings</button>
{{ form_end(form) }}
```

When the form is submitted, in your controller you must handle that request if you want to store the updated settings in your database.

``` php
<?php
// src/Controller/AppController.php

...
$setting = $this->get('mukadi_settings.setting');
$form = $setting->getForm();
$form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()){
    $setting->saveData($form); # store the update in the database
}
```

And finally you can retrieve the stored data via the `mukadi_settings.setting` service like this:

``` php
<?php
// src/Controller/AppController.php
...
$setting = $this->get('mukadi_settings.setting');
$currency = $setting->get('currency'); // return 'USD' or 'CDF'
$bio = $setting->get('bio'); // return a string
$node = $setting->get('post'); // return null or a App\Entity\Post entity as configured
```
