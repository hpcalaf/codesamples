<?php

namespace Drupal\webspeech\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
*  Defines Webspeech Controller class
*/

class webspeechController extends ControllerBase {

  /**
   *
   * Display the markup.
   *
   * @return
   * Return markup array.
   *
   */

  /* public function build() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Webspeech Output'),
    ];
  } */

  /**
   * Implements hook_block_view().
   */
  function webspeech_demoPage($delta = '') {
$block = [];

    if ($delta === 'webspeech_block' && user_access('access webspeech')) {
      $str_read_content = 'Read Content';

      $block['content'] = "<button id='sideSprButton' onclick='sideSpr(this);'>" .
        $str_read_content . "</button>
  <button id='sideStopButton' onclick='sideStop()'>Stop</button>";

      module_load_include('module', 'webspeech');
      webspeech_initialize();

      drupal_add_js("
  function sideSpr(elem) {
  if (typeof WebSpeech === 'undefined') {
  return;
  }
  
  var value = elem.innerHTML;
  if (value === '" . $str_read_content . "') {
  WebSpeech.speakHtml('" . variable_get('webspeech_content_id', 'content') . "');
  elem.innerHTML = 'Pause';
  WebSpeech.onfinish = function () {
  document.getElementById('sideSprButton').innerHTML = '" . $str_read_content . "';
  }
  }
  else if (value === 'Pause') {
  WebSpeech.pauseHtml();
  elem.innerHTML = 'Resume';
  }
  else if (value === 'Resume') {
  WebSpeech.resumeHtml();
  elem.innerHTML = 'Pause';
  }
  }
  
  function sideStop() {
  if (typeof WebSpeech !== 'undefined') {
  WebSpeech.stopHtml();
  document.getElementById('sideSprButton').innerHTML = '" . $str_read_content . "';
  }
  }", 'inline');
    }

    return $block;
  }


}