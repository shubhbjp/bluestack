<?php

class Parser_Module{

  public function __construct(){
  }
  
  private function extractYoutubeData() {
    try {
      $youtubeHtmlPageContent = file_get_contents(Constants::YOUTUBE_POPULAR_VIDEOS);
      preg_match_all('#<script(.*?)</script>#is', $youtubeHtmlPageContent, $matches);
      $relevantData = explode("var ytInitialData =", $matches[1][33]);
      $relevantDataArray = json_decode(substr($relevantData[1], 0, -1));
      return $relevantDataArray->contents->twoColumnBrowseResultsRenderer->tabs[0]->tabRenderer->content->sectionListRenderer->contents;
    } catch(\Exception $e) {
      return array();
    }  
  }

  private function createDataToInsertPopularVideos($extractedYoutubeVideos=[]){
    $insertArray = [];
    try {
      foreach ($extractedYoutubeVideos as $count => $value) {
        foreach ($value->itemSectionRenderer->contents[0]->shelfRenderer->content->expandedShelfContentsRenderer as $videoCount => $videoDataArray) {
          foreach ($videoDataArray as $videoData) {
            try {
              $data_format_to_push = [];
              $data_format_to_push['id'] = $videoData->videoRenderer->videoId;
              $data_format_to_push['main_thumbnails'] = json_encode(array_column($videoData->videoRenderer->thumbnail->thumbnails, 'url')[0], true);
              $data_format_to_push['thumbnails'] = json_encode($videoData->videoRenderer->thumbnail->thumbnails, true);
              $data_format_to_push['title'] = $videoData->videoRenderer->title->runs[0]->text;
              $data_format_to_push['label'] = $videoData->videoRenderer->title->accessibility->accessibilityData->label;
              $data_format_to_push['description'] = $videoData->videoRenderer->descriptionSnippet->runs[0]->text;
              $data_format_to_push['view_count'] = (int) filter_var($videoData->videoRenderer->viewCountText->simpleText, FILTER_SANITIZE_NUMBER_INT);
              array_push($insertArray, $data_format_to_push);
            } catch(\Exception $e) {
              
            }
          }
        }
      }
    } catch(\Exception $e) {
    }
    return $insertArray;
  }

  public function getPopularListVideos() {
    $youtubeVideos = $this->extractYoutubeData();
    return $this->createDataToInsertPopularVideos($youtubeVideos);
  }
  
}