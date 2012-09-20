<?php
echo "xxx";
?>
<div id="accordion">
    <h3><a href="<?php echo site_url('/crud/grid/EP_VENDOR') ?>">Section 1</a></h3>
    <div></div>
    <h3><a href="<?php echo site_url('/crud/grid/EP_NOMORURUT') ?>">Section 2</a></h3>
    <div></div>
    <h3><a href="<?php echo site_url('/crud/grid/EP_VENDOR_STATUS_REGISTRASI') ?>">Section 3</a></h3>
    <div></div>
    <h3><a href="#">Section 4</a></h3>
    <div>
        <p>
            Cras dictum. Pellentesque habitant morbi tristique senectus et netus
            et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
            faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
            mauris vel est.
        </p>
        <p>
            Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
            Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
            inceptos himenaeos.
        </p>
    </div>
</div>

<script>
    $(function() {
        $( "#accordion" ).accordion({
            active:false,
            change:function(event, ui) {
//                alert(ui.newContent.html().length);
                if(ui.newContent.html()==""){
                    ui.newContent.load(ui.newHeader.find('a').attr('href'));
                }
            },
            autoHeight: false
        });
    });
</script>