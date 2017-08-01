<?php

namespace Drupal\font_field_icon\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'FontFieldIconDefaultWidget' widget.
 *
 * @FieldWidget(
 *   id = "FontFieldIconDefaultWidget",
 *   label = @Translation("Field with icon"),
 *   field_types = {
 *     "font_field_icon"
 *   }
 * )
 */
class FontFieldIconDefaultWidget extends WidgetBase {

  /**
   * Define the form for the field type.
   *
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    Array $element,
    Array &$form,
    FormStateInterface $formState
  ) {

    $element['font_field_icon'] = [
      '#type' => 'select',
      '#title' => t('Select icon'),
      '#options' => $this->get_icons_from_file(),
      '#default_value' => isset($items[$delta]->font_field_icon) ? $items[$delta]->font_field_icon : NULL,
      '#empty_value' => '',
    ];

    $element['font_field_icon_link'] = [
      '#type' => 'textfield',
      '#title' => t('Text for icon'),
      '#default_value' => isset($items[$delta]->font_field_icon_link) ? $items[$delta]->font_field_icon_link : NULL,
      '#empty_value' => '',
      '#placeholder' => t('Text for icon'),
      '#description' => 'Provide the link e.g. https://twitter.com',
    ];

    return $element;
  }

  /**
   * Get CSS content from the file
   * and return to the Icons select
   */
  public function get_icons_from_file() {
    $filepath = DRUPAL_ROOT . '/libraries/fontawesome/css/font-awesome.css';
    $content = file_exists($filepath) ? file_get_contents($filepath) : '';
    if ($content) {
      // Parse the CSS content
      if (preg_match_all('@\.fa-(.*?):before@m', $content, $matches)) {
        $icons = $matches[1];
        asort($icons);
        return array_combine($icons, $icons);
      }
      else {
        return ['None' => 'Read readme file!'];
      }
    }
    else {
      return ['None' => 'Read readme file!'];
    }
  }
}
