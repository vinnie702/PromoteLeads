<div class='row pad-btm'>
    <div class='col-md-12'>
        <?php
            echo "<center><h1 class='purple-text'>{$chapter->name} Chapter</h1></center>";
        ?>
    </div> <!-- /.col12 -->
</div> <!-- /.row -->
<div class='row pad-btm'>
    <?php
        if(empty($cp))
        {
            echo "<div class='col-sm-2'>";
                echo "<img class='img-thumbnail img-responsive' src='https://bms.cgisolution.com/user/profileimg/150/5'>";
            echo "</div>";
            echo "<div class='col-md-3 col-sm-4'>";

                /* visible only by large viewports */
                echo "<center class='visible-lg'><h4 class='title'>Acting Chapter President</h4></center>";

                /* hidden from large viewports */
                echo "<center class='hidden-lg'><h5>Acting Chapter President</h5></center>";

                /* hidden from small viewports */
                echo "<a class='hidden-sm' href='/members/profile/5'><strong>George W Burroughs III</strong></a></br>";

                /* visible only by small viewports */
                echo "<a class='visible-sm' href='/members/profile/5'>George W Burroughs III</a></br>";
                echo "<p><small>Promote Leads President</small></p>";
                echo "<p><i class='fa fa-phone'></i> <abbr title='Phone'>P</abbr>: (702) 530-0055</p>";

                /* hidden from small viewports */
                echo "<p class='hidden-sm'><i class='fa fa-envelope-o'></i> <abbr title='Email'>E</abbr>: <a href='mailto:george@promoteleads.com'>george@promoteleads.com</a></p>";

                /* visible only by small viewports */
                echo "<p class='visible-sm'><i class='fa fa-envelope-o'></i> <abbr title='Email'>E</abbr>: <a href='mailto:george@promoteleads.com'>Email Me!</a></p>";
                echo "<p><i class='fa fa-globe'></i> <abbr title='Website'>W</abbr>: <a href='http://www.promoteleads.com'>Promote Leads</a></p>";
            echo "</div>";
        }
        else
        {
            echo "<div class='col-sm-2'>";
                echo "<img class='img-responsive img-thumbnail' src='https://bms.cgisolution.com/user/profileimg/150/{$cp->id}'>";
            echo "</div>";
            echo "<div class='col-md-3 col-sm-4'>";
                echo "<center class='visible-lg'><h4 class='title'>Chapter President</h4></center>";
                echo "<center class='hidden-lg'><h5>Chapter President</h5></center>";
                echo "<a href='/members/profile/{cp->id}'><strong>{$cp->firstName} {$cp->lastName}</strong></a></br>";
                echo "<p><i class='fa fa-phone'></i> <abbr title='Phone'>P</abbr>: {$cp->phone}</p>";
                echo "<p><i class='fa fa-envelope-o'></i> <abbr title='Email'>E</abbr>: <a href='mailto:{$cp->email}'>{$cp->email}</a></p>";
                echo "<p><i class='fa fa-globe'></i> <abbr title='Website'>W</abbr>: <a href='{$cp->companyWebsiteUrl}'>{$cp->companyName}</a></p>";
            echo "</div>";
        }
    ?>
    <hr class='visible-xs'>
    <div class='col-md-2 hidden-sm'>
    </div>
    <div class='col-md-3 col-sm-4'>
        <?php
            echo "<center>";
                echo "<h4 class='visible-lg title'>{$chapter->name}</h4>";
                echo "<h5 class='hidden-lg'>{$chapter->name}</h5>";
            echo "</center>";
            echo "{$chapter->address} </br>";
            if(!empty($chapter->address2)) echo "{$chapter->address2} </br>";
            echo "{$chapter->city}, {$chapter->state} {$chapter->postalCode}";
    echo "</div> <!-- /.md3 sm4 -->";
    echo "<div class='col-sm-2'>";
    $locationPic = $locationImg->fileName;
    echo "<img class='img-responsive img-thumbnail' src='https://bms.cgisolution.com/genimg/render/150?img=" .urlencode($locationPic) . "&path=" .urlencode("locationimgs") . "'>";
echo "</div> <!-- /.row -->";
        ?>
</div>
<div class='row'>
    <div class='col-sm-12'>
        <div class='tabbable'>
        <ul class="nav nav-tabs">
            <li><a href="#Members" class='purple' data-toggle="tab">Members</a></li>
            <li><a href="#Announcements" class='purple hidden-xs' data-toggle="tab">Announcements</a></li>
            <li><a href="#Announcements" class='purple visible-xs' data-toggle="tab">Announce</a></li>
            <li><a href="#LocationSpecials" class='purple hidden-xs' data-toggle="tab">Location Specials</a></li>
            <li><a href="#LocationSpecials" class='purple visible-xs' data-toggle="tab">Loc. Spc.</a></li>
        </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active purple-text" id="Members" name='Members'>
                    <?php
                        $rcnt = 1;
                        foreach($members as $r)
                        {
                            $user = $this->member_model->getUserInfo($r->userid);
                            $id = $r->userid;

                            if($rcnt == 1)
                            {
                                echo "<hr class='hidden-xs'>";
                                echo "<div class='row'>";
                            }
                                echo "<div class='col-sm-2'>";
                                    echo "<a href='/members/profile/{$user->id}'><div class='img-thumbnail float-left'>";
                                        echo "<img class='img-responsive' src='https://bms.cgisolution.com/user/profileimg/150/{$id}'>";
                                    echo "</div></a>";
                                echo "</div>";
                                echo "<div class='col-sm-2'>";
                                    echo "<h4 class='title hidden-sm'>{$user->companyName}</h4>";
                                    echo "<h5 class='visible-sm'>{$user->companyName}</h5>";
                                    echo "<p class='hidden-sm'><a href='/members/profile/{$user->id}'><strong>{$user->firstName} {$user->lastName}</strong></a></p>";
                                    echo "<p class='visible-sm'><a href='/members/profile/{$user->id}'>{$user->firstName} {$user->lastName}</a></p>";
                                    echo "<p class='hidden-sm'><i class='fa fa-envelope-o'></i> <abbr title='{$user->email}'>E</abbr>: <a href='mailto:{$user->email}'>E-Mail Me!</a></p>";
                                    echo "<p class='visible-sm pull-left'><a href='mailto:{$user->email}'><abbr title='{$user->email}'><i class='fa fa-envelope-o'></i> E</abbr></a></p>";
                                    if(!empty($user->phone)) echo "<p class='hidden-sm'><i class='fa fa-phone'></i> <abbr title='Phone'>P</abbr>: {$user->phone}</p>";
                                    if(!empty($user->phone)) echo "<p class='visible-sm pad-left'><abbr title='{$user->phone}'><i class='fa fa-phone'></i> P</abbr> </p>";
                                echo "</div>";
                                echo "<hr class='visible-xs'>";
                            if($rcnt == 3)
                            {
                                echo "</div>";
                                $rcnt = 1;
                            }
                            else
                            {
                                $rcnt ++;
                            }

                        }
                        if($rcnt < 4 && $rcnt > 1)
                        {
                            echo "</div>";
                        }
                    ?>
                </div> <!-- /.members -->
                <div class="tab-pane purple-text" name='Announcements' id="Announcements"><?=$chapter->description?></div>
                <div class="tab-pane purple-text" id="LocationSpecials" name='LocationSpecials'><?=$chapter->addDescription?></div>
            </div> <!-- /.tab-content -->
        </div> <!-- /.tabbable -->
    </div> <!-- /.col12 -->
</div> <!-- /.row -->
