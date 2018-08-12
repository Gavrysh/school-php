<?php

class Images 
{

//Завантаження файлу на сервер
//на вході:
//$image - назва файлу
//$tmpImg - шлях до тимчасового файлу
//на виході:
//$result - array

    static function uploadImg($image, $tmpImg) 
    {
        $result = array(
            'new_name'  => 'noname'
        );
        //Папка для завантажених файлів
        $uploaddir = './uploaded/';
        //Допустимі розміри зображення для перетворення у байтах
        $max_size = 5000000;
        $min_size = 500;
        
        //Дізнаємось про розмір файлу
        $f_size = filesize($tmpImg);
        if ($f_size < $min_size || $f_size > $max_size) {
            $result['error'] = 'Розмір файлу не відповідає вимогам системи '.$f_size.'<br>';
            return $result;
        }
        
        //Дізнаємось про розширення файлу - jpg, jpeg, png, або gif
        if (!preg_match('#\.jpe?g$|\.png$|\.gif$#ui', $image, $matches_ext)) {
            $result['error'] = 'Розширення файлу не відповідає вимогам системи.';
            return $result;
        }

        //Витягуємо інфу про mime-тип файлу
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $f_mime_type = finfo_file($finfo, $tmpImg);
        finfo_close($finfo);
        
        //Та перевіремо чи дійсно це зображення
        if (!($f_mime_type == 'image/jpeg' || $f_mime_type == 'image/png' || $f_mime_type == 'image/gif')) {
            $result['error'] = 'Тип файлу не відповідає вимогам системи.';
            return $result;
        }

        //Присвоюємо нове ім'я файлу
        $result['new_name'] = date('Ymd-His').'img'.rand(10000, 99999).$matches_ext[0];
        if (!move_uploaded_file($tmpImg, $uploaddir.$result['new_name'])) {
            $result['error'] = 'Помилка завантаження файлу.';
            $result['new_name'] = 'noname';
            return $result;
        }

        return $result;
    }

//Зміна розміру зображення 
//на вході:
//$path - шлях до файлу /uploaded/image-name.*
//$width - бажана(нова) довжина
//$height - бажана(нова) висота
//$fldr - підпапка у ./uploaded/ повинна бути попередньо створена
//на виході:
//$result - array
//оригінальний файл зберігається у /uploaded/$fldr/image-name.*
    
    static function resizeImg($path, $width, $height, $fldr) 
    {
        $result = array(
            'message' => 'ok'
        );
        //Перевірка наявності файлу
        if (file_exists($path)) {
            preg_match('#\.([a-z]+)$#iu', $path, $matches);
            $ext = $matches[1];
            $size = getimagesize($path);

            //Розраховуємо новий розмір, враховуючи пропорції
            $ratio_orig = $size[0]/$size[1];
            if ($width/$height > $ratio_orig) {
               $width = $height*$ratio_orig;
            } else {
               $height = $width/$ratio_orig;
            }

            //Створюємо повнокольорове зображення
            $imgNS = imagecreatetruecolor($width, $height);

            switch ($ext) {
                case 'jpg': case 'jpeg':
                    //Створення нового зображення з файлу
                    $imgCr = imagecreatefromjpeg($path);
                    //Копіювання та зміна розміру зображення з ресемпліруванням
                    imagecopyresampled($imgNS, $imgCr, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
                    //Запис зображення у файл
                    imagejpeg($imgNS, './uploaded/'.$fldr.'/'.basename($path));
                    break;
                case 'png':
                    $imgCr = imagecreatefrompng($path);
                    //Відключаємо режим сполучення кольорів
                    imagealphablending($imgNS, false);
                    //Включаємо збереження альфа каналу
                    imagesavealpha($imgNS, true);
                    imagecopyresampled($imgNS, $imgCr, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
                    imagepng($imgNS, './uploaded/'.$fldr.'/'.basename($path));
                    break;
                case 'gif':
                    $imgCr = imagecreatefromgif($path);
                    //Отримуємо прозорий колір
                    $transparent_source_index = imagecolortransparent($imgCr);
                    //Перевіряємо наявність прозорості
                    if ($transparent_source_index !== -1) {
                        $transparent_color = imagecolorsforindex($imgCr, $transparent_source_index);
                        //Додаємо колір у палітру нового зображення та встановлюємо його як прозорий
                        $transparent_destination_index = imagecolorallocate($imgNS, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                        imagecolortransparent($imgNS, $transparent_destination_index);
                        //На всяк випадок заливаємо фон цим коліром
                        imagefill($imgNS, 0, 0, $transparent_destination_index);
                    }
                    imagecopyresampled($imgNS, $imgCr, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
                    imagegif($imgNS, './uploaded/'.$fldr.'/'.basename($path));
                    break;
                default:
                    $result['message'] = 'Невірний формат файлу!';
                    break;
            }
            //Знищення зображення
            imagedestroy($imgNS);
        } else {
            $result['message'] = 'Файл '.$path.' не існує!';
        }
        return $result;
    }
}