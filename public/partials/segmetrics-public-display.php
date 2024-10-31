<?php
$trackingUrl = empty($settings['tracking-domain']) ?
    "//tag.segmetrics.io/{$settings['account']}.js" :
    "//{$settings['tracking-domain']}/tag/{$settings['account']}.js";
?>
<!-- SegMetrics -->
<script type="text/javascript">
    var _segq = _segq || [];
    var _segs = _segs || {};
    (function () {var dc = document.createElement('script');dc.type = 'text/javascript';dc.async = true;dc.src = '<?= $trackingUrl ?>';var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(dc,s);})();
</script>
<!-- SegMetrics END -->
