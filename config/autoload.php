<?php

/**
 * News4ward
 * a contentelement driven news/blog-system
 *
 * @author Christoph Wiechert <wio@psitrax.de>
 * @copyright 4ward.media GbR <http://www.4wardmedia.de>
 * @package news4ward_multicategories
 * @filesource
 * @licence LGPL
 */


// Register the namespace
ClassLoader::addNamespace('Psi');

// Register the classes
ClassLoader::addClasses(array
(
  'Psi\News4ward\Module\Multicategories'     => 'system/modules/news4ward_multicategories/Module/Multicategories.php',
  'Psi\News4ward\MulticategoriesHelper'      => 'system/modules/news4ward_multicategories/MulticategoriesHelper.php',
));

// Register the templates
TemplateLoader::addFiles(array
(
  'mod_news4ward_multicategories'            => 'system/modules/news4ward_multicategories/templates',
));
