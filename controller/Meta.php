<?php


class Meta{
    private $url;
    private $title;
    private $description;
    private $image;


    public function create_meta($url, $title, $description, $image){
        //facebook meta
        $app_id = "2626925094036522";
        $meta='';
        $meta.='<title>'.$title.'</title>';
        $meta.='<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $meta.='<meta name="robots" content="NOINDEX, NOFOLLOW">';
        $meta.='<meta property="og:type" content="website">';
        $meta.='<meta property="og:url" content="'.$url.'">';
        $meta.='<meta property="og:title" content="'.$title.'">';
        $meta.='<meta property="og:description" content="'.$description.'">';
        $meta.='<meta property="og:image" content="'.$image.'">';
        $meta.='<meta property="fb:app_id" content="'.$app_id.'">';

        //-- Twitter -->
        $meta.= '<meta property="twitter:card" content="summary_large_image">';
        $meta.= '<meta property="twitter:url" content="'.$url.'">';
        $meta.= '<meta property="twitter:title" content="'.$title.'">';
        $meta.= '<meta property="twitter:description" content="'.$description.'">';
        $meta.= '<meta property="twitter:image" content="'.$image.'">';
        $meta.= '<link rel="icon" type="image/png" href="/public/img/fav.png">';

        echo $meta;
    }
}