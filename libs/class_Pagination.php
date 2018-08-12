<?php

class Pagination 
{
    static $onpage = 10;
    static $pages = 1;
    static $curpage = 1;
    static $start = 0;
    static $params = array(
        'next' => true,
        'prev' => false,
        'start' => 1,
        'end' => 1,
        'move' => 2
    );
    
    static function q($query)
    {
        if (is_int(self::$curpage) && self::$curpage != 0) {
            self::$start = (self::$curpage-1)*self::$onpage;
            if (self::$start < 0) {
                self::$start = 0;
            }

            $res = q(preg_replace('#^\s*SELECT#usU','SELECT SQL_CALC_FOUND_ROWS',$query).' LIMIT '.self::$start.','.self::$onpage);
            $res_count = q("SELECT FOUND_ROWS()");
            $row_count = $res_count->fetch_row();
            $res_count->close();

            self::$pages = ceil($row_count[0]/self::$onpage);

            if (!$res->num_rows) {
                self::$curpage = 1;
                header("Location: /errors/404");
                exit();
            }

            return $res;
        } else {
            self::$curpage = 1;
            header("Location: /errors/404");
            exit();
        }
    }

    static function navi($module, $page, $addon='')
    {
        $text = '';
        self::$params['start'] = 2;
        self::$params['end'] = self::$pages - 1;

        if (isset(self::$curpage) && self::$curpage <= 1) {
            $text = '<a class="disabled-link" href="/'.$module.'/'.$page.(empty($addon)?$addon:'').'"><<</a>';
        } else {
            $text = '<a href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag=':'&pag=').(self::$curpage-1).'"><<</a>';
        }

        if ((isset(self::$curpage) && self::$curpage == 0) || !isset(self::$curpage) || self::$curpage == 1) {
            $text .= '<a class="active-link" href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag':'&pag').'=1">1</a>';
        } else {
            $text .= '<a href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag':'&pag').'=1">1</a>';
        }

        if (self::$curpage+(self::$params['move']+1) < self::$pages) {
            self::$params['next'] = true;
        } else {
            self::$params['next'] = false;
        }

        if (self::$curpage-(self::$params['move']+1) > 1) {
            self::$params['prev'] = true;
        } else {
            self::$params['prev'] = false;
        }

        if (self::$params['next'] == true && self::$params['prev'] == false) {
            self::$params['start'] = 2;
            self::$params['end'] = self::$curpage + self::$params['move'];
        } elseif (self::$params['next'] == false && self::$params['prev'] == false) {
            self::$params['start'] = 2;
            self::$params['end'] = self::$pages - 1;
        } elseif (self::$params['next'] == false && self::$params['prev'] == true) {
            self::$params['start'] = self::$curpage - self::$params['move'];
            self::$params['end'] = self::$pages - 1;
        }
        
        if (self::$params['prev']) {
                $text .= '<a class="ellipses-show" href="...">...</a>';
            }
        
        for ($i=self::$params['start']; $i <= self::$params['end']; $i++) {
            if ($i==self::$curpage) {
                $text .= '<a class="active-link" href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag=':'&pag=').$i.'">'.$i.'</a>';
            } else {
                $text .= '<a href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag=':'&pag=').$i.'">'.$i.'</a>';
            }
        }
        
        if (self::$params['next']) {
            $text .= '<a class="ellipses-show" href="...">...</a>';
        }

        if (self::$curpage == self::$pages) {
          $text .= '<a class="active-link" href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag=':'&pag=').self::$pages.'">'.self::$pages.'</a>';
        } else {
          $text .= '<a href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag=':'&pag=').self::$pages.'">'.self::$pages.'</a>';
        }

        if (isset(self::$curpage) && self::$curpage < self::$pages) {
            $text .= '<a href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag=':'&pag=').(self::$curpage + 1).'">>></a>';
        } else {
          $text .= '<a class="disabled-link" href="/'.$module.'/'.$page.(!empty($addon)?$addon:'').(empty($addon)?'?pag=':'&pag=').self::$curpage.'">>></a>';
        }

        if (self::$pages >= self::$params['move']) {
            return $text;
        }
    }
}