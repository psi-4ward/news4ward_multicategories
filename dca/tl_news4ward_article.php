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
  'options_callback'  => array('tl_news4ward_multicategories','getCategories'),
  'eval'              => array('includeBlankOption'=>true, 'multiple'=>true, 'tl_class'=>'w50')
);


// Palette
$GLOBALS['TL_DCA']['tl_news4ward_article']['palettes']['default'] = str_replace(
  ';{layout_legend}',
  ';{categories_legend},categories;{layout_legend}',
  $GLOBALS['TL_DCA']['tl_news4ward_article']['palettes']['default']
);


/**
 * Class tl_news4ward_multicategories
 * Helperclass to receive the multicategories defined in a news4ward-archive
 */
class tl_news4ward_multicategories extends System
{

  /**
   * Fetch all multicategories for the current archive
   * @param Data_Container $dc
   * @return array
   */
  public function getCategories($dc)
  {
    $cats = array();
    $multicategories = \Database::getInstance()
                            ->prepare('SELECT categories FROM tl_news4ward WHERE id=?')
                            ->execute($dc->activeRecord->pid);
    $multicategories = deserialize($multicategories->categories, true);
    foreach($multicategories as $v)
    {
      $cats[] = $v['multicategory'];
    }
    return $cats;
  }
}
