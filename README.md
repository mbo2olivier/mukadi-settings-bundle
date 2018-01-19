MukadiSettingsBundle
=======================

this bundle provide a global app settings form fully customisable.

You can render the settings form in admin page for example. The form building is centralized under the bundle configuration.

Features:

- Settings can be stored via Doctrine ORM, MongoDB/CouchDB ODM or Propel
- Form building centralized in config files (e.g: config.xml or an imported settings.yml file)
- A Service for querying stored settings.

**Note:** At this time, only Doctrine ORM support implemented.

Installation
------------

This version of the bundle requires Symfony 2.8+ and PHP 5.5+.

Install the bundle via composer by running the command:

``` bash
$ php composer.phar require mukadi/settings-bundle
```

Enable the bundle in the kernel:


``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
       new Mukadi\SettingsBundle\MukadiSettingsBundle(),
    );
}
```

Configuration
-------------

First, create your Param class by extending the base `Param` class (the class to use depends of your storage)

``` php
<?php
// src/AppBundle/Entity/Param.php

namespace AppBundle\Entity;

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

And configure the bundle for using this class, and specifying the current Object Manager used by the application:

``` yaml
# app/config/config.yml
mukadi_settings:
    manager: doctrine.orm.entity_manager
    param_class: AppBundle\Entity\Param
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
# app/config/config.yml
mukadi_settings:
    manager: doctrine.orm.entity_manager
    param_class: AppBundle\Entity\Param
    settings:
        currency: # the setting key
            type: choice # the form field type
            options: # options to provide to the field
                label: Devise
                choices: (USD: Dollar US,CDF: Francs Congolais) # use this notation for setting up the choice list
        bio:
            type: text
            options:
                label: Ma bio
        age:
            type: number
            options:
                label: Age
        node:
            type: entity
            options:
                label: Entité
                property: name
                class: AppBundle\Entity\Node
```

The currently supported types are:

- text : simple text field, save setting as plain text in the database
- integer : input for integer
- number: input for number (decimals and float)
- textarea: multi-lines text input
- entity: for select an entity in the database. The bundle store only the `id`.

Usage
-----

Now that you have properly create your settings form. You can render it a custom `SonataAdminBundle` action page, or in any view in your application:
In the controller use the `mukadi_settings.setting` service for getting the form

``` php
<?php
// src/AppBundle/Controller/DefaultController.php

...
$setting = $this->get('mukadi_settings.setting');
$form = $setting->getForm();
```

And in your view, render the form like any other form:

``` html+jinja
{# app/Resources/views/default/form.html.twig #}
{{ form_start(form) }}
    {{ form_widget(form) }}
    <button type="submit">save setiings</button>
{{ form_end(form) }}
```

When the form is submitted, in your controller you must handle that request if you want to store the updated settings in your database.

``` php
<?php
// src/AppBundle/Controller/DefaultController.php

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
// src/AppBundle/Controller/DefaultController.php
...
$setting = $this->get('mukadi_settings.setting');
$currency = $setting->get('currency'); // return 'USD' or 'CDF'
$bio = $setting->get('bio'); // return a string
$node = $setting->get('node'); // return null or a AppBundle\Entity\Node entity as configured
```
