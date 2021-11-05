<?php

namespace Drupal\vox\Plugin\Block;
use Drupal\Core\Block\BlockBase;


class VoxBlock extends BlockBase {

    public function build(){
        $data = array(
            "news" =>$this->getNews(),
            "events" =>$this->getEvents(),
        );

        return $data;
    }

    public function getNews(){
        $q = db_select("vox_news", "n");
        $q->Fields("n");
        $q->orderBy("date", "DESC");
        $q->range(0,1);
        $result = $q->execute()->fetchAll();
        
        return $result;
    }

    public function getRelatedNews($category, $limit = 2){
        $q = db_select("vox_news", "n");
        $q->Fields("n");
        $q->condition("category", "%".$category."%", "LIKE");
        $q->range(0,$limit);
        $result = $q->execute()->fetchAll();
        
        return $result;
    }
    
    public function getEvents(){
        $q = db_select("vox_events", "e");
        $q->Fields("e");
        $q->orderBy("startDate", "DESC");
        $q->range(0,2);
        $q->condition("status",array("1","2"), "IN"); // 1=On Going, 2=Soon
        $result = $q->execute()->fetchAll();
        
        return $result;
    }

    public function getRelatedEvents($category, $limit = 2){
        $q = db_select("vox_events", "e");
        $q->Fields("e");
        $q->orderBy("startDate", "DESC");
        $q->range(0,2);
        $q->condition("status",array("1","2"), "IN");
        $q->condition("category", "%".$category."%", "LIKE");
        $q->range(0,$limit);
        $result = $q->execute()->fetchAll();
        
        return $result;
    }


}