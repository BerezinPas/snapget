<?php

namespace Flynt\Components\DownloadFiles;

add_action('init', function () {
    \Flynt\ComponentManager::registerComponent(
        'DownloadFiles',
        __DIR__,
        function ($data) {
            return apply_filters('Flynt/addComponentData?name=DownloadFiles', $data);
        }
    );
});