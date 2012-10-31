
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Selamat Datang di iPROC - Aplikasi e-Procurement Terintegrasi</title>
        <link href="<?php echo base_url('css/format.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('css/text.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('css/login.css') ?>" rel="stylesheet" type="text/css">
        <script src="<?php echo base_url('js/SpryTabbedPanels.js') ?>" type="text/javascript"></script>
        <link href="<?php echo base_url('css/SpryTabbedPanels.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('css/data.css') ?>" rel="stylesheet" type="text/css">
    </head>

    <body>
        <table class="table_main_container" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="table_band">
                    <table class="table_band_container" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="txt_logged">&nbsp;</td>
                            <td class="txt_date">Senin, 01 September 2008</td>
                            <td class="tools_container">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="login_table_header">
                    <table class="login_table_title" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="login_j_logo_l">&nbsp;</td>
                            <td class="login_j_logo">&nbsp;</td>
                            <td class="login_j_logo_r">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table_menu_container">
                    <table width="900" border="0" align="center" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="login_menu_l">&nbsp;</td>
                            <td class="login_menu_c">
                                <div class="login_mid">&nbsp;</div>
                            </td>
                            <td class="login_menu_r">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table_content_container">

                    <table class="login_table_content" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center">
                                <div class="login_mid">
                                    <form action="<?php echo site_url('/account/login') ?>" method="POST">
                                        <table width="350" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="125" class="txt_label">User Name</td>
                                                <td width="225"><input type="text" name="username" id="textfield" style="width:200px"></td>
                                            </tr>
                                            <tr>
                                                <td class="txt_label">Password</td>
                                                <td><input type="password" name="password" id="textfield2" style="width:200px"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center" style="padding-top: 5px; padding-bottom: 5px">
                                                    <input type="submit" name="submit" id="button" style="width:100px" value="Login" class="frm_butt" onClick="location='home.htm'">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="txt_note">
                                                    <p>Lupa password anda?<br>
                                                        Klik <a class="txt_blue" href="<?php echo site_url('/account/resetpassword') ?>">disini</a> untuk me-reset
                                                        password anda...</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="txt_note">
                                                    <p>Belum Terdaftar?<br>
                                                        Klik <a class="txt_blue" href="<?php echo site_url('/account/registration') ?>">disini</a> untuk Registrasi</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td height="100%" valign="top"><div id="TabbedPanels1" class="TabbedPanels">
                                    <ul class="TabbedPanelsTabGroup">
                                        <li class="TabbedPanelsTab" tabindex="0">Pengumuman Pra-Kualifikasi</li>
                                        <li class="TabbedPanelsTab" tabindex="0">Pengumuman Lelang</li>
                                    </ul>
                                    <div class="TabbedPanelsContentGroup">
                                        <div class="TabbedPanelsContent">
                                            <table class="login_table" align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="data_tabel_container" align="center" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td class="data_main_title">DAFTAR PEKERJAAN</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="data_search">
                                                                    <div class="data_txt_label">Cari Berdasarkan</div>
                                                                    <div class="data_txt_field">
                                                                        <select name="select" id="select">
                                                                            <option selected>----- Pilih -----</option>
                                                                            <option>Nomor Tender</option>
                                                                            <option>Deskripsi</option>
                                                                        </select>
                                                                        <input type="text" name="textfield" id="textfield" style="width: 300px">
                                                                        <input type="submit" name="button2" id="button2" value="Cari" style="width: 60px" class="frm_butt">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <table class="data_tabel_list" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td class="data_col_title" style="width: 25px">No</td>
                                                                            <td class="data_col_title" style="width: 80px">No Tender</td>
                                                                            <td class="data_col_title">Deskripsi Pekerjaan</td>
                                                                            <td class="data_col_title" style="width: 90px">Pembukaan Pendaftaran</td>
                                                                            <td class="data_col_title" style="width: 90px">Penutupan Pendaftaran</td>
                                                                            <td class="data_col_title" style="width: 90px">Pembukaan Lelang</td>
                                                                            <td class="data_col_title" style="width: 180px">Status</td>
                                                                        </tr>
                                                                        <tr onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_white'">
                                                                            <td class="data_col_item">1</td>
                                                                            <td class="data_col_item">18</td>
                                                                            <td align="left" class="data_col_item">Pengadaan kertas nasional</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td align="left" class="data_col_item">Belum mengirim penawaran</td>
                                                                        </tr>
                                                                        <tr class="data_tabel_grey" onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_grey'">
                                                                            <td class="data_col_item">2</td>
                                                                            <td class="data_col_item">18</td>
                                                                            <td align="left" class="data_col_item">Pengadaan peralatan sekretaris</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td align="left" class="data_col_item">Belum mengirim penawaran</td>
                                                                        </tr>
                                                                        <tr onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_white'">
                                                                            <td class="data_col_item">3</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr class="data_tabel_grey" onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_grey'">
                                                                            <td class="data_col_item">4</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_white'">
                                                                            <td class="data_col_item">5</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr class="data_tabel_grey" onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_grey'">
                                                                            <td class="data_col_item">6</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_white'">
                                                                            <td class="data_col_item">7</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr class="data_tabel_grey" onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_grey'">
                                                                            <td class="data_col_item">8</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_white'">
                                                                            <td class="data_col_item">9</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr class="data_tabel_grey" onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_grey'">
                                                                            <td class="data_col_item">10</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="data_end"><img src="images/blank.gif" width="10" height="10"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="data_paging" valign="bottom"><b>[Page 1]</b> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">6</a> <a href="#">7</a> <a href="#">8</a> <a href="#">9</a>...<a href="#">15</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="data_paging">Showing 16 out of 240</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="TabbedPanelsContent">
                                            <table class="login_table" align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="data_tabel_container" align="center" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td class="data_main_title">DAFTAR PEKERJAAN</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="data_search">
                                                                    <div class="data_txt_label">Cari Berdasarkan</div>
                                                                    <div class="data_txt_field">
                                                                        <select name="select" id="select">
                                                                            <option selected>----- Pilih -----</option>
                                                                            <option>Nomor Tender</option>
                                                                            <option>Deskripsi</option>
                                                                        </select>
                                                                        <input type="text" name="textfield" id="textfield" style="width: 300px">
                                                                        <input type="submit" name="button2" id="button2" value="Cari" style="width: 60px" class="frm_butt">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <table class="data_tabel_list" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td class="data_col_title" style="width: 25px">No</td>
                                                                            <td class="data_col_title" style="width: 80px">No Tender</td>
                                                                            <td class="data_col_title">Deskripsi Pekerjaan</td>
                                                                            <td class="data_col_title" style="width: 90px">Pembukaan Pendaftaran</td>
                                                                            <td class="data_col_title" style="width: 90px">Penutupan Pendaftaran</td>
                                                                            <td class="data_col_title" style="width: 90px">Pembukaan Lelang</td>
                                                                            <td class="data_col_title" style="width: 180px">Status</td>
                                                                        </tr>
                                                                        <tr onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_white'">
                                                                            <td class="data_col_item">1</td>
                                                                            <td class="data_col_item">18</td>
                                                                            <td align="left" class="data_col_item">Pengadaan kertas nasional</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td align="left" class="data_col_item">Belum mengirim penawaran</td>
                                                                        </tr>
                                                                        <tr class="data_tabel_grey" onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_grey'">
                                                                            <td class="data_col_item">2</td>
                                                                            <td class="data_col_item">18</td>
                                                                            <td align="left" class="data_col_item">Pengadaan peralatan sekretaris</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td class="data_col_item">25.04.07</td>
                                                                            <td align="left" class="data_col_item">Belum mengirim penawaran</td>
                                                                        </tr>
                                                                        <tr onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_white'">
                                                                            <td class="data_col_item">3</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr class="data_tabel_grey" onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_grey'">
                                                                            <td class="data_col_item">4</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                        <tr onMouseOver="this.className='f_mouseOver'" onMouseOut="this.className='f_mouseOut_white'">
                                                                            <td class="data_col_item">5</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td class="data_col_item">&nbsp;</td>
                                                                            <td align="left" class="data_col_item">&nbsp;</td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="data_end"><img src="images/blank.gif" width="10" height="10"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="data_paging" valign="bottom"><b>[Page 1]</b> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">6</a> <a href="#">7</a> <a href="#">8</a> <a href="#">9</a>...<a href="#">15</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="data_paging">Showing 16 out of 240</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="login_iproc_logo">
                                    <img src="images/iproc_logo_big.png" width="170" height="70"><img src="images/logoverisign.gif" width="104" height="70">
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table_ornament">
                    <table width="900" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="table_orn_purple"><img src="images/blank.gif" width="10" height="5"></td>
                            <td class="table_orn_green"><img src="images/blank.gif" width="10" height="5"></td>
                            <td class="table_orn_orange"><img src="images/blank.gif" width="10" height="5"></td>
                            <td class="table_orn_blue"><img src="images/blank.gif" width="10" height="5"></td>
                            <td class="table_orn_yl_green"><img src="images/blank.gif" width="10" height="5"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table_footer">© 2008 Copyright <b>ADW Consulting</b> - All Right Reserved</td>
            </tr>
            <tr>
                <td class="table_end"><img src="images/blank.gif" width="995" height="1"></td>
            </tr>
        </table>
        <script type="text/javascript">
            <!--
            var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
            //-->
        </script>
    </body>
</html>
