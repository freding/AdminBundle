AdminBundle
===========

Create Back-office by annotations in Entities (PHP/Symfony2)
# This bundle allows to create Back-office only with annotations in your Entities.
For PHP / Symfony2

## Features: 
- Doctrine ORM support,
- multi-language for your Front-office,(not only for Back-office)
- Linking your Entities,
- Adding picture,
- generate url key,
- Color, date, rich text...

## Images:
http://gkan.zgroupe.net/image/img1.png
http://gkan.zgroupe.net/image/img2.png
http://gkan.zgroupe.net/image/img3.png


## Installation:
0 - Install symfony 2. Version >= 2.2.0 

- curl -s https://getcomposer.org/installer | php
- php composer.phar create-project symfony/framework-standard-edition ./folder 2.2.4
- configure sql connexion

1 - Adding **"fredb/admin-bundle": "dev-master"**    in require section of your "composer.json"

2 - php composer.phar update

3 - Adding AdminBundle to your Kernel :
 in "/app/AppKernel.php" add this line to $bundles array:

 new Fredb\AdminBundle\FredbAdminBundle(),  

4 - import AdminBundle Route:
 in "/app/config/routing.yml"
 add

     _admin:
          resource: "@FredbAdminBundle/Resources/config/routing.yml"
          prefix:   /


5 - import security context:
 in " /app/config/security.yml"
 put

     imports:
        - { resource: '@FredbAdminBundle/Resources/config/security.yml' }


     security:
        providers:
            in_memory:
                memory:  
                    users:
                        user: { password: mode, roles: 'ROLE_ADMIN' }


6 - import asset:
 in " /app/config/config.yml"
 add

    assetic:
        bundles:        ['FredbAdminBundle']


execute : php app/console assets:install web/ --symlink

7 - create table require for linking Entity/pictures...

    php app/console doctrine:schema:update --force



You can know create your own Entity. 

Have a look to 'Fredb/AdminBundle/annotation/ConcretAnnotations' folder to find what you need to create Back-office.
You can find sample in 'Fredb/AdminBundle/Dummy/Entity'.
Wiki is coming soon.




Contact:
Frédéric Bourbigot

frederic.bourbigot@laposte.net
