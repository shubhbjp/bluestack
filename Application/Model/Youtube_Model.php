<?php
class Youtube_Model extends Model {
  
  private $dbAdapter;
  
  public function __construct() {
    $this->dbAdapter = $this->getDbInstance();
  }

  public function insertYoutubeData($insertArray=[]) {
    if(empty($insertArray)) {
      return;
    }
    try {
      $sql = "INSERT INTO youtube_popular_videos(id,title,label,description,view_count,main_thumbnails,thumbnails) VALUES (:id,:title,:label,:description,:view_count,:main_thumbnails,:thumbnails)";
      $stmt = $this->dbAdapter->prepare($sql);
      $stmt->execute(['id' => $insertArray['id'], 'title' => $insertArray['title'], 'label' => $insertArray['label'], 'description' => $insertArray['description'], 'view_count' => $insertArray['view_count'], 'main_thumbnails' => $insertArray['main_thumbnails'], 'thumbnails' => $insertArray['thumbnails']]);
    } catch (\Exception $e) {
    }
  }

  public function updateYoutubeData($insertArray=[]) {
    if(empty($insertArray)) {
      return;
    }
    try {
      $sql = "UPDATE youtube_popular_videos SET title=:title, label=:label, description=:description, view_count=:view_count,main_thumbnails=:main_thumbnails,thumbnails=:thumbnails WHERE id = :id";
      $stmt = $this->dbAdapter->prepare($sql);
      $stmt->execute(['title' => $insertArray['title'], 'label' => $insertArray['label'], 'description' => $insertArray['description'], 'view_count' => $insertArray['view_count'], 'main_thumbnails' => $insertArray['main_thumbnails'], 'thumbnails' => $insertArray['thumbnails'], 'id' => $insertArray['id']]);
    } catch (\Exception $e) {
    }
  }

  public function getYoutubeData($id) {
    try {
      $sql = "select id from youtube_popular_videos where id in (".$id.")";
      $stmt = $this->dbAdapter->prepare($sql);
      $stmt->execute();
      $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
      return array_column($data, 'id');
    } catch (\Exception $e) {
      return [];
    }
  }

  public function getYoutubeDetails($id) {
    try {
      $sql = "select * from youtube_popular_videos where id = ?";
      $stmt = $this->dbAdapter->prepare($sql);
      $stmt->execute([$id]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
      return [];
    }
  }

}