	url = document.URL.split("?")
     if(String(url[1])!="undefined"){
      url = url[1].split("ADD=")
       if(String(url[1])!="undefined"){
          url = url[1].split("=");
        }else{
          url = "default";
        }
     }else{
      var url_index = ['admin_search_lead', 'campaign_id', 'user_stats', 'group_hourly_stats', 'audio_store', 'admin'];
      for(indexof in url_index){
         if(window.location.href.indexOf(url_index[indexof]) > 0){
              url = 'default';
              break;
          }
      }
     }

 if(url[0]=="321111111111111"){
      $(".x_panel").css({"-webkit-transform":"scale(0.8,1)", "position": "relative", "left": "-110px"})
    }
