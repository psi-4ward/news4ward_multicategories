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


namespace Psi\News4ward;

class MulticategoriesHelper extends \Controller
{

  protected static $arrJumpTo = array();

  /**
   * Return the WHERE-condition if a the url has an cat-parameter
   * @param \News4ward\Module\Listing $objModule
   * @return bool|string
   */
  public function multicategoryFilter($objModule)
  {
    if($this->Input->get('cat')) {
      $cat = urldecode($this->Input->get('cat'));
      return array
      (
        'where'  => 'tl_news4ward_article.categories LIKE ?',
        'values' => array('%"'.$cat.'"%')
      );
    } else if($objModule->news4ward_categoryFilter) {
      $cats = deserialize($objModule->news4ward_categoryFilter, true);
      $where = array();
      $values = array();
      foreach($cats as $cat) {
        $where[] = 'tl_news4ward_article.categories LIKE ?';
        $values[] = '%"'.$cat.'"%';
      }

      return array
      (
        'where'  => implode(' OR ', $where),
        'values' => $values
      );
    }

    return false;
  }


  /**
   * Add multicategory link to the template
   *
   * @param \Psi\News4ward\Module\Module $obj
   * @param array $arrArticle
   * @param FrontendTemplate $objTemplate
   */
  public function multicategoriesParseArticle($obj, $arrArticle, $objTemplate)
  {
    if(!isset(self::$arrJumpTo[$arrArticle['pid']])) {
      $this->import('Database');
      $objJumpTo = $this->Database->prepare('SELECT tl_page.id, tl_page.alias
                                                   FROM tl_page
                                                   LEFT JOIN tl_news4ward ON (tl_page.id=tl_news4ward.jumpToList)
                                                   WHERE tl_news4ward.id=?')
                                  ->execute($article['pid']);
      if($objJumpTo->numRows) {
        self::$arrJumpTo[$arrArticle['pid']] = $objJumpTo->row();
      }
      if(!self::$arrJumpTo[$arrArticle['pid']]) {
        self::$arrJumpTo[$arrArticle['pid']] = $GLOBALS['objPage']->row();
      }
    }

    $cats = deserialize($arrArticle['categories'], true);

    $erg = [];
    foreach($cats as $cat) {
      $erg[] = array(
        'title' => $cat,
        'href'  => $this->generateFrontendUrl(self::$arrJumpTo[$arrArticle['pid']], '/cat/'.urlencode($cat))
      );
    }

    $objTemplate->categories = $erg;
  }


  /**
   * Fetch all multicategories for the current archive
   *
   * @param Data_Container $dc
   * @return array
   */
  public function getCategories($dc)
  {
    $archives = deserialize($dc->activeRecord->news4ward_archives, true);

    $cats = array();
    $objArchives = \Database::getInstance()
                                ->prepare('SELECT categories FROM tl_news4ward WHERE FIND_IN_SET(id,?)')
                                ->execute(implode(',', $archives));

    while($objArchives->next()) {
      foreach(deserialize($objArchives->categories, true) as $v) {
        $cats[] = $v['category'];
      }
    }
    return $cats;
  }
}
