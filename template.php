  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="./vici-admin-them/theme/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="./vici-admin-them/theme/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="./vici-admin-them/theme/css/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="./vici-admin-them/theme/css/custom.css" rel="stylesheet">
	
  </head>
  <body class="nav-md" onkeydown="KeyCode(event)">
    <div class="container body" style="display:none;" >
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="./admin.php" class="site_title"><i class="fa fa-paw"></i> <span>Vicidial!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="./vici-admin-them/theme/images/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul id="menu" class="nav side-menu">
                  
				  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a href='/vicidial/welcome.php' data-toggle="tooltip" data-placement="top" title="Home">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
              </a>
              <a hreft='../agc/timeclock.php?referrer=admin' data-toggle="tooltip" data-placement="top" title="TimeClock">
                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
              </a>
              <a href='manager_chat_interface.php' data-toggle="tooltip" data-placement="top" title="Chat">
                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
              </a>
              <a href='/vicidial/admin.php?force_logout=1' data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

          <div class="nav_menu">
            <nav class="" role="navigation">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li>
                    <a href="/vicidial/welcome.php"><i class="fa fa-home pull-right"></i> Home</a>
                    </li> <li>
                    <a href="../agc/timeclock.php?referrer=admin"><i class="fa fa-clock-o pull-right"></i> Timeclock</a>
                    </li><li><a href="manager_chat_interface.php"><i class="fa fa-commenting-o pull-right"></i>Chat</a>
                    </li>
                    <li><a href="/vicidial/admin.php?force_logout=1"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>

        </div>
        <!-- /top navigation -->
		<!-- page content -->
        <div class="right_col" role="main">

          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3></h3>
              </div>

            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  <div id="main_content" class="x_content">
						

                    </div>
                    <!-- End SmartWizard Content -->
					
  <!-- jQuery -->
    <script src="./vici-admin-them/theme/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./vici-admin-them/theme/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="./vici-admin-them/theme/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="./vici-admin-them/theme/js/nprogress.js"></script>
    <!-- jQuery Smart Wizard -->
    <script src="./vici-admin-them/theme/js/jquery.smartWizard.js"></script>
	<!-- bootstrap-daterangepicker -->
    <script src="./vici-admin-them/theme/js/moment.min.js"></script>
    <script src="./vici-admin-them/theme/js/daterangepicker.js"></script>
    <script src="./vici-admin-them/theme/js/jquery.dataTables.min.js"></script>
   
<script src="../dividize.js"></script>
<script src="../assets/js/knockout-3.3.0.js"></script>
<style>
#vicidial_report{width:570px;}
input[name="search_archived_data"]{
  margin-top: 30px
}

#audio_chooser_span{position:fixed;left:0;right:0;margin-left:auto;margin-right:auto;background: #fff;width:740px;height: 440px;bottom:50px;box-shadow:0px 0px 20px rgba(0,0,0,0.5);z-index:1;display: none}
#audio_chooser_span a{position: absolute;right:20px;top:5px;font-size:22px}

/*body{overflow-x:hidden }*/

</style>
<script>
function KeyCode(event){
  var x = event.keyCode;
    if (x == 27) {  // 27 is the ESC key
        $("#audio_chooser_span").css("display", "none")
    }
}

	function tableToJson(table) {
		var data = [];

		// first row needs to be headers
		var headers = [];
		for (var i=0; i<table.rows[0].cells.length; i++) {
			headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,'');
		}

		// go through cells
		for (var i=1; i<table.rows.length; i++) {

			var tableRow = table.rows[i];
			var rowData = {};

			for (var j=0; j<tableRow.cells.length; j++) {

				rowData[ headers[j] ] = tableRow.cells[j].innerHTML;

			}

			data.push(rowData);
		}

		return data;
	}
	
	function isMenu(self){
		return $(self).attr('bgcolor') == '#015B91';
	}
	
	function isSubMenu(self){
		return $(self).hasClass('subhead_style_selected') || $(self).hasClass('subhead_style');
	}
	
	function isSubMenuSelected(self){
		return $(self).hasClass('subhead_style_selected');
	}
	
	function mapMenu(key, item){
		var a = $(item).find('a');
			return {
				a: a.html(),
				href: a.prop('href'),
				subHead: isSubMenu(item),
				subheadSelected: isSubMenuSelected(item),
				isSelected: a.parent().hasClass('head_style_selected'),
				isReport: (a.text() == "  Reports ")
			};
	}
	
	function filterMenu(){
		return isMenu(this) || isSubMenu(this);
	}
	
	function renderMenuSubItem(item){ 
    if(String(item.href)!="undefined"){
      //se ejecuta si el submenu no da como valor "undefined"
      return '<li class="'+(item.subheadSelected ? 'current-page' : '')+'" ><a href="'+item.href+'"><i class=""></i> '+item.a+'</a></li>';
    }
	}
	
	function buildSubMenu(item){
		return '<ul class="nav child_menu" >'+item.subMenu.map(function(item){ return renderMenuSubItem(item); }).join('')+'</ul>';

	}
	
	function renderMenuItem(item){
		return buildMenu(item);
	}
	
	function buildMenu(item){
		var subMenu = item.isSelected ? buildSubMenu(item) : '';
		var href = item.isSelected && !item.isReport ? '#' : 'href="'+item.href+'"';
  
		return '<li class="'+( item.isSelected ? 'active' : '' )+'"><a '+href+' ><i class=""></i> '+item.a+'<span class="fa fa-chevron-down"></span></a>'+subMenu+'</li>';
	}
	
	function msieversion() {

		var ua = window.navigator.userAgent;
		var msie = ua.indexOf("MSIE ");
		return (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./));
	}

	$(document).ready(function(){

		if(msieversion())
			return;
		$('.container').show();
		var table = $('table');
		table.addClass(function( index ) {
      return "table";
    });
		const MENU = 1;
		const CONTENT = 3;
		var mainTable = table.clone();
		table.hide();
		console.log(table);
		var menuOptions = $(mainTable[MENU]).find('tbody tr').filter(filterMenu).map(mapMenu).get();
		var menus = menuOptions.filter(function(item){ return !item.subHead});
		var noDataTable = ['ADD=999999', 'ADD=999998', 'user='];
		console.log('menu',menus);
		menus.filter(function(item){ return item.isSelected}).forEach(function(item){ item.subMenu = menuOptions.filter(function(item){ return item.subHead}); });
		$('#menu').html(menus.map(function(item){ 
			return renderMenuItem(item); 
		}).join('')).prepend('<li class=""><a href="./admin.php">DashBoard<span class="fa fa-chevron-down"></span></a></li>');

	   
    $('#main_content').html(mainTable[CONTENT]);

		if(typeof window.location.href.split('?')[1] == 'undefined')
		{
			$('#main_content').append(mainTable[4]);
			$('#main_content').append(mainTable[5]);
			$('#main_content').append(mainTable[6]);
		}

     url = document.URL.split("?")
     if(String(url[1])!="undefined"){
      url = url[1].split("ADD=")
       if(String(url[1])!="undefined"){
          url = url[1].split("=");
        }
     }else if(window.location.href.indexOf('admin_search_lead') > 0 || window.location.href.indexOf('campaign_id') > 0 || window.location.href.indexOf('user_stats') > 0 || window.location.href.indexOf('group_hourly_stats') > 0 || noDataTable.indexOf(window.location.href.split('?')[1]) == -1){
      url = "default";

     }
        
     if(window.location.href.indexOf('admin_modify_lead') > 0 || window.location.href.indexOf('admin_listloader_fourth_gen') > 0)
    {      
      $('#main_content').append(mainTable[1]);
      
    }
    if(url[0]=="321111111111111"){
      $(".x_panel").css({"-webkit-transform":"scale(0.8,1)", "position": "relative", "left": "-110px"})
    }
    
    if(noDataTable.indexOf(window.location.href.split('?')[1]) == 1 || url=="default" || url[0]=="31&SUB" || url[0]=="3511&menu_id" || url[0]=="3111&group_id" || url[0]=="10000000000" || url[1]=="311111111111111" || url[0]=="182000000000" || url[0]=="3111&group_id=AGENTDIRECT" || url[0]=="3511&menu_id=defaultlog" || url[0]=="5&user" || url[0]=="6&user" || url[0]=="user=" || url[0]=="130000000000"|| url[0]=="140000000000" || url[0]=="100000000000" || url[0]=="1000000000000" || url[0]=="311111111111111" || url[0]=="321111111111111" || url[0]=="1930000000" || url[0]=="170000000000" || url[0]=="160000000000" || url[0]=="192000000000" || url[0]=="999999" || url[0]=="331111111111111" || url[0]=="999994" || url[0]=="194111111111" || url[0]=="194000000000" || url[0]=="190000000000" || url[0]=="31&campaign_id" || url[0]=="10" || url[0]=="3111111&script_id"){
        
        $('#main_content').html(mainTable[2]);
    //deleting main menu home, timeclock, chat, etc.
        delete_tr()

    $('input[name=query_date], input[name=end_date], input[name=begin_date]').val("").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    });
    $("input[value=MODIFY], input[name=insertField]").click(function(){
      $("form").submit()
    })
    }else{
    var listTable = $(mainTable[CONTENT]).find('table').filter(function(){ return $(this).find('input').length < 1; });
      listTable.attr('width','100%');
      var tr = listTable.find('tr').first().remove();
      $("<tbody></tbody>").html(tr.get());
      listTable.prepend($("<thead></thead>").html(tr.get()));
      listTable.DataTable({
        "lengthMenu": [[25, 50, -1], [25, 50, "All"]]
      });
      
      // document.write(t)
      

       $('form[name="userform"]').attr("action", "admin.php")
       $('form[name="userform"] input[value="SUBMIT"]').attr("onclick", "user_submit2()")
    }


    $("a").each(function(){
    if($(this).html()==="audio chooser"){
        var att = $(this).attr('href');  
        chooser($(this), att, "launch_chooser", "audio_chooser2");
      }
      if($(this).html()=="moh chooser"){
        var att = $(this).attr('href');  
        chooser($(this), att, "launch_moh_chooser", "launch_moh_chooser2");      
      }
      if($(this).html()=="voicemail chooser"){
        var att = $(this).attr('href');  
        chooser($(this), att, "launch_vm_chooser", "launch_vm_chooser2");      
      }
      
    })
    
    
	});
  
  function delete_tr(){
    $('tbody tr td, tbody tr').first().remove()
    $('tbody tr td[bgcolor]').first().remove()
  }
  function chooser(id, att, func, func2){
     att2 = att.replace(func, func2);
      $(id).attr("href", att2)
  }

	function user_submit2()
    {
    var user_field = document.getElementById("user");
    user_field.disabled = false;
    document.getElementById("userform").submit();
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
</script>

</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
        <div id="audio_chooser_span"><a onclick="$('#audio_chooser_span').css({'display': 'none', 'cursor': 'pointer'})">X</a><div></div><load></load></div><!--cuadro de dialogo de algunas pantallas-->

<!-- footer content -->
        <footer>
          <div class="pull-right">
            
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    

    
   <!-- Custom Theme Scripts -->
    <script src="./vici-admin-them/theme/js/custom.js"></script>
  </body>
</html>