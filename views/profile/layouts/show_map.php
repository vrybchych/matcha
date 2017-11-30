<div id="map" style="width:100%;height:300px;"></div>
<div onload="initialize()">
    <?php if ($_COOKIE['user'] == $_SESSION['current_user']) : ?>
        <div class="row">
            <div class="col-md-8">
                <input id="address" class="form-control" type="textbox" value="">
            </div>
            <div class="col-md-4">
                <input type="button" class="btn btn-info btn-block btn-sm" value="Set your location"
                       onclick="codeAddress()">
            </div>
        </div>
    <?php endif; ?>
</div>