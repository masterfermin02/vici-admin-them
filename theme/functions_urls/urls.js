	url = document.URL.split("?")
     if(String(url[1])!="undefined"){
      url = url[1].split("ADD=")
       if(String(url[1])!="undefined"){
          url = url[1].split("=");
        }else{
          url = "default";
        }
     }else if(window.location.href.indexOf('admin_search_lead') > 0 || window.location.href.indexOf('campaign_id') > 0 || window.location.href.indexOf('user_stats') > 0 || window.location.href.indexOf('group_hourly_stats') > 0 || noDataTable.indexOf(window.location.href.split('?')[1]) == -1){
      url = "default";

     }
        
     if(window.location.href.indexOf('admin_modify_lead') > 0 || window.location.href.indexOf('admin_listloader_fourth_gen') > 0)
    {      
      $('#main_content').append(mainTable[1]);
      
    }

	//request url values
    var urls = ["12", "999999&stage", "999994", "161111111111", "193111111111", "31&SUB", "3511&menu_id", "3111&group_id", "10000000000", "311111111111111", "182000000000", "3111&group_id=AGENTDIRECT", "3511&menu_id=defaultlog", "5&user", "6&user", "user=", "130000000000", "140000000000", "100000000000", "311111111111111", "321111111111111", "1930000000", "170000000000", "160000000000", "192000000000", "999999", "331111111111111", "999994", "194111111111", "194000000000", "190000000000", "31&campaign_id", "1111111", "130000000", "131111111111", "131111111", "131111111111", "141111111111", "10", "3111111&script_id", "140111111111", "111111111111"];

// getting default display to those urls
 for(urlss in urls){
      if(url[0]==urls[urlss]){
        url = "default";
        break;
        }
    }


 if(url[0]=="321111111111111"){
      $(".x_panel").css({"-webkit-transform":"scale(0.8,1)", "position": "relative", "left": "-110px"})
    }