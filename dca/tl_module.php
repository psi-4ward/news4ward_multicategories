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


// news4wardMulticategories Palette
$GLOBALS['TL_DCA']['tl_module']['palettes']['news4wardMulticategories']    = '{title_legend},name,headline,type;{config_legend},news4ward_archives,news4ward_categoryFilter,news4ward_filterHint;{redirect_legend},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['news4ward_categoryFilter'] = array(
  'label'             => &$GLOBALS['TL_LANG']['tl_module']['news4ward_categoryFilter'],
  'inputType'         => 'checkbox',
  'options_callback'  => array('News4ward\MulticategoriesHelper', 'getCategories'),
  'eval'              => array('includeBlankOption' => true, 'tl_class' => 'clr', 'multiple' => true)
);

// listing Palette
$GLOBALS['TL_DCA']['tl_module']['palettes']['news4wardList'] = str_replace(
  ',news4ward_ignoreFilters',
  ',news4ward_ignoreFilters,news4ward_categoryFilter',
  $GLOBALS['TL_DCA']['tl_module']['palettes']['news4wardList']
);

$GLOBALS['TL_DCA']['tl_module']['fields']['news4ward_archives']['eval']['submitOnChange'] = true;