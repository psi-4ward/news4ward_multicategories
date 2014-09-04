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
   * @return bool|string
   */
  public function multicategoryFilter()
  {
    if(!$this->Input->get('cat')) return false;

    $cat = urldecode($this->Input->get('cat'));

    return array
    (
      'where'  => 'tl_news4ward_article.categories LIKE ?',
      'values' => array('%"'.$cat.'"%')
    );
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
}
