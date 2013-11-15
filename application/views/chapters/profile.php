<div class='row pad-btm'>
    <div class='col-md-12'>
<?php
        echo "<center><h1 class='title purple-text'>{$chapter->name} Chapter</h1></center>";
?>
    </div> <!-- /.col12 -->
</div> <!-- /.row -->

<div class='row pad-btm'>
<?php
        if(empty($cp))
        {
            echo "<div class='col-sm-2'>";
                echo "<div class='img-thumbnail'>";
                    echo "<img src='http://bms.cgisolution.com/user/profileimg/150/5'>";
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
                    echo "<img src='http://bms.cgisolution.com/user/profileimg/150/{$cp->id}'>";
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
        <center></center>
    </div>
    <div class='col-sm-2'>
    </div>

</div>
<div class='row'>
    <div class='col-sm-12'>



<div class='tabbable'>
<ul class="nav nav-tabs">
  <li><a href="#Announcements" class='purple' data-toggle="tab">Announcements</a></li>
  <li><a href="#LocationSpecials" class='purple' data-toggle="tab">Location Specials</a></li>
  <li><a href="#Members" class='purple' data-toggle="tab">Members</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active purple-text" name='Announcements' id="Announcements">...</div>
  <div class="tab-pane purple-text" id="LocationSpecials" name='LocationSpecials'>This will list anything the Location wants to put out to the group.... specials, etc...</div>
  <div class="tab-pane purple-text" id="Members" name='Members'>
<?php

    $rcnt = 1;
        
    foreach($members as $r)
    {
        $user = $this->member_model->getUserInfo($r->userid);
        $id = $user->id;
        // print_r($user);

        if($rcnt == 1)
        {
            echo "<hr>";
            echo "<div class='row'>";
        }
            echo "<div class='col-sm-2'>";
                echo "<div class='img-thumbnail float-left'>";
                    echo "<img src='http://bms.cgisolution.com/user/profileimg/150/{$id}'>";
                echo "</div>";
            echo "</div>";
            echo "<div class='col-sm-2'>";
                echo "<h4 class='title'>{$user->companyName}</h4></br>";
                echo "{$user->firstName} {$user->lastName} </br>";
                echo "<a href='mailto:{$user->email}'>{$user->email}</a>";
            echo "</div>";
            $rcnt ++;
        if($rcnt == 4)
        {
            echo "</div>";
            $rcnt = 1;
        }
    }

?>
</div>
</div> <!-- /.tab-content -->
</div> <!-- /.tabbable -->

    </div> <!-- /.col12 -->
</div> <!-- /.row -->
