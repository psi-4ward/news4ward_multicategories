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

// Field
$GLOBALS['TL_DCA']['tl_news4ward_article']['fields']['categories'] = array
(
  'label'             => &$GLOBALS['TL_LANG']['tl_news4ward_article']['categories'],
  'inputType'         => 'checkbox',
  'exclude'           => true,
  'options_callback'  => array('News4ward\MulticategoriesHelper', 'getCategories'),
  'eval'              => array('includeBlankOption'=>true, 'multiple'=>true, 'tl_class'=>'w50')
);


// Palette
$GLOBALS['TL_DCA']['tl_news4ward_article']['palettes']['default'] = str_replace(
  ';{layout_legend}',
  ';{categories_legend},categories;{layout_legend}',
  $GLOBALS['TL_DCA']['tl_news4ward_article']['palettes']['default']
);


