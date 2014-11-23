<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 01.06.13
 * Time: 19:41
 */

class CheckWikiCommand extends CConsoleCommand {

  /**
   * @return int|void
   */
  public function run() {
    foreach(Page::model()->findAll() as $page) {
      $content = $this->parseContentHtml($this->getContent($page));

      if(! $page->lastVersion || strip_tags($page->lastVersion->getContent()) != strip_tags($content))
        $this->addNewVersion($page, $content);
    }
  }

  /**
   * @param Page $page
   * @return string
   */
  private function getContent($page) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $page->url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
  }

  /**
   * @param string $content
   * @return string
   */
  private function parseContentHtml($content) {
    libxml_use_internal_errors(true);
    $domDocument = new DOMDocument();
    $domDocument->loadHTML($content);
    $newDocument = new DOMDocument();
    $cloned = $domDocument->getElementById('content')->cloneNode(TRUE);
    $newDocument->appendChild($newDocument->importNode($cloned, TRUE));
    $html = $newDocument->saveHTML();
    libxml_clear_errors();
    return $html;
  }

  /**
   * @param Page $page
   * @param string $content
   */
  private function addNewVersion($page, $content) {
    $pageVersion = new PageVersion();
    $pageVersion->page_id = $page->id;
    $pageVersion->save();
    file_put_contents($pageVersion->getFilePath(), $content);
    $pageVersion->sendNotification();
  }
}

