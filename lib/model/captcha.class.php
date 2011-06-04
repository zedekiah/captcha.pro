<?php

class Captcha
{
    /*  
     *  Generate image in /images/captcha/hash.png
     *  return hash
     */
    static function generateImage()
    {
        $groupCount = SynonymGroupTable::getInstance()->count();
        $randGroupNumber = rand(1, $groupCount);
        $wordCount = Doctrine_Query::create()
            ->select('word_id')
            ->from('WordSynonymGroup')
            ->where("synonym_group_id=$randGroupNumber")
            ->count();
        $newImage = imagecreatetruecolor(sfConfig::get('app_images_width')*5, sfConfig::get('app_images_height'));
        $alreadyUsed = array();
        for($i = 0; $i < 5; $i++)
        {
            $randImageNumber = rand(1, sfConfig::get('app_images_perWord')*$wordCount);
            while(in_array($randImageNumber, $alreadyUsed)) {
                $randImageNumber = rand(1, sfConfig::get('app_images_perWord')*$wordCount);
            }
            $src = imagecreatefrompng(sfConfig::get('sf_root_dir').'/web/images/cache/'.$randGroupNumber.'_'.$randImageNumber.'.'.sfConfig::get('app_images_filetype'));
            imagecopy($newImage, $src, $i*sfConfig::get('app_images_width'), 0, 0, 0, imagesx($src), imagesy($src));
            imagedestroy($src);
            $alreadyUsed[] = $randImageNumber;
        }
        $hash = md5(date('dmYhis'));
        imagepng($newImage, sfConfig::get('sf_root_dir').'/web/images/captcha/'.$hash.'.png', 9);
        $validation = new Validation();
        $validation->setHash($hash);
        $validation->setSynonymGroupId($randGroupNumber);
        $validation->save();
        return $hash;
    }
}
