<?php

class Youtube_Controller extends Controller{
    
    private $youtubeModel;
    private $parserModule;
    
    public function __construct() {
      parent::__construct();
      $this->youtubeModel = new Youtube_Model();
      $this->parserModule = new Parser_Module();
    }
    
    public function listPopularYoutubeVideos() {
      try {
        $poularYoutubeVideos = $this->parserModule->getPopularListVideos();
        if(empty($poularYoutubeVideos)) {
          Common::sendResponse(Constants::API_ERROR, Codes::YOUTUBE_POPULAR_PARSER_FAILED);
        } else {
          $allYoutubeVideosId = array_column($poularYoutubeVideos, 'id');
          foreach($allYoutubeVideosId as $key =>$val) {
            $allYoutubeVideosId[$key] = "'".$val."'";
          }
          $existingYoutubeId = $this->youtubeModel->getYoutubeData(implode(", ", $allYoutubeVideosId));
          foreach ($poularYoutubeVideos as $data) {
            if(in_array($data['id'], $existingYoutubeId)){
              $this->youtubeModel->updateYoutubeData($data);
            } else {
              $this->youtubeModel->insertYoutubeData($data);
            }
          }
          Common::sendResponse(Constants::API_SUCCESS, Codes::YOUTUBE_LIST_SUCCESSFULL, $poularYoutubeVideos);
        }
      } catch(\Exception $e) {
        Common::sendResponse(Constants::API_ERROR, Codes::YOUTUBE_LIST_UNSUCCESSFULL);
      }
    }

    public function getYoutubeVideoDetails() {
      try {
        $id = isset($_GET['id']) ? trim($_GET['id']) : 0;
        $existingYoutubeData = $this->youtubeModel->getYoutubeDetails($id);
        Common::sendResponse(Constants::API_SUCCESS, Codes::YOUTUBE_DETAIL_SUCCESSFULL, $existingYoutubeData);
      } catch(\Exception $e) {
        Common::sendResponse(Constants::API_ERROR, Codes::YOUTUBE_DETAIL_UNSUCCESSFULL);
      }
    }
}