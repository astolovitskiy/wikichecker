<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 9/2/14
 * Time: 5:04 PM
 * To change this template use File | Settings | File Templates.
 */

class PageController extends CrudController {

  /**
   * @var null
   */
  protected  $_model = 'Page';

  /**
   * @var null
   */
  protected $_form = 'Page';

  /**
   * @var null
   */
  protected $_formPath = '//page/form';

  /**
   * @var null
   */
  protected $_indexTitle = 'WikiChecker Pages';

  /**
   * @var null
   */
  protected $_updateTitle = 'WikiChecker Create/Edit Page';

}