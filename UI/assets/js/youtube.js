const Http = new XMLHttpRequest()
const url='index.php?api_name=listPopularYoutubeVideos&control_type=youtube'
Http.open("GET", url)
Http.send()

Http.onreadystatechange = (e) => {
  try {
    x = JSON.parse(Http.responseText)
    data = JSON.parse(x.data)
    for(i=0;i<data.length;i++) {
      html_content = "<div id='"+data[i]['id']+"' onclick=openYoutube(this); class='video-box'>"
      html_content += "<div class='tooltip'><img src='"+JSON.parse(data[i]['main_thumbnails'])+"' class='image-box' /><span class='tooltiptext'>"+data[i]['label']+"</span></div>"
      html_content += "<div><p class='title'>"+data[i]['title']+"</p><p class='description'>"+data[i]['description']+"</p></div>"
      html_content += "</div>"
      document.getElementById('list').innerHTML += html_content
    }
    document.getElementById('loader').style.display='none'

  } catch(err) {

  }
}
selectedId = 0
function openYoutube(e) {
  localStorage.setItem('last-play-id', e.id)
  window.location.href = "detail.html"
}