<?php

function jqGrid() {
    $buildDivName = $this->divName;
    $buildSourceUrl = $this->sourceUrl;
    $buildColNames = $this->colNames;
    $buildColModels = $this->colModels;
    $buildSortName = $this->sortName;
    $buildEditUrl = $this->editUrl;
    $buildAddUrl = $this->addUrl;
    $buildDeleteUrl = $this->deleteUrl;
    $buildCaption = $this->caption;
    $buildGridHeight = $this->gridHeight;
    $buildPrimaryKey = $this->primaryKey;
    $buildCustomButtons = $this->customButtons;
    $buildSubGrid = $this->subgrid;
    $buildSubGridUrl = $this->subGridUrl;
    $buildSubGridColumnNames = $this->subGridColumnNames;
    $buildSubGridColumnWidth = $this->subGridColumnWidth;

    $grid = "<script type='text/javascript'>";
    $grid .= "$('#$buildDivName').jqGrid({
				url:'$buildSourceUrl',
				datatype: 'json',
				colNames:$buildColNames,
				colModel:$buildColModels,
				rowNum:20,
				rowList:[10,20,30],
				pager: '#pager',
				toppager:true,
				cloneToTop:true,
				sortname: '$buildSortName',
				viewrecords: true,
				sortorder: 'asc',
				caption:'$buildCaption'";
    $grid .= "});";

    //NavBar
    $grid .= "$('#$buildDivName').jqGrid('navGrid','#pager',
					{search:true,edit:false,add:false,del:false,cloneToTop:true}, //options
					{} // search options
					)";
    if (!empty($buildCustomButtons)) {
        foreach ($buildCustomButtons as $customButton) {
            $customButton = ".navButtonAdd('#grid_toppager_left'," . $customButton . ")";
            $grid .= $customButton;
        }
    }

    $grid .= ".navButtonAdd('#grid_toppager_left',
					{ caption:'', buttonicon:'ui-icon-trash', onClickButton:jqGridDelete ,title: 'Delete selected row', position: 'first', cursor: 'pointer'})
					.navButtonAdd('#grid_toppager_left',
					{ caption:'', buttonicon:'ui-icon-pencil', onClickButton:jqGridEdit,title: 'Edit selected row', position: 'first', cursor: 'pointer'})
					.navButtonAdd('#grid_toppager_left',
					{ caption:'', buttonicon:'ui-icon-plus', onClickButton:jqGridAdd,title: 'Add new record', position: 'first', cursor: 'pointer'});";

    $grid .= "
		function jqGridAdd() {
			location.href='$buildAddUrl?oper=add';
		}

		function jqGridEdit() {
			var grid = $('#$buildDivName');
			var sel_id = grid.jqGrid('getGridParam', 'selrow');
			var myCellData = grid.jqGrid('getCell', sel_id, '$buildPrimaryKey');
			if(!myCellData) {
				alert('No selected row');
			} else {
				//alert(myCellData);

            location.href='$buildEditUrl' + myCellData;
			}
		}

		function jqGridDelete() {
			var grid = $('#$buildDivName');
			var sel_id = grid.jqGrid('getGridParam', 'selrow');
			var recid = grid.jqGrid('getCell', sel_id, '$buildPrimaryKey');
			if(!recid) {
				alert('No selected row');
			} else {
				var ans = confirm('Delete selected record?');
				if(ans) {
					var data = {};
					data.recid = recid;
					$.post('$buildDeleteUrl',data);
					$('#$buildDivName').trigger('reloadGrid');
				}
			}
		}

		";

    if (!empty($this->customFunctions)) {
        foreach ($this->customFunctions as $customFunction) {
            $grid .= $customFunction;
        }
    }

    //Set Grid Height
    $grid .= "$('#$buildDivName').setGridHeight($buildGridHeight,true);";
    $grid .= "$('.ui-jqgrid-titlebar-close','#gview_$buildDivName').remove();";
    $grid .= "</script>";
    return $grid;
}

function buildGrid($aData) {
    $CI = & get_instance();
    $CI->load->library('jqgrid_lib');
    $jqGrid = $CI->jqgrid_lib;
    if (isset($aData['set_columns'])) {
        $aProperty = array();
        foreach ($aData['set_columns'] as $sProperty) {
            $aProperty[] = array(
                $sProperty['label'] =>
                array(
                    'name' => $sProperty['name'],
                    'index' => $sProperty['name'],
                    'width' => $sProperty['width'],
                    'editable' => false,
                    'editoptions' => array(
                        'readonly' => 'true',
                        'size' => $sProperty['size']
                    )
                )
            );
        }
        $jqGrid->setColumns($aProperty);
    }

    if (isset($aData['custom'])) {
        if (isset($aData['custom']['button'])) {
            $jqGrid->setCustomButtons(array($aData['custom']['button']));
        }
        if (isset($aData['custom']['function'])) {
            $jqGrid->setCustomFunctions(array($aData['custom']['function']));
        }
    }

    if (isset($aData['div_name'])) {
        $jqGrid->setDivName($aData['div_name']);
    } else {
        $jqGrid->setDivName('grid');
    }

    if (isset($aData['source']))
        $jqGrid->setSourceUrl($aData['source']);

    if (isset($aData['sort_name']))
        $jqGrid->setSortName($aData['sort_name']);

    if (isset($aData['add_url']))
        $jqGrid->setAddUrl($aData['add_url']);

    if (isset($aData['delete_url']))
        $jqGrid->setDeleteUrl($aData['delete_url']);

    if (isset($aData['edit_url']))
        $jqGrid->setEditUrl($aData['edit_url']);

    if (isset($aData['caption']))
        $jqGrid->setCaption($aData['caption']);

    if (isset($aData['primary_key']))
        $jqGrid->setPrimaryKey($aData['primary_key']);

    if (isset($aData['grid_height']))
        $jqGrid->setGridHeight($aData['grid_height']);

    if (isset($aData['subgrid']))
        $jqGrid->setSubGrid($aData['subgrid']);

    if (isset($aData['subgrid_url']))
        $jqGrid->setSubGridUrl($aData['subgrid_url']);

    if (isset($aData['subgrid_columnnames']))
        $jqGrid->setSubGridColumnNames($aData['subgrid_columnnames']);

    if (isset($aData['subgrid_columnwidth']))
        $jqGrid->subGridColumnWidth($aData['subgrid_columnwidth']);

    return $jqGrid->buildGrid();
}

function buildGridData($aData) {
    $CI = & get_instance();
    $isSearch = $CI->input->get('_search');
    $searchField = $CI->input->get('searchField');
    $searchString = $CI->input->get('searchString');
    $searchOperator = $CI->input->get('searchOper');
    $page = $CI->input->get('page'); // get the requested page
    $limit = $CI->input->get('rows'); // get how many rows we want to have into the grid
    $sidx = $CI->input->get('sidx'); // get index row - i.e. user click to sort
    $sord = $CI->input->get('sord'); // get the direction

    if ($isSearch)
        $whereParam = buildWhereClauseForSearch($searchField, $searchString, $searchOperator);
    else
        $whereParam = NULL;

    $paramArr['whereParam'] = $whereParam;
    $paramArr['reload'] = TRUE;

    /* you can add aditional params in the where clause here:
      $paramArr['outletid']		= $CI->session->userdata(SELECTED_OUTLET);
      $paramArr['invtypeId']	= $CI->session->userdata(SELECTED_INVENTORY_TYPE);
      $paramArr['postingYear'] 	= getPostingYear();
     */
    if (isset($aData['method']) && isset($aData['model'])) {

        $CI->load->model($aData['model']);
        $aDataList = $CI->$aData['model']->$aData['method']($paramArr);
        $count = count($aDataList);
        if ($count > 0)
            $total_pages = ceil($count / $limit);
        else
            $total_pages = 0;

        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - $limit;

        $paramArr['start'] = $start;
        $paramArr['limit'] = $limit;
        $paramArr['sortField'] = $sidx;
        $paramArr['sortOrder'] = $sord;
        $paramArr['whereParam'] = $whereParam;
        $paramArr['reload'] = TRUE;
        $aDataList = $CI->$aData['model']->$aData['method']($paramArr);

        $i = 0;
        if (isset($aData['columns'])) {
            foreach ($aDataList as $row) {
                $columnData = array();
                foreach ($aData['columns'] as $sData) {
                    array_push($columnData, $row->$sData);
                }
                $rs->rows[$i]['id'] = $row->$aData['pkid'];
                $rs->rows[$i]['cell'] = $columnData;
                $i++;
            }
        }
        $rs->cols = $columnData;
        $rs->page = $page;
        $rs->total = $total_pages;
        $rs->records = $count;
        echo json_encode($rs);
    }
}

function buildWhereClauseForSearch($searchField, $searchString, $searchOperator) {
    $searchString = mysql_real_escape_string($searchString);
    $searchField = mysql_real_escape_string($searchField);
    $operator['eq'] = "$searchField='$searchString'"; //equal to
    $operator['ne'] = "$searchField<>'$searchString'"; //not equal to
    $operator['lt'] = "$searchField < $searchString"; //less than
    $operator['le'] = "$searchField <= $searchString "; //less than or equal to
    $operator['gt'] = "$searchField > $searchString"; //less than
    $operator['ge'] = "$searchField >= $searchString "; //less than or equal to
    $operator['bw'] = "$searchField like '$searchString%'"; //begins with
    $operator['bn'] = "$searchField not like '$searchString%'"; //not begins with
    $operator['in'] = "$searchField in ($searchString)"; //in
    $operator['ni'] = "$searchField not in ($searchString)"; //not in
    $operator['ew'] = "$searchField like '%$searchString'"; //ends with
    $operator['en'] = "$searchField not like '%$searchString%'"; //not ends with
    $operator['cn'] = "$searchField like '%$searchString%'"; //in
    $operator['nc'] = "$searchField not like '%$searchString%'"; //not in
    $operator['nu'] = "$searchField is null"; //is null
    $operator['nn'] = "$searchField is not null"; //is not null

    if (isset($operator[$searchOperator])) {
        return $operator[$searchOperator];
    } else {
        return null;
    }
}
