<?php

class vw_ep_todo_persetujuan_kontrak extends MY_Model {

    public $table = 'VW_EP_TODO_PERSETUJUAN_KONTRAK';
    
    public $sql_select = "( select x.*, y.*, '' as \"ACT\" from (
                                select a.* ,c.NAMA_AKTIFITAS, b.url, d.value as KODE_KONTRAK_VALUE from EP_WKF_PROSES a
                                inner join (
                                    select rtrim(xmlagg(xmlelement(e, '&' || key || '=' || value )).extract('//text()').extract('//text()') ,',') url, kode_proses 
                                    from EP_WKF_PROSES_VARS
                                    group by KODE_PROSES
                                ) b on a.kode_proses = b.kode_proses
                                inner join EP_WKF_AKTIFITAS c on A.KODE_AKTIFITAS = C.KODE_AKTIFITAS
                                inner join EP_WKF_PROSES_VARS d on a.kode_proses = d.kode_proses and d.key = 'kode_kontrak'
                                where kode_wkf = 6
                            ) x
                            inner join EP_KTR_KONTRAK y on y.KODE_KONTRAK = x.KODE_KONTRAK_VALUE )";
    
    public $columns_conf = array(
        'KODE_PROSES',
        'NAMA_AKTIFITAS',
        'KODE_VENDOR',
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'NAMA_VENDOR',
        'JUDUL_PEKERJAAN',
        'LINGKUP_KERJA',
        'URL',
        'ACT',
    );
    public $dir = 'contract';
    
    function __construct() {
        parent::__construct();
        $this->init();
        
        $this->js_grid_completed = '
                var ids = jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'getDataIDs\');
		for(var i=0;i < ids.length;i++){
                    var cl = ids[i];
                    
                    var data = jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'getRowData\', cl);
                    
                    //alert(data[\'KODE_PROSES\']);
                    
                    var param = "referer_url=/contract/index&kode_proses=" + data[\'KODE_PROSES\'] + data[\'URL\'];
                    var href = $site_url + "/wkf/run?" + param;
                    
                    be = "<button onclick=\"javascript:window.location=\'" +href+ "\'\" type=\"button\" id=\"btnProses\" class=\"ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" role=\"button\" aria-disabled=\"false\"><span class=\"ui-button-text\">PROSES</span></button>";
                    jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'setRowData\',ids[i],{ACT:be});
		}';
    }

}

?>