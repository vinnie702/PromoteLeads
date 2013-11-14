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
?>
            <ul class="list-unstyled list-inline list-social-icons">
              <li class="tooltip-social facebook-link"><a href="https://www.facebook.com/cgiSolution" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook-square fa-2x"></i></a></li>
              <li class="tooltip-social linkedin-link"><a href="https://www.linkedin.com/brandonvinall" data-toggle="tooltip" data-placement="top" title="LinkedIn"><i class="fa fa-linkedin-square fa-2x"></i></a></li>
              <!-- <li class="tooltip-social twitter-link"><a href="#twitter-profile" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter-square fa-2x"></i></a></li> -->
              <!-- <li class="tooltip-social google-plus-link"><a href="#google-plus-profile" data-toggle="tooltip" data-placement="top" title="Google+"><i class="fa fa-google-plus-square fa-2x"></i></a></li> -->
            </ul>

    </div> <!-- /.col3 -->
    <div class='col-md-6 profile-video pull-right'>
        <iframe width="640" height="360" src="//www.youtube.com/embed/2SL0-eQJHr0?rel=0" frameborder="0" allowfullscreen></iframe>
    </div>
</div> <!-- /.row -->
<div class='row'>
    <div class='col-md-12'>
<?php
        echo "<p>{$user->bio}";
?>
    </div> <!-- /.col12 -->
</div> <!-- /.row -->
