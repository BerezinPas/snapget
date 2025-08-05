<?php
namespace Flynt\Components\DownloadFiles;

add_filter('Flynt/addComponentData?name=DownloadFiles', function ($data) {
    $postId = get_the_ID();
    $filesRaw = get_field('download_files', $postId) ?: [];
    
    $data['hasFiles'] = false;
    $data['files'] = [];
    
    foreach ($filesRaw as $file) {
        // Проверяем наличие всех необходимых данных
        if (!empty($file['file']['ID'])) {
            $fileId = $file['file']['ID'];
            $fileUrl = wp_get_attachment_url($fileId);
            
            if ($fileUrl) {
                $fileName = !empty($file['file_name']) 
                    ? sanitize_text_field($file['file_name'])
                    : get_the_title($fileId);

                $data['files'][] = [
                    'name' => $fileName,
                    'url' => esc_url($fileUrl),
                    'size' => size_format(filesize(get_attached_file($fileId))),
                    'ext' => pathinfo($fileUrl, PATHINFO_EXTENSION)
                ];
                $data['hasFiles'] = true;
            }
        }
    }
    
    return $data;
});