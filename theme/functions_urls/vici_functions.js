 // deleting second menu display, border deleting 
 function delete_tr(){
    $('tbody tr td, tbody tr').first().remove()
    $('tbody tr td[bgcolor]').first().remove()
  }

// changing name of functions
function chooser(id, att, func, func2){
     att2 = att.replace(func, func2);
      $(id).attr("href", att2)
  }

// new functions based in original vicidial functions. upgrate
function user_submit2()
    {
    var user_field = document.getElementById("user");
    user_field.disabled = false;
    document.getElementById("userform").submit();
    }

  function insertvalues(){
    var cursor = $('textarea[name="script_text"]').prop("selectionStart");
     var t = $('textarea[name="script_text"]').val()
     str1 = t.substring(0, cursor)
     str2 = t.substring(cursor)
    var value = $("#selectedField").val();
    $('textarea[name="script_text"]').val(str1 + "--A--"+value+"--B--"+str2);
    $('textarea[name="script_text"]').focus()
  }
    function launch_moh_chooser2(fieldname,stage,vposition)
    {
    var audiolistURL = "./non_agent_api.php";
    var audiolistQuery = "source=admin&function=moh_list&user=" + user + "&pass=" + pass + "&format=selectframe&stage=" + stage + "&comments=" + fieldname;
    var Iframe_content = '<IFRAME SRC="' + audiolistURL + '?' + audiolistQuery + '"  style="width:700;height:440;background-color:white;" scrolling="NO" frameborder="0" allowtransparency="true" id="audio_chooser_frame' + epoch + '" name="audio_chooser_frame" width="740" height="460" STYLE="z-index:2"> </IFRAME>';
      $("#audio_chooser_span div").html(Iframe_content)
      $("#audio_chooser_span").css("display", "block")
    } 

    function launch_vm_chooser2(fieldname,stage,vposition)
    {
    var audiolistURL = "./non_agent_api.php";
    var audiolistQuery = "source=admin&function=vm_list&user=" + user + "&pass=" + pass + "&format=selectframe&stage=" + stage + "&comments=" + fieldname;
    var Iframe_content = '<IFRAME SRC="' + audiolistURL + '?' + audiolistQuery + '"  style="width:740;height:440;background-color:white;" scrolling="NO" frameborder="0" allowtransparency="true" id="audio_chooser_frame' + epoch + '" name="audio_chooser_frame" width="740" height="460" STYLE="z-index:2"> </IFRAME>';

      $("#audio_chooser_span div").html(Iframe_content)
      $("#audio_chooser_span").css("display", "block")
    } 


    function audio_chooser2(fieldname,stage,vposition)
    {
    var audiolistURL = "./non_agent_api.php";
    var audiolistQuery = "source=admin&function=sounds_list&user=" + user + "&pass=" + pass + "&format=selectframe&stage=" + stage + "&comments=" + fieldname;
    var Iframe_content = '<IFRAME SRC="' + audiolistURL + '?' + audiolistQuery + '"  style="width:740;height:440;background-color:white;" scrolling="NO" frameborder="0" allowtransparency="true" id="audio_chooser_frame' + epoch + '" name="audio_chooser_frame" width="740" height="460" STYLE="z-index:2"> </IFRAME>';

      $("#audio_chooser_span div").html(Iframe_content)
      $("#audio_chooser_span").css("display", "block")
    }