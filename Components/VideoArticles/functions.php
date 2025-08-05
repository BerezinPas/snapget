<?php

namespace Flynt\Components\VideoArticles;

use Flynt\Utils\Options;

Options::addTranslatable('VideoArticles', [
    [
        'label' => __('Load More', 'flynt'),
        'name' => 'load_more',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('Load More', 'flynt'),
    ],
]);
