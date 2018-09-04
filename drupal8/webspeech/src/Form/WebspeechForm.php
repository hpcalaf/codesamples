<?php

namespace Drupal\webspeech\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class WebspeechForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'webspeech_form';
  }

  /**
   * Configuration form for WebSpeech.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);

    // Default settings.
    $config = $this->config('webspeech.settings');


    // Page title field.
    $form['page_title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Demo page'),
      '#default_value' => $config->get('webspeech.page_title')
  );

    $form['server'] = array(
      '#type' => 'textfield',
      '#title' => t('WebSpeech server URL'),
      '#default_value' => variable_get('webspeech_server_url',
        'http://wa.eguidedog.net/cgi-bin/ekho.pl'),
    );

    $form['voice-setting-type'] = array(
      '#type' => 'radios',
      '#title' => t('Default voice setting type'),
      '#options' => array('text' => t('text'), 'select' => t('select')),
      '#default_value' => variable_get('webspeech_voice_setting_type', 'select'),
    );

    $form['voice'] = array(
      '#type' => 'textfield',
      '#title' => t('Default voice'),
      '#description' => t('Voice value should be supported by WebSpeech server. Default server supports "EkhoMandarin", "EkhoCantonese", "EkhoTibetan", "EkhoKorean" and any voice value supported by eSpeak like "en", "fr", "de+f2" etc.'),
      '#default_value' => variable_get('webspeech_default_voice', 'en'),
      '#states' => array(
        'visible' => array(
          ':input[name="voice-setting-type"]' => array('value' => 'text'),
        )),
    );

    $form['voice-select'] = array(
      '#type' => 'select',
      '#title' => t('Default voice'),
      '#description' => t('This is an incomplete selections of default WebSpeech server. It may not supported by other server. Please supplied the voice parameter in text rather than selection if this list does not apply your case.'),
      '#states' => array(
        'visible' => array(
          ':input[name="voice-setting-type"]' => array('value' => 'select'),
        )),
      '#default_value' => variable_get('webspeech_default_voice', 'en'),
      '#options' => array(
        'EkhoMandarin' => t('Mandarin (Standard Chinese, Yali)'),
        'EkhoCantonese' => t('Cantonese (Wong)'),
        'EkhoEnglish' => t('English (kal_diphone)'),
        'EkhoHakka' => t('Hakka'),
        'EkhoNgangien' => t('Ngangien (Ancient Chinese)'),
        'EkhoTibetan' => t('Tibetan'),
        'EkhoKorean' => t('Korean'),
        'af' => t('Afrikaans'),
        'bs' => t('Bosnian'),
        'ca' => t('Catalan'),
        'cs' => t('Czech'),
        'cy' => t('Welsh'),
        'da' => t('Danish'),
        'de' => t('German'),
        'el' => t('Greek'),
        'en' => t('English'),
        'en-sc' => t('English (Scottish)'),
        'en-uk' => t('English (UK)'),
        'en-uk-north' => t('English (Lancashire)'),
        'en-uk-rp' => t('English (uk-rp)'),
        'en-uk-wmids' => t('English (wmids)'),
        'en-us' => t('English (US)'),
        'en-wi' => t('English (West Indies)'),
        'eo' => t('Esperanto'),
        'es' => t('Spanish'),
        'es-la' => t('Spanish (Latin American)'),
        'fi' => t('Finnish'),
        'fr' => t('French'),
        'fr-be' => t('French (Belgium)'),
        'grc' => t('Greek (ancient)'),
        'hi' => t('Hindi'),
        'hr' => t('Croatian'),
        'hu' => t('Hungarian'),
        'hy' => t('Armenian'),
        'hy-west' => t('Armenian (west)'),
        'id' => t('Indonesian'),
        'is' => t('Icelandic'),
        'it' => t('Italian'),
        'jbo' => t('Lojjban'),
        'ku' => t('Kurdish'),
        'la' => t('Latin'),
        'lv' => t('Latvian'),
        'mk' => t('Macedonian'),
        'nci' => t('Nahuatl (classical)'),
        'nl' => t('Dutch'),
        'no' => t('Norwegian'),
        'pap' => t('Papiamento'),
        'pl' => t('Polish'),
        'pt' => t('Brazil'),
        'pt-pt' => t('Portugal'),
        'ro' => t('Romanian'),
        'ru' => t('Russian'),
        'sk' => t('Slovak'),
        'sq' => t('Albanian'),
        'sr' => t('Serbian'),
        'sv' => t('Swedish'),
        'sw' => t('Swahihi'),
        'ta' => t('Tamil'),
        'tr' => t('Turkish'),
        'vi' => t('Vietnam'),
        'zh' => t('Mandarin (eSpeak)'),
        'zh-yue' => t('Cantonese (eSpeak)'),
      ),
    );

    if (!webspeech_initialize()) {
      drupal_set_error(t('Fail to initialize WebSpeech.', 'error'));
    }

    $form['test-text'] = array(
      '#type' => 'textfield',
      '#title' => t('Text for testing'),
      '#prefix' => '<div class="container-inline">',
    );

    $form['test-button'] = array(
      '#type' => 'button',
      '#value' => t('test'),
      '#suffix' => '</div>',
      '#attributes' => array('onclick' => 'testWebSpeech(); return false;'),
    );

    drupal_add_js('
  function testWebSpeech() {
    var voice = "";
    if (jQuery("#edit-voice-setting-type-text").attr("checked")) {
      voice = jQuery("#edit-voice").val();
    }
    else {
      voice = jQuery("#edit-voice-select option:selected").val();
    }
    
    WebSpeech.setVoice(voice);
    WebSpeech.speak(jQuery("#edit-test-text").val());
  }', 'inline');

    $form['content-id'] = array(
      '#type' => 'textfield',
      '#title' => t('Element ID'),
      '#description' => t('It\'s the id attribute of an HTML element. Content in the DOM tree of this element will be read after "Read Content" button is clicked.'),
      '#default_value' => variable_get('webspeech_content_id', 'content'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    variable_set('webspeech_server_url', $form_state['values']['server']);
    variable_set('webspeech_content_id', $form_state['values']['content-id']);
    variable_set('webspeech_voice_setting_type', $form_state['values']['voice-setting-type']);

    if ($form_state['values']['voice-setting-type'] == 'select') {
      variable_set('webspeech_default_voice', $form_state['values']['voice-select']);
    }
    else {
      // 'text' type.
      variable_set('webspeech_default_voice', $form_state['values']['voice']);
    }

    drupal_set_message(t('The configuration has been successfully changed.'));
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'webspeech.settings',
    ];
  }

}