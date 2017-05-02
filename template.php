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
    
    <link href="./vici-admin-them/theme/css/custom.css" rel="stylesheet">
	<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/vicidial/admin.php" class="site_title"><i class="fa fa-paw"></i> <span>Vicidial!</span></a>
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
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
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
                    <li><a href="/vicidial/admin.php?force_logout=1"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </li>
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
<script>
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
				isSelected: a.parent().hasClass('head_style_selected')
			};
	}
	
	function filterMenu(){
		return isMenu(this) || isSubMenu(this);
	}
	
	function renderMenuSubItem(item){
		
		return '<li class="'+(item.subheadSelected ? 'current-page' : '')+'" ><a href="'+item.href+'"><i class=""></i> '+item.a+'</a></li>';
	}
	
	function buildSubMenu(item){
		return '<ul class="nav child_menu" >'+item.subMenu.map(function(item){ return renderMenuSubItem(item); }).join('')+'</ul>';
	}
	
	function renderMenuItem(item){
		return buildMenu(item);
	}
	
	function buildMenu(item){
		var subMenu = item.isSelected ? buildSubMenu(item) : '';
		var href = item.isSelected ? '#' : 'href="'+item.href+'"';
		return '<li class="'+( item.isSelected ? 'active' : '' )+'"><a '+href+' ><i class=""></i> '+item.a+'<span class="fa fa-chevron-down"></span></a>'+subMenu+'</li>';
	}
	

	$(document).ready(function(){
		var table = $('table');
		table.addClass(function( index ) {
		  return "table";
		});
		/*$('center table').each(function(index){
			if($(this).find('thead').length == 0 && $(this).find('input').length == 0 && $(this).find('tbody tr').length > 0){
				var tr = $(this).find('tr').first().attr('bgcolor','BLACK').html();
				$(this).find('tr').first().remove();
				$("<thead  >"+tr+"</thead>").prependTo($(this));
			}
		});*/
		/*$('center table').each(function(index){
			if($(this).find('thead').length == 0 && $(this).find('input').length == 0 && $(this).find('tbody tr').length > 0){
				var tr = $(this).find('tr').first().attr('bgcolor','BLACK').html();
				$(this).find('tr').first().remove();
				$("<thead style='background: black; color: white;' >"+tr+"</thead>").prependTo($(this));
			}
		});*/
		const MENU = 1;
		const CONTENT = 3;
		var mainTable = table.clone();
		table.hide();
		console.log(table);
		var menuOptions = $(mainTable[MENU]).find('tbody tr').filter(filterMenu).map(mapMenu).get();
		var menus = menuOptions.filter(function(item){ return !item.subHead});
		var noDataTable = ['ADD=999999', 'ADD=999998'];
		menus.filter(function(item){ return item.isSelected}).forEach(function(item){ item.subMenu = menuOptions.filter(function(item){ return item.subHead}); });
		$('#menu').html(menus.map(function(item){ 
			return renderMenuItem(item); 
		}).join(''));
		if(noDataTable.indexOf(window.location.href.split('?')[1]) == -1)
		{
			var listTable = $(mainTable[CONTENT]).find('table').filter(function(){ return $(this).find('input').length < 1; });
			listTable.attr('width','100%');
			var tr = listTable.find('tr').first().remove();
			$("<thead  ></thead>").html(tr.get());
			listTable.prepend($("<thead  ></thead>").html(tr.get()));
			listTable.DataTable();
		}
		$('#main_content').html(mainTable[CONTENT]);
		if(typeof window.location.href.split('?')[1] == 'undefined')
		{
			$('#main_content').append(mainTable[4]);
			$('#main_content').append(mainTable[5]);
			$('#main_content').append(mainTable[6]);
		}
		

		
	});
	
</script>
</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

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