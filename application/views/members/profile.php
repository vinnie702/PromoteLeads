<div class='row'>
    <div class='col-md-3'>
        <div class='headshot'>
<?php
            echo "<img src='/public/img/bvinallHeadshot.jpg'>";
?>
        </div> <!-- /.headshot -->
    </div> <!-- /.col-md-3 -->
    <div class='col-md-3 profileInfo'>
<?php
            echo "<h2 class='purple-text'>{$user->firstName} {$user->lastName}</h2>";
            echo "<h3 class='title purple-text'>{$user->companyName}</h3>";
            echo "<strong><p>{$user->addressLine1}</p>";
            echo "<p>{$user->addressLine2}</p>";
            echo "<p>{$user->addressLine3}</p>";
            echo "<p>{$user->city}, {$user->state} {$user->postalCode}</p></strong>";
            if(!empty($user->phone)) echo "<p>Office: {$user->phone}</p>";
            if(!empty($user->mobile)) echo "<p>Mobile: {$user->mobile}</p>";
            if(!empty($user->fax)) echo "<p>Fax: {$user->fax}</p>";

            echo "<ul class='list-unstyled list-inline list-social-icons'>";
               if(!empty($user->facebookUrl)) echo "<li class='tooltip-social facebook-link'><a href='https://www.facebook.com/cgiSolution' data-toggle='tooltip' data-placement='top' title='Facebook'><i class='fa fa-facebook-square fa-2x'></i></a></li>";
               if(!empty($user->linkedInUrl)) echo "<li class='tooltip-social linkedin-link'><a href='https://www.linkedin.com/brandonvinall' data-toggle='tooltip' data-placement='top' title='LinkedIn'><i class='fa fa-linkedin-square fa-2x'></i></a></li>";
               if(!empty($user->twitterUrl)) echo "<li class='tooltip-social twitter-link'><a href='#twitter-profile' data-toggle='tooltip' data-placement='top' title='Twitter'><i class='fa fa-twitter-square fa-2x'></i></a></li>";
               if(!empty($user->googlePlusUrl)) echo "<li class='tooltip-social google-plus-link'><a href='#google-plus-profile' data-toggle='tooltip' data-placement='top' title='Google+'><i class='fa fa-google-plus-square fa-2x'></i></a></li>";
               if(!empty($user->companyWebsiteUrl)) echo "<li class='tooltip-social linkedin-link'><a href='https://www.cgisolution.com' data-toggle='tooltip' data-placement='top' title='LinkedIn'><i class='fa fa-globe fa-2x'></i></a></li>";
               if(!empty($user->youtubeUrl)) echo "<li class='tooltip-social linkedin-link'><a href='https://www.cgisolution.com' data-toggle='tooltip' data-placement='top' title='LinkedIn'><i class='fa fa-youtube fa-2x'></i></a></li>";
            echo "</ul>";
?>
    </div> <!-- /.col3 -->
    <div class='col-md-6 profile-video pull-right'>
        <div class='profile-video'>
            <iframe width="100%" height="100%" src="//www.youtube.com/embed/2SL0-eQJHr0?rel=0" frameborder="0" allowfullscreen></iframe>
        </div> <!-- /.profileVideo -->
    </div> <!--/.col6 pull-right -->
</div> <!-- /.row -->
<div class='row'>
    <div class='col-md-12'>

<div class='tabbable'>
<ul class="nav nav-tabs">
  <li><a href="#Bio" class='purple' data-toggle="tab">Bio</a></li>
  <li><a href="#contactMember" class='purple' data-toggle="tab">Contact Me!</a></li>
  <li><a href="#Videos" class='purple' data-toggle="tab">Videos</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active OwnerBio purple-text" name='Bio' id="Bio">
<?php
        echo "<p>";
            echo nl2br($user->bio);
        echo "</p>";
?>
  </div>
  <div class="tab-pane CompanyBio purple-text" id="contactMember" name='contactMember'>Contact Me! (Yes George, I will put a form here today)</div>
  <div class="tab-pane Videos purple-text" id="Videos" name='Videos'>
<?php

    foreach($videos as $r)
    {
        $rcnt = 1;
        if($rcnt == 1)
        {
            echo "<div class='row'>";
        }
        $ytid = $this->functions->getYoutubeVideoID($r->url);
        echo <<< EOS
            <div class='ytContainer'>
                <div class='yt-body'>
                <iframe class='img-thumbnail' width="252" height="142" src="//www.youtube.com/embed/{$ytid}" frameborder="0" allowfullscreen></iframe>
                </div>

            </div>
EOS;
        if($rcnt == 4)
        {
            echo "</div>";
        }
    }
?>
</div>
</div> <!-- /.tab-content -->
</div> <!-- /.tabbable -->
    </div> <!-- /.col12 -->
</div> <!-- /.row -->
