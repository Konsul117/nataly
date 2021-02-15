<?php

namespace common\modules\book\services;

use common\modules\book\models\Book;
use Yii;

class BookFileService
{
    public function save(string $filePath, string $title)
    {
        $content = file_get_contents($filePath);
        $fileId = sha1($content);

        $path = Yii::getAlias('@upload_books_path');
        file_put_contents($path . DIRECTORY_SEPARATOR . $filePath, $content);

        $book = new Book();
        $book->title = $title;
        $book->file_id = $fileId;

        if ($book->save() === false) {
            throw new \Exception('Не удалось сохранить файл: ' . var_export($book->errors, true));
        }
    }
}
