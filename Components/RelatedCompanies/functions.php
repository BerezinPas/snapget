<?php

namespace Flynt\Components\RelatedCompanies;

use Flynt\Utils\Options;

Options::addTranslatable('RelatedCompanies', [
  [
      'label' => __('Title', 'flynt'),
      'name' => 'title',
      'type' => 'text',
      'default_value' => __('Related companies', 'flynt'),
      'required' => 1,
  ],
]);
