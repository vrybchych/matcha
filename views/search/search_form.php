<form class="form-horizontal text-center" method="post" action="">
    <div class="form-group">
        <div class="form-inline">
            <strong>First name:</strong>
            <input class="form-control" type="textbox" name="first_name" value="<?php if (isset($_SESSION['search_params']['first_name'])) echo  $_SESSION['search_params']['first_name']; ?>"></p>
        </div>
        <div class="form-inline">
            <strong>Last name:</strong>
            <input class="form-control" type="textbox" name="last_name" value="<?php if (isset($_SESSION['search_params']['last_name'])) echo  $_SESSION['search_params']['last_name']; ?>"></p>
        </div>
        <div class="text-center row">
            <strong>Age:</strong><br>
            <p class="col-md-3 col-md-offset-2"><input id="search_tags" class="form-control" type="textbox"
                                                       name="age_from" value="<?php if (isset($_SESSION['search_params']['age_from'])) echo  $_SESSION['search_params']['age_from']; ?>"></p>
            <p class="col-md-2">-</p>
            <p class="col-md-3"><input id="search_tags" class="form-control" type="textbox" name="age_to" value="<?php if (isset($_SESSION['search_params']['age_to'])) echo $_SESSION['search_params']['age_to'] ;?>"></p>
        </div>
        <div class="text-center row">
            <strong>Rating:</strong><br>
            <p class="col-md-3 col-md-offset-2"><input id="search_tags" class="form-control" type="textbox"
                                                       name="rating_from" value="<?php if (isset($_SESSION['search_params']['rating_from'])) echo $_SESSION['search_params']['rating_from']; ?>"></p>
            <p class="col-md-2">-</p>
            <p class="col-md-3"><input id="search_tags" class="form-control" type="textbox" name="rating_to" value="<?php if (isset($_SESSION['search_params']['rating_to'])) echo $_SESSION['search_params']['rating_to']; ?>"></p>
        </div><br>
        <div class="container col-md-4">
            <strong>Gender:</strong>
            <div class="radio">
                <label>
                    <input type="radio" name="gender" id="optionsRadios1" value="male"
                        <?php if (isset($_SESSION['search_params']['gender']) && $_SESSION['search_params']['gender'] == 'male') echo 'checked'; ?> >
                    male
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="gender" id="optionsRadios2" value="female"
                        <?php if (!isset($_SESSION['search_params']['gender']) || $_SESSION['search_params']['gender'] == 'female') echo 'checked'; ?> >
                    female
                </label>
            </div>
        </div>
        <div class="container col-md-6">
            <strong>Sexual Preferences:</strong>
            <div class="radio">
                <label>
                    <input type="radio" name="sex_pref" id="optionsRadios1" value="heterosexual"
                        <?php if (!isset($_SESSION['search_params']['sex_pref']) || $_SESSION['search_params']['sex_pref'] == 'heterosexual') echo 'checked'; ?> >
                    heterosexual
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="sex_pref" id="optionsRadios2" value="homosexual"
                        <?php if (isset($_SESSION['search_params']['sex_pref']) && $_SESSION['search_params']['sex_pref'] == 'homosexual') echo 'checked'; ?> >
                    homosexual
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="sex_pref" id="optionsRadios3" value="bisexual"
                        <?php if (isset($_SESSION['search_params']['sex_pref']) && $_SESSION['search_params']['sex_pref'] == 'bisexual') echo 'checked'; ?> >
                    bisexual
                </label>
            </div>
            <br>
        </div>
        <div class="container col-md-2">
            <div class="checkbox col-offset-2" style="color: coral">
                <label><input type="checkbox" value="" name="online"  <?php if (isset($_SESSION['search_params']['online'])) echo 'checked'; ?>>online</label>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-warning btn-block" name="search">Search</button>
        <button type="submit" class="btn btn-success btn-block btn-xs" name="show_all_user">Show all users</button>
        <button type="submit" class="btn btn-danger btn-block btn-xs" name="show_blocked_user">Show blocked users</button>
    </div>
</form>