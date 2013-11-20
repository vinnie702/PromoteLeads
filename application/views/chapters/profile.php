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
                echo "<div class='img-thumbnail'>";
                    echo "<img src='https://bms.cgisolution.com/user/profileimg/150/5'>";
                echo "</div>";
            echo "</div>";
            echo "<div class='col-sm-3'>";
                echo "<center><h5 class='title'>Acting Chapter President</h5></center>";
                echo "<a href='/members/profile/5'><strong>George W Burroughs III</strong></a></br>";
                echo "Promote Leads President";
                echo "<p><i class='fa fa-phone'></i> <abbr title='Phone'>P</abbr>: (702) 530-0055</p>";
                echo "<p><i class='fa fa-envelope-o'></i> <abbr title='Email'>E</abbr>: <a href='mailto:george@promoteleads.com'>george@promoteleads.com</a></p>";
                echo "<p><i class='fa fa-globe'></i> <abbr title='Website'>W</abbr>: <a href='http://www.promoteleads.com'>Promote Leads</a></p>";
            echo "</div>";
        }
        else
        {
            echo "<div class='col-sm-2'>";
                echo "<div class='img-thumbnail'>";
                    echo "<img src='https://bms.cgisolution.com/user/profileimg/150/{$cp->id}'>";
                echo "</div>";
            echo "</div>";
            echo "<div class='col-sm-3'>";
                echo "<center><h5 class='title'>Chapter President</h5></center>";
                echo "<a href='/members/profile/{cp->id}'><strong>{$cp->firstName} {$cp->lastName}</strong></a></br>";
                echo "<p><i class='fa fa-phone'></i> <abbr title='Phone'>P</abbr>: {$cp->phone}</p>";
                echo "<p><i class='fa fa-envelope-o'></i> <abbr title='Email'>E</abbr>: <a href='mailto:{$cp->email}'>{$cp->email}</a></p>";
                echo "<p><i class='fa fa-globe'></i> <abbr title='Website'>W</abbr>: <a href='{$cp->companyWebsiteUrl}'>{$cp->companyName}</a></p>";
            echo "</div>";
        }
?>

    <div class='col-sm-2'>
    </div>
    <div class='col-sm-3'>
<?php
        echo "<center>";
            echo "<h5 class='title'>{$chapter->name}</h5>";
        echo "</center>";
        echo "{$chapter->address} </br>";
        if(!empty($chapter->address2)) echo "{$chapter->address2} </br>";
        echo "{$chapter->city}, {$chapter->state} {$chapter->postalCode}";
    echo "</div>";
    echo "<div class='col-sm-2'>";
    $locationPic = $locationImg->fileName;
    echo "<div class='img-thumbnail'>";
            echo "<img src='https://bms.cgisolution.com/genimg/render/150?img=" .urlencode($locationPic) . "&path=" .urlencode("locationimgs") . "'>";
        echo "</div>";
    echo "</div>";
?>
</div>
<div class='row'>
    <div class='col-sm-12'>

<div class='tabbable'>
<ul class="nav nav-tabs">
  <li><a href="#Members" class='purple' data-toggle="tab">Members</a></li>
  <li><a href="#Announcements" class='purple' data-toggle="tab">Announcements</a></li>
  <li><a href="#LocationSpecials" class='purple' data-toggle="tab">Location Specials</a></li>
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
            echo "<hr>";
            echo "<div class='row'>";
        }
            echo "<div class='col-sm-2'>";
                echo "<a href='/members/profile/{$user->id}'><div class='img-thumbnail float-left'>";
                    echo "<img src='https://bms.cgisolution.com/user/profileimg/150/{$id}'>";
                echo "</div></a>";
            echo "</div>";
            echo "<div class='col-sm-2'>";
                echo "<h4 class='title'>{$user->companyName}</h4>";
                echo "<p><a href='/members/profile/{$user->id}'><strong>{$user->firstName} {$user->lastName}</strong></a></p>";
                echo "<p><i class='fa fa-envelope-o'></i> <abbr title='{$user->email}'>E</abbr>: <a href='mailto:{$user->email}'>E-Mail Me!</a></p>";
                if(!empty($user->phone)) echo "<p><i class='fa fa-phone'></i> <abbr title='Phone'>P</abbr>: {$user->phone}</p>";
            echo "</div>";
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
