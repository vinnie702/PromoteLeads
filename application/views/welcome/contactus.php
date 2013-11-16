    <!-- Page Content -->

    <div class="container">
      
      <div class="row">
      
        <div class="col-lg-12">
          <h1 class="page-header">Contact <small>We'd Love to Hear From You!</small></h1>
          <ul class="breadcrumb">
            <li><a href="/welcome">Home</a></li>
            <li class="active bc">Contact</li>
          </ul>
        </div>
        
        <div class="col-lg-12">
          <!-- Embedded Google Map using an iframe - to select your location find it on Google maps and paste the link as the iframe src. If you want to use the Google Maps API instead then have at it! -->
          <iframe width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=36.1438364,-115.2028972&amp;spn=56.506174,79.013672&amp;t=m&amp;z=17&amp;output=embed"></iframe>
        </div>

      </div><!-- /.row -->
      
      <div class="row">

<div class="col-sm-8">
<h3>Let's Get In Touch!</h3>
<p>Do you have something to say? We would love to hear it! Feel free to reach out to us and share any feedback or suggestions you may have! Promote Leads is always striving to be the best Networking Group out there and your feedback is what helps make that possible...</p>
<?php  
// check for a successful form post  
if (isset($_GET['s'])) echo "<div class=\"alert alert-success\">".$_GET['s']."</div>";  

// check for a form error
elseif (isset($_GET['e'])) echo "<div class=\"alert alert-danger\">".$_GET['e']."</div>";  

$attr = array
        (
            'name' => 'contactUs',
            'id' => 'contactUs',
            'method' => 'POST'
        );

echo form_open('welcome/saveContactForm', $attr);


?>
        <div class="row">
          <div class="form-group col-lg-4">
            <label for="input1">Name</label>
            <input type="text" name="name" class="form-control" id="name">
          </div>
          <div class="form-group col-lg-4">
            <label for="input2">Email Address</label>
            <input type="text" name="email" class="form-control" id="email">
          </div>
          <div class="form-group col-lg-4">
            <label for="input3">Phone Number</label>
            <input type="phone" name="phone" class="form-control" id="phone">
          </div>
          <div class="clearfix"></div>
          <div class="form-group col-lg-12">
            <label for="input4">Message</label>
            <textarea name="message" class="form-control" rows="6" id="message"></textarea>
          </div>
          <div class="form-group col-lg-12">
            <input type="hidden" name="userid" value="">
            <input type="hidden" name="page" value="/welcome/contactus">
            <button type="submit" id='submitBtn' name='submitBtn' class="btn btn-primary">Submit</button>
          </div>
             </div>
        </form>
    </div>

    <div class="col-sm-4">
      <h3>Promote Leads</h3>
      <h4>The future of Business Networking</h4>
      <p>
        4535 W. Sahara Ave Suite #200.<br>
        Las Vegas, NV 89102<br>
      </p>
      <p><i class="fa fa-phone"></i> <abbr title="Phone">P</abbr>: (702) 530-0055</p>
      <p><i class="fa fa-envelope-o"></i> <abbr title="Email">E</abbr>: <a href="mailto:info@promoteleads.com">info@promoteleads.com</a></p>
      <p><i class="fa fa-clock-o"></i> <abbr title="Hours">H</abbr>: Monday - Friday: 9:00 AM to 5:00 PM</p>
      <ul class="list-unstyled list-inline list-social-icons">
        <li class="tooltip-social facebook-link"><a href="http://www.facebook.com/promoteleads" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook-square fa-2x"></i></a></li>
        <li class="tooltip-social linkedin-link"><a href="http://www.linkedin.com/promoteleads" data-toggle="tooltip" data-placement="top" title="LinkedIn"><i class="fa fa-linkedin-square fa-2x"></i></a></li>
        <li class="tooltip-social twitter-link"><a href="http://www.twitter.com/promoteleads" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter-square fa-2x"></i></a></li>
        <li class="tooltip-social google-plus-link"><a href="#google-plus-page" data-toggle="tooltip" data-placement="top" title="Google+"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
      </ul>
    </div>

  </div><!-- /.row -->

</div><!-- /.container -->

<div class="container">

