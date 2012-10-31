<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Selamat Datang di iPROC - Aplikasi e-Procurement Terintegrasi</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link href="<?php echo base_url('css/bootstrap/css/bootstrap.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('css/custom-theme/jquery-ui-1.8.23.custom.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('css/ui.jqform.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('css/superfish.css') ?>" rel="stylesheet" media="screen" /> 
        <link href="<?php echo base_url('css/format.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('css/text.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('css/data.css') ?>" rel="stylesheet" type="text/css"/>

        
        <link href="<?php echo base_url('css/grid/css/960.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('css/ui.jqgrid.css') ?>" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="<?php echo base_url('js/jquery-1.8.0.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('js/i18n/grid.locale-en.js') ?>" ></script>
        <script type="text/javascript" src="<?php echo base_url('js/jquery.jqGrid.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('js/jquery-ui-1.8.23.custom.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('js/jquery.form.js') ?>"></script>         

        <script type="text/javascript" src="<?php echo base_url('js/jquery.validate.js') ?>"></script>         
        <script type="text/javascript" src="<?php echo base_url('js/jquery.metadata.js') ?>"></script>         
        <script type="text/javascript">
            $.jgrid.no_legacy_api = true;
            $.jgrid.useJSON = true;
            $.datepicker.setDefaults({
                showOn: 'both',
                buttonImageOnly: true,
                buttonImage: '<?php echo base_url('images/Calendar_scheduleHS.png') ?>',
                buttonText: 'Calendar',
                dateFormat: "yy-mm-dd",
                readOnly: true,
                defaultDate: $('.datepicker').val()
            });
            $.validator.messages.required = "Field tidak boleh kosong!";
            $.validator.setDefaults({
                highlight: function(el, error, valid){ 
                    $(el).closest('.control-group').addClass('error'); 
                },
                success: function(label) {
                    label
                    .text('OK!').addClass('valid')
                    .closest('.control-group').addClass('success');
                }
            });
        </script>

        <script type="text/javascript" src="<?php echo base_url('js/hoverIntent.js') ?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('js/superfish.js') ?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('js/supersubs.js') ?>"></script> 
        <script>  
            $(document).ready(function() { 
                $('ul.sf-menu').supersubs({ 
                    minWidth:    12,   // minimum width of sub-menus in em units 
                    maxWidth:    27,   // maximum width of sub-menus in em units 
                    extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
                    // due to slight rounding differences and font-family 
                }).superfish(); 
            }); 

        </script>
        <script type="text/javascript">
            var $base_url = '<?php echo base_url() ?>';
            var $site_url = '<?php echo site_url() ?>';
            var $images_url = $base_url + '/images/';
            var $js_url = $base_url + '/js/';
            var $css_url = $base_url + '/css/';
        </script>
        <script type="text/javascript" src="<?php echo base_url('js/stmenu.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('js/swap.js') ?>"></script>
    </head>

    <body onLoad="MM_preloadImages('<?php echo base_url('images/pass_on.png') ?>','<?php echo base_url('images/logout_on.png') ?>','<?php echo base_url('images/delg_on.png') ?>')">
        <table class="table_main_container" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="table_band">
                    <table class="table_band_container" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="txt_logged">Anda Masuk Sebagai : <span class="txt_orange">Application Administrator</span></td>
                            <td class="txt_date">Senin, 01 September 2008</td>
                            <td class="tools_container">
                                <div class="tools_item"><a href="<?php echo site_url('/account/logout') ?>"><img src="<?php echo base_url('images/logout.png') ?>" alt="Keluar Aplikasi" name="logout" width="20" height="18" border="0" id="logout" onMouseOver="MM_swapImage('logout','','<?php echo base_url('images/logout_on.png') ?>',1)" onMouseOut="MM_swapImgRestore()"></a></div>
                                <div class="tools_item"><a href="<?php echo site_url('/account/changepassword') ?>"><img src="<?php echo base_url('images/pass.png') ?>" alt="Rubah Password" name="chg_pass" width="20" height="18" border="0" id="chg_pass" onMouseOver="MM_swapImage('chg_pass','','<?php echo base_url('images/pass_on.png') ?>',1)" onMouseOut="MM_swapImgRestore()"></a></div>
                                <div class="tools_item"><a href="<?php echo site_url('/account/logout') ?>"><img src="<?php echo base_url('images/delg.png') ?>" alt="Pendelegasian User" name="delg" width="20" height="18" border="0" id="delg" onMouseOver="MM_swapImage('delg','','<?php echo base_url('images/delg_on.png') ?>',1)" onMouseOut="MM_swapImgRestore()"></a></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table_header">
                    <div class="iproc_logo">&nbsp;</div>
                    <div class="j_logo"><div class="j_logo_l">&nbsp;</div></div>
                </td>
            </tr>
            <tr>
                <td class="table_menu_container">
                    <div class="menu_bg">
                        <div class="menu_l">&nbsp;</div>
                        <div class="menu_r">&nbsp;</div>
                        <div class="menu_c">
                            <div class="mn_item_container">
                                
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table_content_container">
                    <table class="table_content" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="brcrumbs_link">Anda berada di sini : <span class="txt_blue">Home</span></td>
                        </tr>
                        <tr>
                            <td class="table_of_contents">

                                <div id="error-box" class="ui-state-error ui-corner-all" style="padding: 0 .7em;margin-bottom: 0.7em;display:none;"> 
                                    <p>
                                        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
                                        <strong>ERROR</strong>
                                    </p>
                                </div>
                                <?php echo $content_for_layout ?>

                                <table></table>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_iproc_logo">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table_ornament">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="table_orn_purple"><img src="<?php echo base_url('images/blank.gif') ?>" width="10" height="5"></td>
                            <td class="table_orn_green"><img src="<?php echo base_url('images/blank.gif') ?>" width="10" height="5"></td>
                            <td class="table_orn_orange"><img src="<?php echo base_url('images/blank.gif') ?>" width="10" height="5"></td>
                            <td class="table_orn_blue"><img src="<?php echo base_url('images/blank.gif') ?>" width="10" height="5"></td>
                            <td class="table_orn_yl_green"><img src="<?php echo base_url('images/blank.gif') ?>" width="10" height="5"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table_footer">© 2008 Copyright <b>ADW Consulting</b> - All Right Reserved</td>
            </tr>
            <tr>
                <td class="table_end">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
<script>
    $(function() {
        $( "input:submit, input:button").button();
        $( ".datepicker" ).datepicker();
    });
</script>
