<?php

namespace Flynt\Components\RalatedNews;

use Flynt\Utils\Options;

Options::addTranslatable('RalatedNews', [
  [
      'label' => __('Title', 'flynt'),
      'name' => 'title',
      'type' => 'text',
      'default_value' => __('Ralated news', 'flynt'),
      'required' => 1,
  ],
]);
